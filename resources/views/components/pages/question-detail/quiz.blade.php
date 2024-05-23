@php
    // interface IQuestion: id, title, choices[idChoice=>string], correct, explaination
    $questions = [];
    foreach ($quizQuestions as $quizQuestion) {
        $ques = [];
        $answser = [];
        $correct = 0;
        $ques['id'] = $quizQuestion->id;
        $ques['title'] = $quizQuestion->title;
        foreach ($quizQuestion->quizzesQuestionsAnswers as $key => $quizzesQuestionsAnswers) {
            $answser[$quizzesQuestionsAnswers->id] = $quizzesQuestionsAnswers->title;
            if ($quizzesQuestionsAnswers->correct) {
                $correct = $quizzesQuestionsAnswers->id;
            }
        }
        $ques['choices'] = $answser;
        $ques['correct'] = $correct;
        $ques['explaination'] = $quizQuestion->correct;
        array_push($questions, $ques);
    }

    // interface answers: [quesId => choiceId]
    $answers = [];
    if ($isSubmit && !empty($userQuiz->results)) {
        foreach (json_decode($userQuiz->results) as $question => $result) {
            $answers[$question] = $result;
        }
    }

    $score = 0;
@endphp



<div x-data="quizApp({{ json_encode($questions) }}, {{ json_encode($answers) }}, {{ json_encode($isSubmit) }}, {{ json_encode($hasBought) }}, {{ json_encode($score) }})" class="p-6" id="quiz">

    <!-- Btn Popup -->
    <x-pages.question-detail.btn-popup />
    <x-pages.question-detail.submit-popup />

    <div class="space-y-6">
        {{-- Result --}}
        @if ($isSubmit && $hasBought)
            <div id='result' class="flex border border-primary.main rounded-2xl justify-between p-6 items-center">
                <p class="font-bold text-3xl text-secondary.main">
                    Your score: <span x-text="score"></span>/{{ count($questions) }}
                </p>
                <button type="button" @click="retakeQuiz"
                    class="flex items-center gap-2 border border-primary.main py-2 px-5 rounded-2xl">
                    <span class="font-normal text-sm text-primary.main">Retest</span>
                    <x-component.material-icon name='restart_alt' class="w-6 h-6 aspect-square text-primary.main" />
                </button>
            </div>
        @endif

        <div>
            <!-- Question -->
            <h3 class="font-bold text-3xl text-primary.main mb-6">Questions</h3>
            <div class="space-y-6">
                <div class="space-y-8 relative">
                    <template x-for="(question, idxQues) in questions" :key="idxQues">
                        <div class="space-y-4">
                            {{-- Question --}}
                            <p class="font-bold text-lg text-black" :id="'question' + idxQues">
                                Question <span x-text="idxQues + 1"></span>: <span x-text="question.title"></span>
                            </p>
                            {{-- Choices --}}
                            <div class="space-y-4">
                                <template x-for="(keyChoice, idxChoice) in Object.keys(question.choices)"
                                    :key="keyChoice">
                                    <div class="flex gap-2 items-start">
                                        <input :disabled="isSubmit" type="radio"
                                            :id="'question' + question.id + '-choice' + idxChoice"
                                            :name="'question' + question.id + '-choice' + idxChoice"
                                            :value="keyChoice" x-model="answers[question.id]"
                                            class="w-6 h-6 aspect-square">
                                        <div class="flex gap-2">
                                            <p class="font-semibold"
                                                :class="{
                                                    'text-primary.main': !isSubmit && answers[question.id] ==
                                                        keyChoice,
                                                    'text-secondary.main': isSubmit && hasBought && answers[
                                                            question.id] ==
                                                        keyChoice && answers[
                                                            question.id] !== question.correct,
                                                    'text-success.main': isSubmit && hasBought && keyChoice === question
                                                        .correct
                                                }">
                                                <span x-text="orderType[idxChoice]"></span>.
                                            </p>
                                            <label :for="'question' + question.id + '-choice' + idxChoice"
                                                :class="{
                                                    'text-primary.main': !isSubmit && answers[question.id] ==
                                                        keyChoice,
                                                    'text-secondary.main': isSubmit && hasBought && answers[
                                                            question.id] ==
                                                        keyChoice && answers[
                                                            question.id] !== question.correct,
                                                    'text-success.main': isSubmit && hasBought && keyChoice === question
                                                        .correct

                                                }">
                                                <span x-text="question.choices[keyChoice]"></span>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            {{-- Explaination --}}
                            @if ($hasBought)
                                <div class="space-y-2 border border-primary.main rounded-lg p-4">
                                    <p class="font-semibold text-sm"
                                        :class="{
                                            'text-secondary.main': isSubmit && answers[question.id] !== question
                                                .correct,
                                            'text-success.main': isSubmit && answers[question.id] === question
                                                .correct,
                                        }">
                                        <span
                                            x-text="isSubmit && answers[question.id] !== question.correct ? 'Sai' : 'Đúng'"></span>
                                    </p>
                                    <p class="text-base text-primary.main">
                                        Đáp án đúng - <span
                                            x-text="orderType[Object.keys(question.choices).indexOf(question.correct)]"></span>
                                    </p>
                                    <p class="text-base text-primary.main">
                                        Giải thích: <span x-text="question.explaination"></span>
                                    </p>
                                </div>
                            @endif

                        </div>
                    </template>
                </div>
                {{-- Buy Btn --}}
                @if ($isSubmit && !$hasBought)
                    <div class="flex flex-col items-center space-y-3">
                        <form method="post" action="/course/direct-payment">
                            @csrf
                            <input class="hidden" type="number" name="item_id" value="{{ $webinar->id }}">
                            <input class="hidden" type="text" name="item_name" value="webinar_id">
                            @if (auth()->user())
                                <button type="submit"
                                    class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                    {{-- <span>{{ trans('Nhận kết quả') }} ({{ handlePrice($course->price) }})</span> --}}
                                    <span>{{ trans('Nhận kết quả') }} {{ handlePrice($webinar->price) }}</span>
                                    <x-component.material-icon name="arrow_downward" />
                                </button>
                            @else
                                <button type="button" onclick="showModalAuth()"
                                    class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                    <span>{{ trans('Nhận kết quả') }} {{ handlePrice($webinar->price) }}</span>
                                    <x-component.material-icon name="arrow_downward" />
                                </button>
                            @endif

                        </form>
                        <p class="font-normal text-sm text-text.light.secondary">
                            {{ trans('Đăng ký để nhận kết quả') }}
                        </p>
                    </div>
                @endif
                {{-- Submit Quiz --}}
                @if (!$isSubmit)
                    <div class="py-6 border-t border-grey-300">
                        <button type="button" @click="showSubmitModal = true"
                            class="rounded-xl bg-primary.main px-5 py-2.5 flex items-center gap-2 active:opacity-95">
                            <span class="text-white text-sm font-medium">Submit</span>
                            <x-component.material-icon name="arrow_forward" class="text-white w-6 h-6 aspect-square" />
                        </button>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    function quizApp(questions, answers, isSubmit, hasBought, score) {
        return {
            orderType: ['A', 'B', 'C', 'D'],
            showModal: false,
            showSubmitModal: false,
            questions: questions,
            answers: answers || {},
            isSubmit: isSubmit || false,
            hasBought: hasBought || false,
            score: score || 0,
            submitQuiz() {
                this.showSubmitModal = false;
                console.log(this.answers);
                $.ajax({
                    url: '{{ route('quizzes.result', ['id' => $quiz->id]) }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'answers': this.answers
                    },
                    success: function(response) {
                        this.isSubmit = true;
                        location.reload();
                        // Xử lý sau khi cập nhật thành công
                    },
                    error: function(xhr) {
                        alert('Failed to update quiz');
                        console.log(xhr.responseText);
                    }
                });
            },
            retakeQuiz() {
                this.isSubmit = false;
                this.answers = {};
                this.questions = shuffle(this.question);
                this.score = 0;
                // Handle Ajax here
            }
        };
    }
</script>
