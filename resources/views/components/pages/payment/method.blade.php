@props(['payment_type', 'order', 'amount'])
@php
//    $methods = [
//        [
//            'name' => 'gateway',
//            'img' => asset('img/visa.png'),
//            'title' => trans('payment.Pay with card'),
//            'sub' => 'Visa, Master, JCB...',
//            'value' => 'payWithCC',
//        ],
//        [
//            'name' => 'gateway',
//            'img' => asset('img/atm.png'),
//            'title' => trans('payment.Pay with ATM'),
//            'sub' => trans('payment.by Momo'),
//            'value' => 'payWithATM',
//        ],
//        [
//            'name' => 'gateway',
//            'img' => asset('img/momo.png'),
//            'title' => trans('payment.Pay with MoMo'),
//            'sub' => trans('payment.MoMo Wallet'),
//            'value' => 'captureWallet',
//        ],
//    ];
$methods = [
        [
            'name' => 'gateway',
            'img' => asset('img/visa.png'),
            'title' => trans('payment.Pay with card'),
            'sub' => 'Visa, Master, JCB...',
            'value' => 'paypal',
        ]
    ];

@endphp

<div class="p-6 rounded-3xl bg-white shadow-lg">
    <h2 class="font-semibold text-base text-text.light.primary mb-6 ">{{ trans('payment.Payment method') }}</h2>
    <div>
        <form class="space-y-10"
            action='{{ $payment_type == 'checkout' ? route('payment.request') : route('charge.pay') }}' method="post">
            @csrf
            @if ($payment_type == 'checkout')
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @else
                <input type="hidden" name="amount" value="{{ $amount }}">
            @endif
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach ($methods as $method)
                    <x-pages.payment.card-method :data="$method" />
                @endforeach
            </div>
            <button type="submit" class="rounded-lg px-6 py-1.5 bg-primary.main">
                <span class="font-medium text-sm text-white">
                    {{ trans('payment.Start Payment') }}
                </span>
            </button>
        </form>
    </div>
</div>

@push('scripts_bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radios = document.querySelectorAll('.radio');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const cards = document.querySelectorAll('.card');
                    cards.forEach(card => {
                        card.classList.remove('border-secondary.main');
                    });

                    if (this.checked) {
                        this.closest('.card').classList.add('border-secondary.main');
                        this.classList.add('ring-secondary.main');
                    }

                });
            });
        });
    </script>
@endpush
