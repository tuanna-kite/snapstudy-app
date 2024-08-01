<div class="rounded-3xl h-full bg-white shadow-lg">
    <div class="py-8 px-6 space-y-4">
        {{--        <a class="text-primary.main p-2 bg-primary.lighter w-fit rounded-md"> --}}
        {{--            --}}{{-- {{ $trending->category->title }} --}}
        {{--            Business Foundation --}}
        {{--        </a> --}}
        <p class="flex items-center space-x-2">
            <img src="{{ asset('img/logo/rmit-logo.png') }}" alt="rmit-logo" width="40px" height="40px">
            <span class="font-semibold text-sm text-text.light.primary"> {{ $webinar->category->title }}</span>
        </p>
        <a href="#" class="text-primary.main font-semibold text-base uppercase line-clamp-3">
            {{ clean($webinar->title, 'title') }}
        </a>
        <p class="text-text.light.primary text-xs line-clamp-3">
            {{ $webinar->seo_description }}
        </p>
        <div class="w-full flex justify-between border-text.light.disabled border rounded-xl px-4 py-3 my-4">
            <input placeholder="Promo Code" name="promo_code" id="promo_code" class="placeholder-text.light.disabled text-base flex-1" />
            <button type="button" class="px-2 py-1 bg-grey-300 rounded-md" id="apply-promo-code">
                <span class="font-bold text-xs text-text.light.primary">Apply</span>
            </button>
        </div>
        <div class="space-y-2 mb-6">
            <div class="w-full flex justify-between">
                <p class="text-sm text-text.light.secondary">Subtotal</p>
                <p class="text-sm text-text.light.primary" id="total-amount">{{ handlePrice($webinar->price) }}</p>
            </div>
            <div class="w-full flex justify-between">
                <p class="text-sm text-text.light.secondary">Discount</p>
                <p class="text-sm text-red-500" id="discount-amount">0 VNĐ</p>
            </div>
        </div>
    </div>
    <hr class="border-t-1 border-gray-300 w-full">
    <div class="flex justify-between items-center p-6">
        <p class="font-bold text-lg text-text.light.primary">Total:</p>
        <p class="font-bold text-lg text-primary.main" id="total">
            {{ handlePrice($webinar->price) }}
        </p>
    </div>
</div>
@push('scripts_bottom')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#apply-promo-code').on('click', function() {
            let promoCode = $('#promo_code').val();
            let price = {{ $webinar->price }};
            $.ajax({
                url: '{{ route('apply.promotion.code') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    promo_code: promoCode,
                    price : price
                },
                success: function(response) {
                    $('#promo-code-message').text(response.message);
                    if (response.success) {
                        // Cập nhật giá trị giảm giá và tổng tiền nếu cần
                        $('#discount-amount').text('-' + response.discount);
                        $('#total').text(response.total);
                    }
                },
                error: function(xhr) {
                    $('#promo-code-message').text('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });
    });
</script>
@endpush
