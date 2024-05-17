@props(['data'])

<div x-data="{ showModal: false }">
    <!-- Button to toggle the modal -->
    <button id="scrollBtn" class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
        @click="showModal = true">
        Câu hỏi
    </button>
    <!-- Modal -->
    <div x-show="showModal"
        class="fixed z-10 top-1/2 left-1/2
            -translate-x-1/2 -translate-y-1/2
            min-w-[672px]
             bg-white overflow-y-auto shadow-xl rounded-3xl"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="table_contents bg-white p-6">
            <div class="flex justify-end">
                <button type="button" @click="showModal = false">
                    <x-component.material-icon name="close" />
                </button>
            </div>
            <div class="space-y-6">
                <h3 class="text-3xl text-text.light.primary text-center">Questions</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($data as $index => $item)
                        <div
                            class="rounded-full border w-8 flex justify-center items-center aspect-square border-text.light.primary">
                            <span class="font-semibold text-sm text-text.light.primary">
                                {{ $index + 1 }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
