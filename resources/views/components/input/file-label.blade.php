@props(['extends_title' => false])
<div class="space-y-2 w-full">
    <label for="file-name"
        class="text-sm font-semibold">{{ $extends_title ? trans('dashboard.Attach a file (Your current assignment and assignment)') : trans('dashboard.Attach a file') }}</label>
    <div class="flex justify-between items-center">
        <div class="file-upload flex w-full items-center gap-2 px-3 py-4 border rounded-lg border-grey-300">
            <label for="file" class="rounded-md px-2 py-0.5 bg-grey-300 cursor-pointer">
                <span class="font-bold text-xs text-gray-800 ">
                    {{ trans('dashboard.Choose') }}
                </span>
            </label>
            <input type="file" id="file" name='attach' class="hidden" onchange="handleFileUpload()" />
            <span id="file-name"
                class="font-normal text-base text-text.light.disabled">{{ trans('dashboard.No file chosen') }}</span>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <script>
        function handleFileUpload() {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            // Display the selected file name
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        }
    </script>
@endpush
