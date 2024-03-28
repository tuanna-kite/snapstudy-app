<form id="searchForm" action="/classes" method="GET"
    class="rounded-full pl-6 px-1 md:pr-0.5 py-0.5 h-11 bg-white shadow-lg flex items-center justify-between">
    <input id="searchInput" class="flex-1 p-1 focus:border-transparent" type="text" name="search"
        placeholder="Search a document...">
    <button type="submit" class="bg-primary.main rounded-full px-5 py-2 hidden md:block">
        <span class="font-medium text-sm text-white">
            Search
        </span>
    </button>
    <button type="submit" class="flex md:hidden">
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.component.material-icon','data' => ['name' => 'search']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.material-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    </button>
</form>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/search/search-doc.blade.php ENDPATH**/ ?>