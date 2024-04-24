<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use App\Mixins\Cashback\CashbackAccounting;
use App\Models\Accounting;
use App\Models\BecomeInstructor;
use App\Models\Cart;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Order;
use App\Models\ReserveMeeting;
use App\Models\RewardAccounting;
use App\Models\Sale;
use App\Models\TicketUser;
use App\User;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    private $order_session_key = 'payment.order_id';
    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order = Order::where('payment_data', $request->token)->first();
            $user = auth()->user();
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

            session()->put($this->order_session_key, $order->id);
            return redirect('/payments/status');
        }
        return redirect()->route('paypal.cancel');
    }

    public function cancel(Request $request)
    {
        return view('web.default.pages.failCheckout');
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

                    Accounting::createAccounting($orderItem, $type);
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
}
