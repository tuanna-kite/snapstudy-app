{{-- <div x-data="{ isOpen: false }">
    <!-- Button to open the modal -->
    <button @click="isOpen = true">
        <x-component.material-icon name='menu'/>
    </button>

    <!-- Modal -->
    <div x-show="isOpen"
         @click.away="isOpen = false"
         class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <!-- Modal content -->
        <div class="bg-white p-4 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Modal Title</h2>
            <p>This is the modal content.</p>
            <!-- Button to close the modal -->
            <button @click="isOpen = false">Close</button>
        </div>
    </div>
</div> --}}

<div x-data="{ showModal: false }">
    <!-- Button to toggle the modal -->
    <template x-if="!showModal">
        <button @click="showModal = true">
            <x-component.material-icon name='menu' />
        </button>
    </template>
    <template x-if="showModal">
        <button @click="showModal = false">
            <x-component.material-icon name='close' />
        </button>
    </template>

    <!-- Modal -->
    <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90" @click.away="showModal = false"
        class="fixed top-50 left-0 w-full h-fu">
        <div class="bg-white p-6 rounded-lg">
            <!-- Modal content -->
            <x-slidebar.index/>
        </div>
    </div>
</div>
