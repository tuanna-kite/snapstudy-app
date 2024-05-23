<div>
    <!-- Button to toggle the modal -->
    <button id="scrollBtn" class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md"
        @click="showModal = true">
        Câu hỏi
    </button>
    <!-- Modal -->
    <div x-show="showModal"
        class="fixed z-10 top-1/2 left-1/2
            -translate-x-1/2 -translate-y-1/2
            md:max-w-[672px]
            w-full
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
                    <template x-for="(question, idxQues) in questions" :key="idxQues">
                        <a :href="'#question' + idxQues" @click="showModal = false">
                            <div class="rounded-full border w-8 h-8 flex justify-center items-center aspect-square border-text.light.primary"
                                :class="{
                                    'border-none bg-primary.main': answers[question.id],
                                    'border-none bg-secondary.main': isSubmit && hasBought && parseInt(answers[
                                        question.id]) !== question.correct,
                                    'border-none bg-success.main': isSubmit && hasBought && parseInt(answers[question.id]) ===
                                    question.correct,
                                }">
                                <span class="font-semibold text-sm text-text.light.primary" x-text="idxQues + 1"
                                    :class="{
                                        'text-white': answers[question.id]
                                    }">
                                </span>
                            </div>
                        </a>

                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
