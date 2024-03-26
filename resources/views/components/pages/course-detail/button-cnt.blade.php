<div x-data="{ showModal: false, buttonPosition: { top: 0, right: 0 } }">
    <!-- Button to toggle the modal -->
    <button id="scrollBtn"
        class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
        @click="showModal = true; buttonPosition = $event.target.getBoundingClientRect()">Table of Content</button>

    <!-- Modal -->
    <div x-show="showModal"
        class="fixed z-10 bottom-14 right-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="bg-white p-6 h-40 w-40">
            <!-- Modal content -->
            <p>This is the modal content.</p>
        </div>
    </div>
</div>
