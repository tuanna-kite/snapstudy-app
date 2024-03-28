<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['webinarsComing']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['webinarsComing']); ?>
<?php foreach (array_filter((['webinarsComing']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

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

<?php if(count($webinarsComing) > 0): ?>
    <div class="assignment-container overflow-hidden">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $webinarsComing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webinarItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pages.home.assignments.card','data' => ['webinar' => $webinarItem]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pages.home.assignments.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['webinar' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($webinarItem)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>


<?php $__env->startPush('scripts_bottom'); ?>
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
<?php $__env->stopPush(); ?>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/home/assignments/slide.blade.php ENDPATH**/ ?>