<?php
    $listStatistic = [
        [
            'number' => '1200+',
            'title' => 'Assessment & Questions',
            'content' => 'We have access to all assessment details and test questions of your chosen courses',
            'color' => '#1684EA',
        ],
        [
            'number' => '1500+',
            'title' => 'Outlines',
            'content' => 'Unlock your assignments with the most detailed and comprehensive instructions',
            'color' => '#6544F9',
        ],
        [
            'number' => '50+',
            'title' => 'Experts',
            'content' => 'All the Outlines are proofreaded by our experts to ensure you a high score',
            'color' => '#54CE91',
        ],
        [
            'number' => '70%',
            'title' => 'Time Saved',
            'content' => 'Save your time to 70% and Boost your Efficiency to 180%',
            'color' => '#D04091',
        ],
    ];
?>

<section>
    <ul class="flex gap-8 flex-col md:flex-row">
        <?php $__currentLoopData = $listStatistic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pages.home.statistics.card','data' => ['data' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pages.home.statistics.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</section>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/home/statistics/index.blade.php ENDPATH**/ ?>