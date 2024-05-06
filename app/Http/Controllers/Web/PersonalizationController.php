<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mixins\Cashback\CashbackAccounting;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentChannel;
use App\Models\ReserveMeeting;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\Support;
use App\Models\SupportConversation;
use App\Models\SupportDepartment;
use App\Models\TicketUser;
use App\Models\Webinar;
use App\PaymentChannels\ChannelManager;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\UploadFileManager ;
use Illuminate\Support\Facades\Redirect;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PersonalizationController extends Controller
{
    public function createSupport(Request $request)
    {
        $user = auth()->user();
        validateParam($request->all(), [
            'message' => 'required|min:2',
            'attach' => 'required',
        ]);

        $attach=null ;
        if( $request->hasFile('attach')){
            $storage=new UploadFileManager($request->file('attach')) ;
            $attach=$storage->storage_path ;
        }

        $support = Support::create([
            'user_id' => $user->id,
            'title' => 'Set up personalized editing support',
            'webinar_id' => $request->input('course_id'),
            'department_id' => '4',
            'status' => 'open',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        SupportConversation::create([
            'support_id' => $support->id,
            'sender_id' => $user->id,
            'message' => $request->input('message'),
            'attach' => $attach,
            'created_at' => time(),
        ]);

        return $support;
    }

    public function directPersonalization(Request $request)
    {
        $user = auth()->user();

        if (!empty($user) and !empty(getFeaturesSettings('direct_classes_payment_button_status'))) {
            $this->validate($request, [
                'course_id' => 'required',
            ]);
            $this->createSupport($request);
            $data = $request->except('_token');

            $webinarId = $data['course_id'];
            $ticketId = $data['ticket_id'] ?? null;

            $webinar = Webinar::where('id', $webinarId)
                ->where('private', false)
                ->where('status', 'active')
                ->first();

            if (!empty($webinar)) {

                $fakeCarts = collect();

                $fakeCart = new Cart();
                $fakeCart->creator_id = $user->id;
                $fakeCart->webinar_id = $webinarId;
                $fakeCart->ticket_id = $ticketId;
                $fakeCart->special_offer_id = null;
                $fakeCart->created_at = time();

                $fakeCarts->add($fakeCart);

                $cartController = new CartController();

                return $cartController->checkout_v2($data, $fakeCarts, $webinar);
            }
        }

        abort(404);
    }

    public function paymentRequest(Request $request)
    {
        $this->validate($request, [
            'gateway' => 'required'
        ]);

        $user = auth()->user();
        $userId = $user->id;
        $gateway = $request->input('gateway');
        $amount = $request->input('amount', 10);
        $orderId = $request->input('order_id')."-".time();

        $order = Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->first();

        if ($gateway === 'captureWallet' || $gateway === 'payWithATM' || $gateway === 'payWithCC') {
            $respone = $this->payment($orderId, $gateway, $order->total_amount);
            if ($respone['resultCode'] == 0) {
                return redirect()->to($respone['payUrl']);
            } else {
                return view('web.default.pages.failCheckout');
            }
        } elseif ($gateway == 'paypal') {
            return $this->paypalPayment($order, $amount);
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

    public function paypalPayment($order, $amount)
    {

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('personalization.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "AUD",
                        "value" => $amount ?? 60,
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

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order = Order::where('payment_data', $request->token)->first();
            ;            $user = auth()->user();
            $userId = $user->id;
            $order->update([
                'payment_method' => Order::$credit
            ]);
            $this->setPaymentAccounting($order, 'paypalpay', $order->payment_data);
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
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            if($orderItem){
                $webinar = Webinar::find($orderItem->webinar_id);
                return redirect(route('course', ['slug' => $webinar->slug]));
            }
            return redirect('/payments/status');
        }
        return redirect()->route('paypal.cancel');
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
                $acc = Accounting::create([
                    'user_id' => $orderItem->user_id,
                    'order_item_id' => $orderItem->id,
                    'amount' => 60,
                    'webinar_id' => !empty($orderItem->webinar_id) ? $orderItem->webinar_id : null,
                    'bundle_id' => !empty($orderItem->bundle_id) ? $orderItem->bundle_id : null,
                    'meeting_time_id' => $orderItem->reserveMeeting ? $orderItem->reserveMeeting->meeting_time_id : null,
                    'subscribe_id' => $orderItem->subscribe_id ?? null,
                    'promotion_id' => $orderItem->promotion_id ?? null,
                    'registration_package_id' => $orderItem->registration_package_id ?? null,
                    'installment_payment_id' => $orderItem->installment_payment_id ?? null,
                    'product_id' => $orderItem->product_id ?? null,
                    'gift_id' => $orderItem->gift_id ?? null,
                    'type' => Accounting::$addiction,
                    'type_account' => Accounting::$asset,
                    'description' => trans('course.Syllabus support'),
                    'created_at' => time(),
                    'is_personalization' => 1,
                ]);

                if (!empty($orderItem->product_id)) {
                    $this->updateProductOrder($sale, $orderItem);
                }
            }
        }

        Cart::emptyCart($order->user_id);
    }
}
