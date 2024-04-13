@props(['formId', 'categories', 'schools', 'slugSchool'])

<form id={{ $formId }} action="{{ route('home.search') }}" method="GET">
    {{ $slot }}
    <!-- List of school checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">School</h3>
    @foreach ($schools as $school)
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" name="schoolOptions[]" value="{{ $school->title }}"
                    @if (in_array($school->title, request()->get('schoolOptions', [])) || $slugSchool == $school->slug) checked="checked" @endif>
                <span>{{ $school->title }}</span>
            </label>
        </div>
    @endforeach
    <div class="mt-6">
        <button type="submit" class="py-1.5 px-10 rounded-xl bg-primary.main text-white">{{ trans('course.Apply')}}</button>
    </div>
</form>



@pushOnce('scripts_bottom')
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
@endPushOnce
