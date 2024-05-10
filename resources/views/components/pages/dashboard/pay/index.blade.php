<form action="{{ route('course.directPayment') }}" method="post" class="mt-25">
    @csrf
    <div class="p-4 md:p-6 rounded-3xl bg-white">
        <div>
            <h2 class="text-base font-semibold text-primary.main mb-2">
                {{ trans('panel.amount') }}
            </h2>
            <div class="flex gap-3 mb-10">
                <div
                    class="flex flex-1 justify-between items-center border border-solid text-text.light.disabled py-1.5 px-3 rounded-xl">
                    <input type="text" name="amount" id="amount" value="" data-type="amount"
                        placeholder="{{ trans('panel.number_only') }}" min="10000"
                        class="flex-1 @error('amount') is-invalid @enderror"
                        value="{{ !empty($editOfflinePayment) ? $editOfflinePayment->amount : old('amount') }}">

                    <div class="px-2 pb-0.5 rounded-full bg-gray-300">
                        <span class="text-xs font-bold text-gray-800">
                            VNĐ
                        </span>
                    </div>
                </div>
                <button type="submit" class="px-4 py-1.5 bg-primary.main rounded-xl">
                    <span class="text-white text-sm font-medium">
                        {{ trans('public.send_require') }}
                    </span>
                </button>
            </div>
            <div>
                <h2 class="text-base font-semibold text-text.light.secondary">
                    {{ trans('dashboard.Account Balance') }}
                </h2>
                <p class="font-bold text-3xl text-secondary.main">
                    {{ $accountCharge ?? 0 }} AUD
                </p>
            </div>

        </div>
    </div>
</form>

@push('scripts_bottom')
    <script>
        document.querySelectorAll("input[data-type='amount']").forEach(function(input) {
            input.addEventListener('keyup', function() {
                formatCurrency(this);
            });
        });

        function formatNumber(n) {
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function formatCurrency(input, blur) {
            var input_val = input.value;
            if (input_val === "") {
                return;
            }
            var original_len = input_val.length;
            var caret_pos = input.selectionStart;

            if (input_val.indexOf(".") >= 0) {
                var decimal_pos = input_val.indexOf(".");
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);
                left_side = formatNumber(left_side);
                right_side = formatNumber(right_side);

                right_side = right_side.substring(0, 2);
                input_val = left_side + "." + right_side;
            } else {
                input_val = formatNumber(input_val);
                input_val = input_val;

            }
            input.value = input_val;
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input.setSelectionRange(caret_pos, caret_pos);
            console.log(input.value, "number test", 500)
        }
    </script>
@endpush
