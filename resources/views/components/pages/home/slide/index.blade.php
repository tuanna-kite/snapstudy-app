<!-- Slider main container -->
<section class="">
    <div class="section-container w-full overflow-hidden">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{ asset('img/hero-section(vi)1.jpg') }}" alt="slide-img" class="w-full">
            </div>
            <div class="swiper-slide">
                <img src="{{ asset('img/hero-section(vi)2.jpg') }}" alt="slide-img" class="w-full">
            </div>
        </div>
    </div>
</section>

@push('scripts_bottom')
    <script>
        var swiper = new Swiper('.section-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            // Autoplay
            autoplay: {
                delay: 2000, // milliseconds
                disableOnInteraction: false, // enable interaction to stop autoplay
            },
            // If we need pagination
            // pagination: {
            //     el: '.swiper-pagination',
            // },
            // // Navigation arrows
            // navigation: {
            //     nextEl: '.swiper-button-next',
            //     prevEl: '.swiper-button-prev',
            // },
        });
    </script>
@endpush
