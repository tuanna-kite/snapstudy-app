<div x-data='{ searchQuery: "",
    search: function() {
        // Clear all values from both subject and school keys
        console.log("Searching for:", this.searchQuery);
    },
}'
    class="rounded-full pl-6 px-1 md:pr-0.5 py-0.5 h-11 bg-white shadow-lg flex items-center justify-between">
    <input x-model="searchQuery" class="flex-1 p-1 focus:border-transparent" type="text" id="searchInput"
        placeholder="Search a document...">
    <button @click="search()" id='btnSearch' class="bg-primary.main rounded-full px-5 py-2 hidden md:block ">
        <span class="font-medium text-sm text-white">
            Search
        </span>
    </button>
    <button @click="search()" class="flex md:hidden">
        <x-component.material-icon name="search" />
    </button>
</div>
