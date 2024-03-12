<?php $__env->startPush('styles_top'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <section class="cart-banner position-relative text-center">
        <h1 class="font-30 text-white font-weight-bold"><?php echo e(trans('cart.checkout')); ?></h1>
        <span
            class="payment-hint font-20 text-white d-block"><?php echo e(handlePrice($total) . ' ' . trans('cart.for_items', ['count' => $count])); ?></span>
    </section>

    <section class="container mt-45">

        <?php if(!empty($totalCashbackAmount)): ?>
            <div class="d-flex align-items-center mb-25 p-15 success-transparent-alert">
                <div class="success-transparent-alert__icon d-flex align-items-center justify-content-center">
                    <i data-feather="credit-card" width="18" height="18" class=""></i>
                </div>

                <div class="ml-10">
                    <div class="font-14 font-weight-bold "><?php echo e(trans('update.get_cashback')); ?></div>
                    <div class="font-12 ">
                        <?php echo e(trans('update.by_purchasing_this_cart_you_will_get_amount_as_cashback', ['amount' => handlePrice($totalCashbackAmount)])); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
            $isMultiCurrency = !empty(getFinancialCurrencySettings('multi_currency'));
            $userCurrency = currency();
            $invalidChannels = [];
        ?>

        <h2 class="section-title"><?php echo e(trans('financial.select_a_payment_gateway')); ?></h2>

        <form action="/payments/payment-request" method="post" class=" mt-25">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <div class="row">
                

                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" <?php if(empty($userCharge) or $total > $userCharge): ?> disabled <?php endif; ?> name="gateway" id="offline"
                        value="credit">
                    <label for="offline"
                        class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/pay.svg" width="120" height="60" alt="">

                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            <?php echo e(trans('financial.account')); ?>

                            <span class="font-weight-bold"><?php echo e(trans('financial.charge')); ?></span>
                        </p>

                        <span class="mt-5"><?php echo e(handlePrice($userCharge)); ?></span>
                    </label>
                </div>

                <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                    <input type="radio" name="gateway" id="momopay"
                        value="momopay">
                    <label for="momopay"
                        class="rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                        <img src="/assets/default/img/activity/MoMo_Logo.png" width="120" height="60" alt="">

                        <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                            <?php echo e(trans('financial.pay_via')); ?>

                            <span class="font-weight-bold">Ví MoMo</span>
                        </p>
                        <span class="mt-5"><?php echo e(handlePrice($total)); ?></span>
                    </label>
                </div>
            </div>
            <?php if(!empty($invalidChannels)): ?>
                <div class="d-flex align-items-center mt-30 rounded-lg border p-15">
                    <div class="size-40 d-flex-center rounded-circle bg-gray200">
                        <i data-feather="info" class="text-gray" width="20" height="20"></i>
                    </div>
                    <div class="ml-5">
                        <h4 class="font-14 font-weight-bold text-gray"><?php echo e(trans('update.disabled_payment_gateways')); ?></h4>
                        <p class="font-12 text-gray"><?php echo e(trans('update.disabled_payment_gateways_hint')); ?></p>
                    </div>
                </div>

                <div class="row mt-20">
                    <?php $__currentLoopData = $invalidChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invalidChannel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-lg-4 mb-40 charge-account-radio">
                            <div
                                class="disabled-payment-channel bg-white border rounded-sm p-20 p-lg-45 d-flex flex-column align-items-center justify-content-center">
                                <img src="<?php echo e($invalidChannel->image); ?>" width="120" height="60" alt="">

                                <p class="mt-30 mt-lg-50 font-weight-500 text-dark-blue">
                                    <?php echo e(trans('financial.pay_via')); ?>

                                    <span class="font-weight-bold font-14"><?php echo e($invalidChannel->title); ?></span>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

            <div class="detail-payment-pc">
                <div class="d-flex align-items-center justify-content-between mt-45 ">
                    <span class="font-16 font-weight-500 text-gray"><?php echo e(trans('financial.total_amount')); ?>

                        <?php echo e(handlePrice($total)); ?></span>
                    <a href="/panel/financial/account"
                        class="font-16 btn btn-sm btn-primary"><?php echo e(trans('financial.top_up_your_wallet')); ?></a>
                    <button type="button" id="paymentSubmit" disabled
                        class="btn btn-sm btn-primary"><?php echo e(trans('public.start_payment')); ?></button>
                </div>
            </div>

            <div class="mt-45 detail-payment-mobile">
                <div class="my-2 ">
                    <div class="font-24 font-weight-700 text-gray total_amount"><?php echo e(trans('financial.total_amount')); ?> :
                    </div>
                    <div class="font-24 font-weight-700 text-gray total_amount"><?php echo e(handlePrice($total)); ?></div>
                </div>
                <input type="hidden" name="total_payment" value="<?php echo e($total); ?>" id="">
                <div class="d-flex align-items-center justify-content-between ">
                    <a href="/panel/financial/account"
                        class="font-16 btn btn-sm btn-primary"><?php echo e(trans('financial.top_up_your_wallet')); ?></a>
                    <button type="button"name="payUrl" id="paymentSubmit" disabled
                        class="btn btn-sm btn-primary"><?php echo e(trans('public.start_payment')); ?></button>
                </div>
            </div>
        </form>

        <?php if(!empty($razorpay) and $razorpay): ?>
            <form action="/payments/verify/Razorpay" method="get">
                <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

                <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php echo e(env('RAZORPAY_API_KEY')); ?>"
                    data-amount="<?php echo e((int) ($order->total_amount * 100)); ?>" data-buttontext="product_price" data-description="Rozerpay"
                    data-currency="<?php echo e(currency()); ?>" data-image="<?php echo e($generalSettings['logo']); ?>"
                    data-prefill.name="<?php echo e($order->user->full_name); ?>" data-prefill.email="<?php echo e($order->user->email); ?>"
                    data-theme.color="#43d477"></script>
            </form>
        <?php endif; ?>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts_bottom'); ?>
    <script src="/assets/default/js/parts/payment.min.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(getTemplate() . '.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/tuanna.kite/workspace/laravel-app/snapstudy-app/resources/views/web/default/cart/payment.blade.php ENDPATH**/ ?>