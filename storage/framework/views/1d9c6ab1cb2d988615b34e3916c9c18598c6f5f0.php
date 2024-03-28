<?php
    $subjectOptions = [
        'Digital Marketing',
        'Professional Communication',
        'Logistics and Supply Chain',
        'Economics - Finance',
        'Economics',
        'Fashion Enterprise',
        'Management & Change',
        'People & Organisation',
        'Business-Foundation',
    ];
    $schoolOptions = ['RMIT', 'VinUniversity', 'MIT', 'Yale', 'Harvard'];
?>

<div>
    <form id="filterForm" method="GET" action="/classes">
        <?php echo e($slot); ?>

        <!-- List of subject checkboxes -->
        <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">Subject</h3>
        <?php $__currentLoopData = $subjectOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-1">
                <label class="space-x-2">
                    <input type="checkbox" name="subjectOptions[]" value="<?php echo e($subject); ?>"
                        <?php if(in_array($subject, request()->get('subjectOptions', []))): ?> checked="checked" <?php endif; ?>>
                    <span><?php echo e($subject); ?></span>
                </label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <!-- List of school checkboxes -->
        <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">School</h3>
        <?php $__currentLoopData = $schoolOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-1">
                <label class="space-x-2">
                    <input type="checkbox" name="schoolOptions[]" value="<?php echo e($school); ?>"
                        <?php if(in_array($school, request()->get('schoolOptions', []))): ?> checked="checked" <?php endif; ?>>
                    <span><?php echo e($school); ?></span>
                </label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-6">
            <button type="submit" class="py-1.5 px-10 rounded-xl bg-primary.main text-white">Apply</button>
        </div>
    </form>
</div>


<script>
    function clearAll() {
        // Get all checkboxes by name and uncheck them
        document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
</script>
<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/assignment-list/filter/form.blade.php ENDPATH**/ ?>