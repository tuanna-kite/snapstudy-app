<?php $__env->startSection('title', 'Course Detail'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .table_contents h2 {
            display: none;
        }

        .table_contents ul li {
            color: #032482;
        }

        .table_contents ul li ul li {
            padding-left: 20px;
        }

        #document-content ul {
            padding-inline-start: 24px !important;
            list-style: square !important;
        }

        #document-content ul li {
            margin: 0 !important;
        }

        #document-content table {
            display: block;
            overflow: auto;
            white-space: nowrap;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.home-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layouts.home-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto space-y-6 md:px-4 max-w-[960px]">
                <h1 class="font-normal text-3xl text-text.light.primary">
                    <?php echo e($course->category->slug); ?>

                </h1>
                <h2 class="font-extrabold text-5xl text-primary.main">
                    <?php echo e($course->title); ?>

                </h2>
                <p class="font-normal text-base text-text.light.primary">
                    <?php echo e($course->seo_description); ?>

                </p>

                <p class="font-normal text-base text-text.light.primary">
                    <span class="font-semibold">1.332.107 </span> đã đăng ký
                </p>
            </div>
        </div>
        <div class="bg-white">
            <div class='container mx-auto py-16 space-y-16' x-data="{ scrolled: false }"
                @scroll.window="scrolled = (window.scrollY > document.getElementById('targetDiv').offsetTop + document.getElementById('targetDiv').offsetHeight)">
                
                <div x-data="{ openTab: 1 }" id="targetDiv" class="bg-white max-w-[960px] mx-auto">
                    <div class="border border-grey-300 rounded-2xl">
                        <div class="px-6 py-3 bg-primary.main rounded-t-2xl flex justify-between items-center text-white"
                            x-on:click="openTab !== 1 ? openTab = 1 : openTab = null">
                            <h6 class="font-bold text-xl">
                                Table of contents
                            </h6>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.component.material-icon','data' => ['name' => 'expand_more','xShow' => 'openTab === null']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.material-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'expand_more','x-show' => 'openTab === null']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.component.material-icon','data' => ['name' => 'expand_less','xShow' => 'openTab === 1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.material-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'expand_less','x-show' => 'openTab === 1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="table_contents px-6 py-4" x-show="openTab === 1">
                            <?php echo $docTrans->table_contents; ?>

                        </div>
                    </div>
                </div>
                
                <?php if($hasBought): ?>
                    <div x-show='scrolled'>
                        <div x-data="{ showModal: false, buttonPosition: { top: 0, right: 0 } }">
                            <!-- Button to toggle the modal -->
                            <button id="scrollBtn"
                                class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
                                @click="showModal = true; buttonPosition = $event.target.getBoundingClientRect()">
                                Table of Contents
                            </button>
                            <!-- Modal -->
                            <div x-show="showModal"
                                class="fixed z-10 bottom-16 right-0 w-3/5 bg-white h-1/2 overflow-y-auto shadow-xl rounded-l-xl max-w-[240px]"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-90"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90" @click.away="showModal = false">
                                <div class="table_contents bg-white p-6">
                                    <h3 class="text-lg my-4 font-semibold">Table of Contents</h3>
                                    <!-- Modal content -->
                                    <?php echo $docTrans->table_contents; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="space-y-6 max-w-[960px] mx-auto">
                    <h3 class="font-bold text-3xl text-primary.main">
                        Content
                    </h3>
                    <?php if(!$hasBought): ?>
                        <div id="document-content" class="relative">
                            <?php echo $docTrans->preview_content; ?>

                            <div class="h-40 w-full absolute bottom-0"
                                style="background: linear-gradient(360deg, #FFFFFF 0%, rgba(245, 246, 250, 0.1) 100%);">
                            </div>
                        </div>
                        <div class="flex flex-col items-center space-y-3">
                            <form method="post" action="/course/direct-payment">
                                <?php echo csrf_field(); ?>
                                <input class="hidden" type="number" name="item_id" value="<?php echo e($course->id); ?>">
                                <input class="hidden" type="text" name="item_name" value="webinar_id">
                                <button class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                    <span>Read more (<?php echo e(handlePrice($course->price)); ?>)</span>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.component.material-icon','data' => ['name' => 'arrow_downward']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('component.material-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'arrow_downward']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </button>
                            </form>
                            <p class="font-normal text-sm text-text.light.secondary">
                                Documents cannot be previewed. To view them in full, you need to pay a fee
                            </p>
                        </div>
                    <?php else: ?>
                        <div id="document-content" style="overflow: hidden; max-width: 100vw !important;">
                            <?php echo $docTrans->content; ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('web_v2.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/web_v2/pages/course-detail.blade.php ENDPATH**/ ?>