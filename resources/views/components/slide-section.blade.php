<!-- Slider main container -->
<section class="mt-20">
    <div class="section-container w-full overflow-hidden">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="img/hero_section.png" alt="slide-img" class="w-full">
            </div>
            <div class="swiper-slide">
                <img src="img/hero_section.png" alt="slide-img" class="w-full">
            </div>
            <div class="swiper-slide">
                <img src="img/hero_section.png" alt="slide-img" class="w-full">
            </div>
        </div>
        {{-- <!-- Add Pagination -->
        <div class="swiper-pagination"></div> --}}
        <!-- Add Arrows -->
        {{-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div> --}}
    </div>
</section>

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
