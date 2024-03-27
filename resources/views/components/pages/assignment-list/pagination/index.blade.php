<div class="flex justify-center">
    <div x-data="pagination()" class="flex items-center gap-3">
        <!-- Previous Page Button -->
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
            class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full text-white">
            <x-component.material-icon name="chevron_left" />
        </button>

        <!-- Current Page Buttons -->
        <template x-for="pageNumber in currentPageArray" :key="pageNumber">
            <button @click="goToPage(pageNumber)" :class="{ 'bg-primary.main text-white': pageNumber === currentPage }"
                class="w-6 h-6 p-1 box-content border border-grey-400 rounded-full text-text.light.disabled">
                <span x-text="pageNumber" class="text-base "></span>
            </button>
        </template>

        <!-- Ellipsis -->
        <span x-show="currentPage < lastPage - 3" class="mr-1">...</span>

        <!-- Last Page Button -->
        <button x-show="currentPage < lastPage -1" @click="goToPage(lastPage)"
            :class="{ 'bg-primary.main text-white': pageNumber === currentPage }"
            class="w-6 h-6 p-1 box-content border border-grey-400 rounded-full text-text.light.disabled">
            <span x-text="lastPage"> </span>
        </button>
        <button button @click="goToPage(currentPage + 1)": disabled ="currentPage===lastPage"
            class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full text-white">
            <x-component.material-icon name="chevron_right" />
        </button>
    </div>
</div>

<!-- Include Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3"></script>
<!-- Initialize Alpine.js -->
<script>
    function pagination() {
        return {
            currentPage: 1,
            lastPage: 10, // Example, you can replace this with the actual last page number

            goToPage(page) {
                if (page >= 1 && page <= this.lastPage) {
                    this.currentPage = page;
                    // You can add logic to fetch data for the selected page here
                }
            },
            get currentPageArray() {
                let start = Math.max(1, this.currentPage - 1);
                let end = Math.min(this.lastPage, start + 2);

                if (this.currentPage === this.lastPage) {
                    start = Math.max(1, this.lastPage - 2);
                    end = this.lastPage;
                } else if (this.currentPage === 1) {
                    end = Math.min(this.lastPage, this.currentPage + 2);
                }

                let pages = [];
                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }
                return pages;
            }
        }
    }
</script>
