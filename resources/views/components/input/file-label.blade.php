<div class="space-y-2">
    <label for="file" class="text-sm font-semibold">Attach a file</label>
    <div class="flex justify-between items-center">
        <div class="file-upload flex items-center gap-2 px-3 py-4 min-w-80 border rounded-lg border-grey-300">
            <input type="file" id="file" class="hidden" onchange="handleFileUpload()" />
            <label for="file" class="rounded-md px-2 py-0.5 bg-grey-300 cursor-pointer">
                <span  class="font-bold text-xs text-gray-800">
                    Choose
                </span>
            </label>
            <span id="file-name"  class="font-normal text-base text-text.light.disabled">No file chosen</span>
        </div>
        {{ $slot }}
    </div>
</div>


<script>
    function handleFileUpload() {
    const fileInput = document.getElementById('file');
    const fileNameDisplay = document.getElementById('file-name');
        console.log(fileInput)
    // Display the selected file name
    if (fileInput.files.length > 0) {
        fileNameDisplay.textContent = fileInput.files[0].name;
    } else {
        fileNameDisplay.textContent = 'No file chosen';
    }
}
</script>
