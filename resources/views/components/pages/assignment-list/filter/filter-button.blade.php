<div x-data="{ showModal: false }">
    <!-- Button to toggle the modal -->
    <button class="flex" @click="showModal = true">
        <x-component.material-icon name='tune' />
    </button>


    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 h-screen z-50" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90" @click.away="showModal = false"
        class="fixed inset-0 h-screen">
        <div class="bg-white p-6 h-full">
            <!-- Modal content -->
            <x-pages.assignment-list.filter.form>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <button class="flex" @click="showModal = false">
                            <x-component.material-icon name='close' />
                        </button>
                        <h2 class="font-semibold text-base text-primary.main">
                            Filter
                        </h2>
                    </div>
                    <div>
                        <button
                            class="flex items-center gap-1 rounded-full border py-0.5 px-2 border-border-disabled text-text.light.disabled"
                            @click="clearAll()">
                            <span class="font-medium text-xs">Clear All</span>
                            <x-component.material-icon name="close" style="font-size:18px !important" />
                        </button>
                    </div>
                </div>
            </x-pages.assignment-list.filter.form>
        </div>
    </div>
</div>
