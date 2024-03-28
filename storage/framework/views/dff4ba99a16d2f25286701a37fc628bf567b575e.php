<?php
    $listMenu = [
        [
            'icon' => 'menu',
            'title' => 'Dashboard',
            'href' => '1',
        ],
        [
            'icon' => 'document-text',
            'title' => 'My Syllabus',
            'href' => '2',
        ],
        [
            'icon' => 'task',
            'title' => 'My Purchased',
            'href' => '3',
        ],
        [
            'icon' => 'wallet-minus',
            'title' => 'Financial',
            'href' => '4',
        ],
        [
            'icon' => 'device-message',
            'title' => 'Support',
            'href' => '5',
        ],
        [
            'icon' => 'setting-2',
            'title' => 'Setting Account',
            'href' => '6',
        ],
    ];
?>

<nav class="p-2 md:p-8 w-full h-full rounded-2xl flex flex-col items-center sm:items-start bg-white">
    <?php echo e($slot); ?>

    <ul class="flex flex-col gap-3 mt-10 w-full" x-data="{ openTab: null }">
        <?php $__currentLoopData = $listMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="w-full">
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.slidebar.card','data' => ['menuItem' => $menu]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('slidebar.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menuItem' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menu)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            </li>
            <?php if($loop->index === 4): ?>
                <hr class="border-t-1 border-gray-300">
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</nav>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/slidebar/index.blade.php ENDPATH**/ ?>