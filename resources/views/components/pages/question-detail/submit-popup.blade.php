<div>
    <!-- Modal -->
    <div x-show="showSubmitModal"
        class="fixed z-10 top-1/2 left-1/2
            -translate-x-1/2 -translate-y-1/2
            min-w-[320px]
            md:min-w-[368px]
            bg-white overflow-y-auto shadow-xl rounded-3xl"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showSubmitModal = false">
        <div class="bg-white p-4">
            <div class="flex justify-end">
                <button type="button" @click="showSubmitModal = false">
                    <x-component.material-icon name="close" />
                </button>
            </div>
            <div class="space-y-1 px-6">
                <h3 class="text-2xl font-bold text-text.light.primary text-center">Submit</h3>
                <p class="text-text.light.secondary text-center">
                    Do you want to submit your assignment?
                </p>
            </div>
            <div class="flex gap-4 justify-between p-6">
                <button type="button" class="border border-primary.main rounded-xl flex-1 py-2"
                    @click="showSubmitModal = false">
                    <span class="font-normal text-sm text-primary.main">Close</span>
                </button>
                <button type="button" class="bg-primary.main rounded-xl flex-1 py-1.5" @click="submitQuiz">
                    <span class="font-normal text-sm text-white">Confirm</span>

                </button>
            </div>
        </div>
    </div>
</div>
