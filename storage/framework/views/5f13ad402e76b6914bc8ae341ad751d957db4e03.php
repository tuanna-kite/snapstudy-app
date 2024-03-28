<?php
    $listMajor = [
        [
            'link' => '/classes?subjectOptions%5B%5D=Business+Foundation',
            'icon' => 'major-icon0',
            'content' => 'Business Foundation',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon10',
            'content' => 'Digital Marketing',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Professional+Communication',
            'icon' => 'major-icon1',
            'content' => 'Professional Communication',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Economics+Finance',
            'icon' => 'major-icon2',
            'content' => 'Economics Finance',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Logistics+and+Supply+Chain',
            'icon' => 'major-icon3',
            'content' => 'Logistics Supply Chain',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=People+%26+Organisation',
            'icon' => 'major-icon4',
            'content' => 'People & Organisation',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Global+Business',
            'icon' => 'major-icon5',
            'content' => 'Global - Business',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Management+%26+Change',
            'icon' => 'major-icon6',
            'content' => 'Management & Change',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=IT',
            'icon' => 'major-icon7',
            'content' => 'Blockchain Enabled Business',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon8',
            'content' => 'Digital Film & Video',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Fashion+Enterprise',
            'icon' => 'major-icon9',
            'content' => 'Fashion Enterprise',
        ],
    ];
?>


<section>
    <ul class="flex flex-wrap justify-center gap-4">
        <?php $__currentLoopData = $listMajor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $majorItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pages.home.majors.card','data' => ['major' => $majorItem]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('pages.home.majors.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['major' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($majorItem)]); ?>
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
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/home/majors/index.blade.php ENDPATH**/ ?>