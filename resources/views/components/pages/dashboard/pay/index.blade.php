<form action="{{ route('charge.pay') }}" method="post" enctype="multipart/form-data" class="mt-25">
    @csrf
    <div class="p-4 md:p-6 rounded-3xl bg-white">
    <div>
        <h2 class="text-base font-semibold text-primary.main mb-2">
            {{ trans('panel.amount') }}
        </h2>
        <div class="flex gap-3 mb-10">
            <div
                class="flex flex-1 justify-between items-center border border-solid text-text.light.disabled py-1.5 px-3 rounded-xl">
                <input type="number" placeholder="{{ trans('panel.number_only') }}" name="amount" min="10000" class="flex-1 @error('amount') is-invalid @enderror"
                value="{{ !empty($editOfflinePayment) ? $editOfflinePayment->amount : old('amount') }}">
                <div class="px-2 pb-0.5 rounded-full bg-gray-300">
                    <span class="text-xs font-bold text-gray-800">
                        VNĐ
                    </span>
                </div>
            </div>
            <button class="px-4 py-1.5 bg-primary.main rounded-xl">
                <span class="text-white text-sm font-medium">
                    {{ trans('public.send_require') }}
                </span>
            </button>
        </div>
        <div>
            <h2 class="text-base font-semibold text-text.light.secondary">
                Account Balance
            </h2>
            <p class="font-bold text-3xl text-secondary.main">
                {{ $accountCharge ? handlePrice($accountCharge) : 0 }} VNĐ
            </p>
        </div>

    </div>
</div>
</form>
