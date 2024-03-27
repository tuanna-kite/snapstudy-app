@props(['webinarsComing'])

<style>
    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .swiper-slide-active>div {
        width: 100%;
    }

    .swiper-slide-prev>div,
    .swiper-slide-next>div {
        width: 90%;
        transform: scale(0.9)
        /* Scale the side items */
    }
</style>

<div class="assignment-container overflow-hidden">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <x-pages.home.assignments.card title='RMIT' />
        </div>
        <div class="swiper-slide">
            <x-pages.home.assignments.card title="Vin School" />
        </div>
        <div class="swiper-slide">
            <x-pages.home.assignments.card title="Hust" />
        </div>
        <div class="swiper-slide">
            <x-pages.home.assignments.card title="NEU" />
        </div>
        <!-- Add more slides as needed -->
    </div>
</div>

<script>
    var swiper = new Swiper('.assignment-container', {
        slidesPerView: '1',
        centeredSlides: true,
        speed: 1000,
        loop: true,
        autoplay: {
            delay: 2000, // milliseconds
            disableOnInteraction: false, // enable interaction to stop autoplay
        },
        breakpoints: {
            1024: {
                slidesPerView: 3,
            },
        }
        // Add other Swiper options as needed
    });
</script>
