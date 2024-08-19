<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateways\NinePayController;
use App\Http\Controllers\Gateways\VnpayController;
use App\Mixins\Cashback\CashbackAccounting;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\PromotionCode;
use App\Models\ReserveMeeting;
use App\Models\Reward;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TicketUser;
use App\Models\Webinar;
use App\PaymentChannels\ChannelManager;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    protected $order_session_key = 'payment.order_id';
    protected $ninepaycontroller;

    protected $vnpayController;

    public function __construct(NinePayController $ninepaycontroller, VnpayController $vnpayController)
    {
        $this->ninepaycontroller = $ninepaycontroller;
        $this->vnpayController = $vnpayController;
    }

    public function paymentRequest(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required'
        ]);

        $user = auth()->user();
        $userId = $user->id;
        $gateway = $request->input('gateway');
        $orderId = $request->input('order_id')."-".time();
        $promo_code = $request->input('promo_code');
        Log::info($promo_code);

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();
        if ($promo_code){
            $promoCode = PromotionCode::where('code', $promo_code)->first();
            if ($promoCode->isValid()){
                $discount = ($promoCode->discount * $order->amount)/100;
                $price = $order->amount - $discount;
                $order->total_discount = $discount;
                $order->total_amount = $price;
                $order->promotion_code = $promo_code;
                $order->save();
            }
            foreach ($order->orderItems as $orderItem) {
                $orderItem->discount = $discount;
                $orderItem->total_amount = $price;
                $orderItem->save();
            }
        }

        if ($order->type === Order::$meeting) {
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
            $reserveMeeting->update(['locked_at' => time()]);
        }

        if ($gateway === 'credit') {
            if ($user->getAccountingCharge() < $order->total_amount) {
                $order->update(['status' => Order::$fail]);
                session()->put($this->order_session_key, $order->id);
                return redirect('/payments/status');
            }

            $order->update([
                'payment_method' => Order::$credit
            ]);

            $this->setPaymentAccounting($order, 'credit');

            $order->update([
                'status' => Order::$paid
            ]);

            $getUser = User::find($userId);
            $score = RewardAccounting::where('user_id', $userId)->sum('score');
            $groups = Group::where('min_score', '<=', $score)
                ->where('max_score', '>=', $score)
                ->get();
            $groupUser = GroupUser::where('user_id', $getUser->id)->first();

            if ($groupUser != null) {
                $groupUser->group_id = $groups->first()->id;
                $groupUser->save();
            } else {
                GroupUser::create([
                    'group_id' => $groups->first()->id,
                    'user_id' => $getUser->id,
                ]);
            }

            session()->put($this->order_session_key, $order->id);
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            if($orderItem){
                $webinar = Webinar::find($orderItem->webinar_id);
                return redirect( $webinar->type == 'quizz' ? route('quizzes', ['slug' => $webinar->slug]) : route('course', ['slug' => $webinar->slug]));
            }
            return redirect('/payments/status');
        } elseif ($gateway === 'captureWallet' || $gateway === 'payWithATM' || $gateway === 'payWithCC') {
            $respone = $this->payment($orderId, $gateway, $order->total_amount);
            if ($respone['resultCode'] == 0) {
                return redirect()->to($respone['payUrl']);
            } else {
                return view('web.default.pages.failCheckout');
            }
        } elseif ($gateway == 'paypal') {
            return $this->paypalPayment($order);
        } elseif ($gateway == '9PAY' || $gateway == 'CREDIT_CARD' || $gateway === 'ATM_CARD') {
            $this->ninepaycontroller->createPayment($orderId, $order->total_amount, $gateway);
        }
        elseif ($gateway == 'VNPAY') {
            $vpnUrl = $this->vnpayController->renderPaymentLink($orderId, $order->total_amount);
        }

        $paymentChannel = PaymentChannel::where('id', $gateway)
            ->where('status', 'active')
            ->first();

        if (!$paymentChannel) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('public.channel_payment_disabled'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }

        $order->payment_method = Order::$paymentChannel;
        $order->save();


        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $redirect_url = $channelManager->paymentRequest($order);

            if (in_array($paymentChannel->class_name, PaymentChannel::$gatewayIgnoreRedirect)) {
                return $redirect_url;
            }

            return Redirect::away($redirect_url);
        } catch (\Exception $exception) {

            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return back()->with(['toast' => $toastData]);
        }
    }

    public function paypalPayment($order)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "AUD",
                        "value" => $order->total_amount,
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    $order->payment_data = $response['id'];
                    $order->save();
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }
    }

    public function payment($orderId, $gateway, $total_amount)
    {
        $endpoint = env('MOMO_API_ENDPOINT');

        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $serectkey = env('MOMO_SECRET_KEY');
        $orderInfo = "Thanh toán qua MoMo";
        $amount = intval($total_amount) < 1000 ? 1000 : intval($total_amount);
        $orderId = $orderId;
        $redirectUrl = route('momo.checkout', ['gateway' => $gateway, 'orderId' => $orderId]);
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = "";
        $requestId = "HL_".time();
        $requestType = $gateway;


        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=".$accessKey."&amount=".$amount."&extraData=".$extraData."&ipnUrl=".$ipnUrl."&orderId=".$orderId."&orderInfo=".$orderInfo."&partnerCode=".$partnerCode."&redirectUrl=".$redirectUrl."&requestId=".$requestId."&requestType=".$requestType;
        Log::info('Payment request signature: ' . $rawHash);
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        Log::info('Payment request requestid: ' . $requestId );

        return $jsonResult;
    }

    public function checkout($gateway, $orderId)
    {
        $secretKey = env('MOMO_SECRET_KEY');
        $accessKey = env('MOMO_ACCESS_KEY');

        $partnerCode = $_GET["partnerCode"];
        $requestId = $_GET["requestId"];
        $amount = $_GET["amount"];
        $orderInfo = $_GET["orderInfo"];
        $orderType = $_GET["orderType"];
        $transId = $_GET["transId"];
        $resultCode = $_GET["resultCode"];
        $message = $_GET["message"];
        $payType = $_GET["payType"];
        $responseTime = $_GET["responseTime"];
        $extraData = $_GET["extraData"];
        $m2signature = $_GET["signature"]; //MoMo signature
        Log::info('Thanh toan khoa hoc: '.$requestId);
        //Checksum
        $rawHash = "accessKey=".$accessKey."&amount=".$amount."&extraData=".$extraData."&message=".$message."&orderId=".$orderId."&orderInfo=".$orderInfo.
            "&orderType=".$orderType."&partnerCode=".$partnerCode."&payType=".$payType."&requestId=".$requestId."&responseTime=".$responseTime.
            "&resultCode=".$resultCode."&transId=".$transId;
        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        if ($m2signature == $partnerSignature) {
            if ($resultCode == 0) {
                $id = explode("-", $orderId)[0];
                $order = Order::where('id', $id)
                    ->first();
                $user = auth()->user();
                $userId = !empty($user) ? $user->id : $order->user_id;
                if ($order->type === Order::$meeting) {
                    $orderItem = OrderItem::where('order_id', $order->id)->first();
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    $reserveMeeting->update(['locked_at' => time()]);
                }

                if ($gateway === 'captureWallet' || $gateway === 'payWithATM' || $gateway === 'payWithCC') {
                    $order->update([
                        'payment_method' => Order::$credit
                    ]);
                    $this->setPaymentAccounting($order, 'momopay', $requestId);
                    $order->update([
                        'status' => Order::$paid
                    ]);
                    if (!empty($order->promotion_code)){
                        $promo_code = PromotionCode::where('code', $order->promotion_code)->first();
                        $promo_code->is_used = 1;
                        $promo_code->save();
                    }
                    $getUser = User::find($userId);
                    $score = RewardAccounting::where('user_id', $userId)->sum('score');
                    $groups = Group::where('min_score', '<=', $score)
                        ->where('max_score', '>=', $score)
                        ->get();
                    $groupUser = GroupUser::where('user_id', $getUser->id)->first();

                    Log::info('Payment checkout order: ' . json_encode($order));
                    if ($groupUser != null) {
                        $groupUser->group_id = $groups->first()->id;
                        $groupUser->save();
                    } else {
                        GroupUser::create([
                            'group_id' => $groups->first()->id,
                            'user_id' => $getUser->id,
                        ]);
                    }

                    session()->put($this->order_session_key, $order->id);
                    $orderItem = OrderItem::where('order_id', $order->id)->first();
                    if($orderItem){
                        $webinar = Webinar::find($orderItem->webinar_id);
                        return redirect( $webinar->type == 'quizz' ? route('quizzes', ['slug' => $webinar->slug]) : route('course', ['slug' => $webinar->slug]));
                    }
                    return redirect('/payments/status');
                }

                $paymentChannel = PaymentChannel::where('id', $gateway)
                    ->where('status', 'active')
                    ->first();

                if (!$paymentChannel) {
                    $toastData = [
                        'title' => trans('cart.fail_purchase'),
                        'msg' => trans('public.channel_payment_disabled'),
                        'status' => 'error'
                    ];
                    return back()->with(['toast' => $toastData]);
                }

                $order->payment_method = Order::$paymentChannel;
                $order->save();

                try {
                    $channelManager = ChannelManager::makeChannel($paymentChannel);
                    $redirect_url = $channelManager->paymentRequest($order);

                    if (in_array($paymentChannel->class_name, PaymentChannel::$gatewayIgnoreRedirect)) {
                        return $redirect_url;
                    }

                    return Redirect::away($redirect_url);
                } catch (\Exception $exception) {
                }
            } else {
                return view('web.default.pages.failCheckout');
            }
        }
        return view('web.default.pages.failCheckout');
    }

    public function paymentVerify(Request $request, $gateway)
    {
        $paymentChannel = PaymentChannel::where('class_name', $gateway)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);
            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);
        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }

    /*
     * | this methode only run for payku.result
     * */
    public function paykuPaymentVerify(Request $request, $id)
    {
        $paymentChannel = PaymentChannel::where('class_name', PaymentChannel::$payku)
            ->where('status', 'active')
            ->first();

        try {
            $channelManager = ChannelManager::makeChannel($paymentChannel);

            $request->request->add(['transaction_id' => $id]);

            $order = $channelManager->verify($request);

            return $this->paymentOrderAfterVerify($order);
        } catch (\Exception $exception) {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];
            return redirect('cart')->with(['toast' => $toastData]);
        }
    }

    private function paymentOrderAfterVerify($order)
    {
        if (!empty($order)) {

            if ($order->status == Order::$paying) {
                $this->setPaymentAccounting($order);

                $order->update(['status' => Order::$paid]);
            } else {
                if ($order->type === Order::$meeting) {
                    $orderItem = OrderItem::where('order_id', $order->id)->first();

                    if ($orderItem && $orderItem->reserve_meeting_id) {
                        $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();

                        if ($reserveMeeting) {
                            $reserveMeeting->update(['locked_at' => null]);
                        }
                    }
                }
            }

            session()->put($this->order_session_key, $order->id);

            return redirect('/payments/status');
        } else {
            $toastData = [
                'title' => trans('cart.fail_purchase'),
                'msg' => trans('cart.gateway_error'),
                'status' => 'error'
            ];

            return redirect('cart')->with($toastData);
        }
    }

    public function setPaymentAccounting($order, $type = null, $requestId = null)
    {
        $cashbackAccounting = new CashbackAccounting();

        if ($order->is_charge_account) {
            Accounting::charge($order, $requestId);

            $cashbackAccounting->rechargeWallet($order);
        } else {
            foreach ($order->orderItems as $orderItem) {
                $sale = Sale::createSales($orderItem, $order->payment_method);

                if (!empty($orderItem->reserve_meeting_id)) {
                    $reserveMeeting = ReserveMeeting::where('id', $orderItem->reserve_meeting_id)->first();
                    $reserveMeeting->update([
                        'sale_id' => $sale->id,
                        'reserved_at' => time()
                    ]);

                    $reserver = $reserveMeeting->user;

                    if ($reserver) {
                        $this->handleMeetingReserveReward($reserver);
                    }
                }

                if (!empty($orderItem->gift_id)) {
                    $gift = $orderItem->gift;

                    $gift->update([
                        'status' => 'active'
                    ]);

                    $gift->sendNotificationsWhenActivated($orderItem->total_amount);
                }

                if (!empty($orderItem->subscribe_id)) {
                    Accounting::createAccountingForSubscribe($orderItem, $type, $requestId);
                } elseif (!empty($orderItem->promotion_id)) {
                    Accounting::createAccountingForPromotion($orderItem, $type, $requestId);
                } elseif (!empty($orderItem->registration_package_id)) {
                    Accounting::createAccountingForRegistrationPackage($orderItem, $type, $requestId);

                    if (!empty($orderItem->become_instructor_id)) {
                        BecomeInstructor::where('id', $orderItem->become_instructor_id)
                            ->update([
                                'package_id' => $orderItem->registration_package_id
                            ]);
                    }
                } elseif (!empty($orderItem->installment_payment_id)) {
                    Accounting::createAccountingForInstallmentPayment($orderItem, $type);

                    $this->updateInstallmentOrder($orderItem, $sale);
                } else {
                    // webinar and meeting and product and bundle

                    Accounting::createAccounting($orderItem, $type, null , $requestId);
                    TicketUser::useTicket($orderItem);

                    if (!empty($orderItem->product_id)) {
                        $this->updateProductOrder($sale, $orderItem);
                    }
                }
            }
            // Set Cashback Accounting For All Order Items
            $cashbackAccounting->setAccountingForOrderItems($order->orderItems);
        }

        Cart::emptyCart($order->user_id);
    }

    public function payStatus(Request $request)
    {
        $orderId = $request->get('order_id', null);

        if (!empty(session()->get($this->order_session_key, null))) {
            $orderId = session()->get($this->order_session_key, null);
            session()->forget($this->order_session_key);
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->first();

        if (!empty($order)) {
            $data = [
                'pageTitle' => trans('public.cart_page_title'),
                'order' => $order,
            ];

            return view('web.default.cart.status_pay', $data);
        }

        return redirect('/panel/webinars/purchases');
    }

    private function handleMeetingReserveReward($user)
    {
        if ($user->isUser()) {
            $type = Reward::STUDENT_MEETING_RESERVE;
        } else {
            $type = Reward::INSTRUCTOR_MEETING_RESERVE;
        }

        $meetingReserveReward = RewardAccounting::calculateScore($type);

        RewardAccounting::makeRewardAccounting($user->id, $meetingReserveReward, $type);
    }

    private function updateProductOrder($sale, $orderItem)
    {
        $product = $orderItem->product;

        $status = ProductOrder::$waitingDelivery;

        if ($product and $product->isVirtual()) {
            $status = ProductOrder::$success;
        }

        ProductOrder::where('product_id', $orderItem->product_id)
            ->where(function ($query) use ($orderItem) {
                $query->where(function ($query) use ($orderItem) {
                    $query->whereNotNull('buyer_id');
                    $query->where('buyer_id', $orderItem->user_id);
                });

                $query->orWhere(function ($query) use ($orderItem) {
                    $query->whereNotNull('gift_id');
                    $query->where('gift_id', $orderItem->gift_id);
                });
            })
            ->update([
                'sale_id' => $sale->id,
                'status' => $status,
            ]);

        if ($product and $product->getAvailability() < 1) {
            $notifyOptions = [
                '[p.title]' => $product->title,
            ];
            sendNotification('product_out_of_stock', $notifyOptions, $product->creator_id);
        }
    }

    private function updateInstallmentOrder($orderItem, $sale)
    {
        $installmentPayment = $orderItem->installmentPayment;

        if (!empty($installmentPayment)) {
            $installmentOrder = $installmentPayment->installmentOrder;

            $installmentPayment->update([
                'sale_id' => $sale->id,
                'status' => 'paid',
            ]);

            /* Notification Options */
            $notifyOptions = [
                '[u.name]' => $installmentOrder->user->full_name,
                '[installment_title]' => $installmentOrder->installment->main_title,
                '[time.date]' => dateTimeFormat(time(), 'j M Y - H:i'),
                '[amount]' => handlePrice($installmentPayment->amount),
            ];

            if ($installmentOrder and $installmentOrder->status == 'paying' and $installmentPayment->type == 'upfront') {
                $installment = $installmentOrder->installment;

                if ($installment) {
                    if ($installment->needToVerify()) {
                        $status = 'pending_verification';

                        sendNotification("installment_verification_request_sent", $notifyOptions,
                            $installmentOrder->user_id);
                        sendNotification("admin_installment_verification_request_sent", $notifyOptions, 1); // Admin
                    } else {
                        $status = 'open';

                        sendNotification("paid_installment_upfront", $notifyOptions, $installmentOrder->user_id);
                    }

                    $installmentOrder->update([
                        'status' => $status
                    ]);

                    if ($status == 'open' and !empty($installmentOrder->product_id) and !empty($installmentOrder->product_order_id)) {
                        $productOrder = ProductOrder::query()->where('installment_order_id', $installmentOrder->id)
                            ->where('id', $installmentOrder->product_order_id)
                            ->first();

                        $product = Product::query()->where('id', $installmentOrder->product_id)->first();

                        if (!empty($product) and !empty($productOrder)) {
                            $productOrderStatus = ProductOrder::$waitingDelivery;

                            if ($product->isVirtual()) {
                                $productOrderStatus = ProductOrder::$success;
                            }

                            $productOrder->update([
                                'status' => $productOrderStatus
                            ]);
                        }
                    }
                }
            }

            if ($installmentPayment->type == 'step') {
                sendNotification("paid_installment_step", $notifyOptions, $installmentOrder->user_id);
                sendNotification("paid_installment_step_for_admin", $notifyOptions, 1); // For Admin
            }
        }
    }

    public function ninePayResult(Request $request) {
        $keychecksum = env('9PAY_KEY_CHECKSUM');
        $result = $request->query('result');
        $checksum = $request->query('checksum');
        $user = auth()->user();

        $data = json_decode(base64_decode($result), true);

        $expectedChecksum = strtoupper(hash('sha256', $result . $keychecksum));

        if ($checksum !== $expectedChecksum) {
            return view('web.default.pages.failCheckout');
        }


        if ($data['status'] == 5) {
            $id = explode("-", $data['invoice_no'])[0];
            $order = Order::where('id', $id)
                ->first();
            $user = auth()->user();
            $userId = !empty($user) ? $user->id : $order->user_id;
            $order->update([
                'payment_method' => Order::$credit
            ]);
            $this->setPaymentAccounting($order, '9pay', $data['payment_no']);
            $order->update([
                'status' => Order::$paid
            ]);
            if (!empty($order->promotion_code)){
                $promo_code = PromotionCode::where('code', $order->promotion_code)->first();
                $promo_code->is_used = 1;
                $promo_code->save();
            }
            $getUser = User::find($userId);
            $score = RewardAccounting::where('user_id', $userId)->sum('score');
            $groups = Group::where('min_score', '<=', $score)
                ->where('max_score', '>=', $score)
                ->get();
            $groupUser = GroupUser::where('user_id', $getUser->id)->first();

            Log::info('Payment checkout order: ' . json_encode($order));
            if ($groupUser != null) {
                $groupUser->group_id = $groups->first()->id;
                $groupUser->save();
            } else {
                GroupUser::create([
                    'group_id' => $groups->first()->id,
                    'user_id' => $getUser->id,
                ]);
            }

            session()->put($this->order_session_key, $order->id);
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            if ($orderItem) {
                $webinar = Webinar::find($orderItem->webinar_id);
                return redirect( $webinar->type == 'quizz' ? route('quizzes', ['slug' => $webinar->slug]) : route('course', ['slug' => $webinar->slug]));
            }
            return redirect('/payments/status');

            return response()->json(['message' => 'Payment successful']);
        } else {
            return view('web.default.pages.failCheckout');
        }
    }

    public function vnpayResult(Request $request) {
        Log::info($request->all());
        dd($request->all());
        $orderId = $request->vnp_TxnRef;

        if ($request->vnp_ResponseCode != "00") {
            return view('web.default.pages.failCheckout');
        }

            $id = explode("-", $orderId);
            $order = Order::where('id', $id)
                ->first();
            $user = auth()->user();
            $userId = !empty($user) ? $user->id : $order->user_id;
            $order->update([
                'payment_method' => Order::$credit
            ]);
            $this->setPaymentAccounting($order, '9pay', $orderId);
            $order->update([
                'status' => Order::$paid
            ]);
            if (!empty($order->promotion_code)){
                $promo_code = PromotionCode::where('code', $order->promotion_code)->first();
                $promo_code->is_used = 1;
                $promo_code->save();
            }
            $getUser = User::find($userId);
            $score = RewardAccounting::where('user_id', $userId)->sum('score');
            $groups = Group::where('min_score', '<=', $score)
                ->where('max_score', '>=', $score)
                ->get();
            $groupUser = GroupUser::where('user_id', $getUser->id)->first();

            Log::info('Payment checkout order: ' . json_encode($order));
            if ($groupUser != null) {
                $groupUser->group_id = $groups->first()->id;
                $groupUser->save();
            } else {
                GroupUser::create([
                    'group_id' => $groups->first()->id,
                    'user_id' => $getUser->id,
                ]);
            }

            session()->put($this->order_session_key, $order->id);
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            if ($orderItem) {
                $webinar = Webinar::find($orderItem->webinar_id);
                return redirect( $webinar->type == 'quizz' ? route('quizzes', ['slug' => $webinar->slug]) : route('course', ['slug' => $webinar->slug]));
            }
            return redirect('/payments/status');
    }

    public function handleIPN(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $inputData = $request->except(['vnp_SecureHash']);

        // Sắp xếp dữ liệu theo thứ tự alphabet
        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . '=' . urlencode($value);
        }

        // Tạo chữ ký từ dữ liệu đã sắp xếp
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnp_SecureHash = $request->input('vnp_SecureHash');

        // Khởi tạo dữ liệu trả về
        $returnData = ['RspCode' => '99', 'Message' => 'Unknown error'];

        try {
            if ($secureHash == $vnp_SecureHash) {
                // Kiểm tra đơn hàng
                $orderId = $request->input('vnp_TxnRef');

                $id = explode("-", $orderId);
                $order = Order::where('id', $id)
                    ->first();
                $order->update([
                    'payment_method' => Order::$credit
                ]);
                $this->setPaymentAccounting($order, '9pay', $orderId);
                $order->update([
                    'status' => Order::$paid
                ]);
                $returnData = ['RspCode' => '00', 'Message' => 'Confirm Success'];


            } else {
                $returnData = ['RspCode' => '97', 'Message' => 'Invalid signature'];
            }
        } catch (\Exception $e) {
            Log::error('Error processing VNPAY IPN: ' . $e->getMessage());
            $returnData = ['RspCode' => '99', 'Message' => 'Unknown error'];
        }

        // Trả về kết quả dưới dạng JSON
        return response()->json($returnData);
    }
}
