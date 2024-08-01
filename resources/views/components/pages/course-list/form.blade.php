@props(['formId', 'categories', 'school', 'majors'])

<form id={{ $formId }} action="{{ route('school', ['slug' => $school->slug]) }}" method="GET">
    {{ $slot }}
    <!-- List of school checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">{{ trans('course.Majors') }}</h3>
    @foreach ($majors as $major)
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" name="majors[]" value="{{ $major->slug }}"
                    @if (in_array($major->slug, request()->get('majors', []))) checked="checked" @endif>
                <span>{{ $major->title }}</span>
            </label>
        </div>
    @endforeach
    <div class="mt-6">
        <button type="submit"
            class="py-1.5 px-10 rounded-xl bg-primary.main text-white">{{ trans('course.Apply') }}</button>
    </div>
</form>



@pushOnce('scripts_bottom')
    <script>
        function removeVietnameseTones(str) {
            str = str.toLowerCase();
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");
            return str;
        }
        // Function to merge and update query parameters
        function updateQueryParams(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);

            if (formData.has('search')) {
                const searchValue = formData.get('search');
                formData.set('search', removeVietnameseTones(searchValue));
            }

            const formParams = new URLSearchParams(formData);

            // Get the existing query parameters
            const existingParams = new URLSearchParams(window.location.search);
            existingParams.delete('majors[]');
            // Merge the existing query parameters with the new form data
            for (const [key, value] of formParams.entries()) {
                // Check for Filter Form
                const currentValues = existingParams.getAll(key);
                if (!currentValues.includes(value)) {
                    existingParams.append(key, value);
                }
                // Check for Search Form
                if (key === 'search') {
                    existingParams.set(key, value);
                }
            }
            // Redirect to the updated URL with merged query parameters
            window.location.href = '{{ route('school', ['slug' => $school->slug]) }}?' + existingParams.toString();
        }

        // Event listener for filter form submission

        const listForm = [
            'filterForm1', 'filterForm2',
            'searchForm'
        ]

        listForm.forEach(formId => {
            // Add event listener for form submission
            const doc = document.getElementById(formId)
            if (doc) {
                doc.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent default form submission
                    updateQueryParams(formId); // Call updateQueryParams with formId
                });
            }
        });

        function clearQueryParams() {
            // Get all checkboxes by name and uncheck them
            document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.checked = false;
                window.location.href = '{{ route('school', ['slug' => $school->slug]) }}'
            });
        }
    </script>
@endPushOnce
