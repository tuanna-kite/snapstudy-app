<div {{ $attributes->merge(['class' => 'rounded-xl p-3 flex items-center bg-white justify-between']) }}>
    <input class="flex-1 p-1" type="text" id="searchInput" placeholder="Search...">
    <button id='btnSearch'>
        <x-component.icon name='ic_search' width='24' height='24' />
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
