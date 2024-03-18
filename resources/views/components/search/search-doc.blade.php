<div class="rounded-full pl-6 pr-0.5 py-0.5 flex items-center bg-white justify-between shadow">
    <input class="flex-1 p-1" type="text" id="searchInput" placeholder="Search a document...">
    <button id='btnSearch' class="bg-primary.main rounded-full px-5 py-2">
        <span class="font-medium text-sm text-white">
            Search
        </span>
    </button>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const myButton = document.getElementById('btnSearch');

        myButton.addEventListener('click', function() {
            const inputValue = document.getElementById('searchInput').value;
            console.log('Input value:', inputValue);
            // Do something with the input value
        });
    });
</script>
