<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['webinar']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['webinar']); ?>
<?php foreach (array_filter((['webinar']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="rounded-3xl p-5 flex flex-col gap-4 bg-white">
    <div class="rounded-lg p-2 bg-primary.lighter w-fit">
        <span class="font-normal text-xs text-primary.main"><?php echo e($webinar->category->title); ?></span>
    </div>
    <div class="flex items-center gap-2">
        <img src="<?php echo e(asset('img/logo/rmit-logo.png')); ?>" alt="logo-rmit" width="32" height="32">
        <span class="font-semibold text-sm text-text.light.primary">
            RMIT University
        </span>
    </div>
    <div class="line-clamp-1">
        <a href="<?php echo e($webinar->getUrl()); ?>">
            <span class="font-semibold text-base text-primary.main uppercase">
                
                <?php echo e($webinar->title); ?>

            </span>
        </a>
    </div>
    <div class="line-clamp-1">
        <span class="font-normal text-sm text-text.light.primary ">
            <?php echo e($webinar->seo_description); ?>

        </span>
    </div>
    <div class="flex justify-between items-center">
        <span class="font-medium text-xs text-text.light.primary">March 31,2024</span>
        <a href="#">
            <span class="font-medium text-sm text-text.light.disabled">
                See full outline >
            </span>
        </a>
    </div>
</div>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/home/assignments/card.blade.php ENDPATH**/ ?>