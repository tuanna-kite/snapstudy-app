<div x-data="{ showModal: false, buttonPosition: { top: 0, right: 0 } }">
    <!-- Button to toggle the modal -->
    <button id="scrollBtn"
            class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
            @click="showModal = true; buttonPosition = $event.target.getBoundingClientRect()">
        Table of Contents
    </button>
    <!-- Modal -->
    <div x-show="showModal"
         class="fixed z-10 bottom-16 right-0 w-3/5 bg-white h-1/2 overflow-y-auto shadow-xl rounded-l-xl max-w-[240px]"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         @click.away="showModal = false">
        <div class="table_contents bg-white p-6">
            <h3 class="text-lg my-4 font-semibold">Table of Contents</h3>
            <!-- Modal content -->
            {!! $docTrans->table_contents !!}
        </div>
    </div>
</div>
