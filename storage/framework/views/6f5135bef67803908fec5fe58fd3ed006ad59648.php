<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['name']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['name']); ?>
<?php foreach (array_filter((['name']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>


<?php if(file_exists("img/icon/$name.svg")): ?>
    <img src="<?php echo e('img/icon/' . $name . '.svg'); ?>" alt="cart"
        <?php echo e($attributes->merge(['width' => 24, 'height' => 24])); ?>>
<?php else: ?>
    <img alt="no-icon">
<?php endif; ?>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/component/icon.blade.php ENDPATH**/ ?>