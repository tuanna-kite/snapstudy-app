<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['trending']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['trending']); ?>
<?php foreach (array_filter((['trending']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<article class="flex flex-col flex-1 shadow-lg px-5 py-6 rounded-2xl bg-white space-y-4">
    <a class="text-primary.main p-2 bg-primary.lighter w-fit rounded-md"><?php echo e($trending->category->title); ?></a>
    <p class="flex items-center space-x-2">
        <img src="<?php echo e(asset('img/logo/rmit-logo.png')); ?>" alt="rmit-logo" width="40px" height="40px">
        <span class="font-semibold text-sm text-text.light.primary">RMIT University</span>
    </p>
    <a href="<?php echo e($trending->getUrl()); ?>"
        class="text-primary.main font-semibold text-lg uppercase line-clamp-3"><?php echo e(clean($trending->title, 'title')); ?></a>
    <p class="text-text.light.primary text-sm line-clamp-3">
        <?php echo e($trending->seo_description); ?>

    </p>
</article>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/documents/document-card.blade.php ENDPATH**/ ?>