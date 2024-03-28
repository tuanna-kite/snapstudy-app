
<nav x-data="{ isScrolled: false, lastScrollTop: 0 }"
     x-on:scroll.window="
       let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
       isScrolled = currentScroll > lastScrollTop && currentScroll > 80;
       lastScrollTop = currentScroll;
     "
     :class="{'transition-transform duration-300 ease-in-out transform -translate-y-full': isScrolled, 'transition-transform duration-300 ease-in-out transform translate-y-0' :!isScrolled }"
     class="sticky top-0 z-10 bg-white shadow">
    <div class="container mx-auto flex justify-between items-center h-20">
        <a href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('img/logo/logo.png')); ?>" alt="Logo">
        </a>

        <?php if(auth()->check()): ?>
            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.component.group-icon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.group-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-8 bg-primary.main">
                <span class="font-medium text-sm text-white">Login</span>
            </a>
        <?php endif; ?>
    </div>
</nav>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/layouts/navbar.blade.php ENDPATH**/ ?>