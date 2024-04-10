@php
    $methods = [
        [
            'name' => 'gateway',
            'img' => asset('img/visa.png'),
            'title' => 'Pay with card',
            'sub' => 'Visa, Master, JCB...',
            'value' => 'payWithCC',
        ],
        [
            'name' => 'gateway',
            'img' => asset('img/atm.png'),
            'title' => 'Pay with ATM',
            'sub' => 'by VNPay',
            'value' => 'payWithATM',
        ],
        [
            'name' => 'gateway',
            'img' => asset('img/momo.png'),
            'title' => 'Pay with MoMo',
            'sub' => 'MoMo Wallet',
            'value' => 'captureWallet',
        ],
    ];
@endphp

<div class="p-6 rounded-3xl bg-white shadow-lg">
    <h2 class="font-semibold text-base text-text.light.primary mb-6 ">Payment method</h2>
    <div>
        <form class="space-y-10"  action='{{ route('payment.request') }}' method="post">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach ($methods as $method)
                    <x-pages.payment.card-method :data="$method" />
                @endforeach
            </div>
            <button type="submit" class="rounded-lg px-6 py-1.5 bg-primary.main">
                <span class="font-medium text-sm text-white">
                    Start Payment
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
