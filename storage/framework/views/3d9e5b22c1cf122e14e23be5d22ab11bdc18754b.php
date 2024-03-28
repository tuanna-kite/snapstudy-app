<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['formId']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['formId']); ?>
<?php foreach (array_filter((['formId']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

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
        'Business Foundation',
        'IT',
        'Global Business',
    ];
    $schoolOptions = ['RMIT', 'VinUniversity', 'MIT', 'Yale', 'Harvard'];
?>

<form id=<?php echo e($formId); ?> action="/classes" method="GET">
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



<?php if (! $__env->hasRenderedOnce('9568984b-9f9c-42dd-a1c5-97549c91966f')): $__env->markAsRenderedOnce('9568984b-9f9c-42dd-a1c5-97549c91966f');
$__env->startPush('scripts'); ?>
    <script>
        // Function to merge and update query parameters
        function updateQueryParams(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const formParams = new URLSearchParams(formData);

            // Get the existing query parameters
            const existingParams = new URLSearchParams(window.location.search);
            // Merge the existing query parameters with the new form data
            for (const [key, value] of formParams.entries()) {
                // Check for Filter Form
                const currentValues = existingParams.getAll(key);
                if (!currentValues.includes(value)) {
                    existingParams.append(key, value);
                }
                // Check for Search Form
                if (key == 'search') {
                    existingParams.set(key, value);
                }
            }
            // Redirect to the updated URL with merged query parameters
            window.location.href = '/classes?' + existingParams.toString();
        }

        // Event listener for filter form submission

        const listForm = [
            'filterForm1', 'filterForm2', 'searchForm'
        ]

        listForm.forEach(formId => {
            // Add event listener for form submission
            document.getElementById(formId).addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                updateQueryParams(formId); // Call updateQueryParams with formId
            });
        });

        function clearQueryParams() {
            // Get all checkboxes by name and uncheck them
            document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.checked = false;
                window.location.href = '/classes?'
            });
        }
    </script>
<?php $__env->stopPush(); endif; ?>

<?php /**PATH /Users/lequanganh/workspace/php-space/snapstudy-app/resources/views/components/pages/course-list/filter/form.blade.php ENDPATH**/ ?>