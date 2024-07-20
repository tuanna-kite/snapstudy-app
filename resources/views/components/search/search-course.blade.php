@props(['school'])

<form id="searchCourse" action="{{ route('school', ['slug' => $school->slug]) }}" method="GET"
    class="rounded-full pl-6 px-1 md:pr-0.5 py-0.5 h-11 bg-white shadow-lg flex items-center justify-between">
    <input id="searchInput" class="flex-1 p-1 focus:border-transparent" type="text" name="search"
        placeholder="Search a document...">
    <button type="submit" class="bg-primary.main rounded-full px-5 py-2 hidden md:block">
        <span class="font-medium text-sm text-white">
            Search
        </span>
    </button>
    <button type="submit" class="flex md:hidden">
        <x-component.material-icon name="search" />
    </button>
</form>

@push('scripts_bottom')
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

        function updateQueryParams(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);

            // Normalize the 'search' input
            if (formData.has('search')) {
                const searchValue = formData.get('search');
                formData.set('search', removeVietnameseTones(searchValue));
            }

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
                if (key === 'search') {
                    existingParams.set(key, value);
                }
            }
            // Redirect to the updated URL with merged query parameters
            window.location.href = '{{ route('school', ['slug' => $school->slug]) }}?' + existingParams.toString();
        }

        document.getElementById('searchCourse').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            updateQueryParams('searchCourse'); // Call updateQueryParams with formId
        });
    </script>
@endpush
