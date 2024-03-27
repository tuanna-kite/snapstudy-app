<div x-data="{ showModal: false }">
    <!-- Button to toggle the modal -->
    <button class="flex" @click="showModal = true">
        <x-component.material-icon name='search' />
    </button>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 h-screen z-50" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90" @click.away="showModal = false"
        class="fixed inset-0 h-screen">
        <div class="bg-white p-6 h-full">
            <!-- Modal content -->
            <div class="flex flex-col items-center w-full space-y-4">
                <button class="flex border rounded-full border-grey-300 p-3" @click="showModal = false">
                    <x-component.material-icon name='close' />
                </button>
                    <input type="text" class="w-full border rounded-lg p-2" placeholder="Search...">
            </div>
        </div>
    </div>
</div>
