<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['data']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['data']); ?>
<?php foreach (array_filter((['data']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="flex flex-col gap-4 text-center">
    <div>
        <span class="text-4xl font-extrabold" style="color:<?php echo e($data['color']); ?>">
            <?php echo e($data['number']); ?>

        </span>
    </div>
    <div>
        <span class="text-base font-semibold" style="color:#032482">
            <?php echo e($data['title']); ?>

        </span>
    </div>
    <div>
        <span class="text-sm font-medium">
            <?php echo e($data['content']); ?>

        </span>
    </div>
</div>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/home/statistics/card.blade.php ENDPATH**/ ?>