@php
    // $data = [];
    // foreach ($quizQuestions as $quizQuestion){
    //     $ques = [];
    //     $answser = [];
    //     $correct = 0;
    //     $ques['ques'] = $quizQuestion->title;
    //     foreach ($quizQuestion->quizzesQuestionsAnswers as $key => $quizzesQuestionsAnswers){
    //         array_push($answser, [$quizzesQuestionsAnswers->title]);
    //         if ($quizzesQuestionsAnswers->correct){
    //             $correct = $key;
    //         }
    //     }
    //     $ques['choices'] = $answser;
    //     $ques['correct'] = $correct;
    //     $ques['explaination'] = $quizQuestion->correct;
    //     array_push($data, $ques);
    // }
    $data = [
        [
            'id' => 'idques1',
            'title' =>
                'Which of the following correctly describes vision statement and mission statement, respectively?',
            'choices' => [
                'idanswer1' =>
                    'The mission statement describes what the organization, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'idanswer2' =>
                    'The vision statement describes what the organization intends to be or become and answers the question, “Who are we?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'idanswer3' =>
                    'The vision statement describes what the organizars the question, “What do we do?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?”',
                'idanswer4' =>
                    'The mission statement describes what the organizand answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization intends to be or become and answers the question, “What do we do?”',
            ],
            'correct' => 'idanswer1',
            'explaination' => 'Bởi vì nó dài nhất',
        ],
        [
            'id' => 'idques2',
            'title' =>
                'Which of the following correctly describes an example of following the differentiation strategy?',
            'choices' => [
                'idanswer1' =>
                    'The mission statement describes what the organization, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'idanswer2' =>
                    'The vision statement describes what the organization intends to be or become and answers the question, “Who are we?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “What do we do?”',
                'idanswer3' =>
                    'The vision statement describes what the organizars the question, “What do we do?” The vision statement guides subsequently the development of the mission statement. The mission statement describes what the organization is committed to do or how it will act and answers the question, “Who are we?”',
                'idanswer4' =>
                    'The mission statement describes what the organizand answers the question, “Who are we?” The mission statement guides subsequently the development of the vision statement. The vision statement describes what the organization intends to be or become and answers the question, “What do we do?”',
            ],
            'correct' => 'idanswer2',
            'explaination' => ' Bởi vì câu này ngắn nhất',
        ],
        [
            'id' => 'idques3',
            'title' =>
                'Which of the following correctly describes an example of following the differentiation strategy?',
            'choices' => [
                'idanswer1' =>
                    'A company focuses its advertisements on how its product costsny focuses its  less than similar products sold by competitors.',
                'idanswer2' =>
                    'A company focuses its advertisements on hny focuses its ow its product is s product is s product is higher quality than similar products sold by competitors.',
                'idanswer3' =>
                    'A company chooses not to advertise its product as a way tls products innyls products innyo cut costs.',
                'idanswer4' =>
                    'A company focuses its advertisements on how it sells products inny focuses its  one industry segment and is therefore an expert in that segment.',
            ],
            'correct' => 'idanswer2',
            'explaination' => ' Bởi vì câu này ngắn nhất',
        ],
    ];

    $answers = [
        'idques1' => 'idanswer3',
        'idques2' => 'idanswer2',
        'idques3' => 'idanswer2',
    ];

    $isSubmit = false;
    $isBought = false;
    $score = 0;
@endphp



<div x-data="quizApp({{ json_encode($data) }}, {{ json_encode($answers) }}, {{ json_encode($isSubmit) }}, {{ json_encode($isBought) }}, {{ json_encode($score) }})" class="p-6" id="quiz">

    <!-- Btn Popup -->
    <x-pages.question-detail.btn-popup />
    <x-pages.question-detail.submit-popup />

    <div class="space-y-6">
        {{-- Result --}}
        <div x-show="isSubmit && isBought" id='result'
            class="flex border border-primary.main rounded-2xl justify-between p-6 items-center">
            <p class="font-bold text-3xl text-secondary.main">
                Your score: <span x-text="score"></span>/{{ count($data) }}
            </p>
            <button type="button" @click="retakeQuiz"
                class="flex items-center gap-2 border border-primary.main py-2 px-5 rounded-2xl">
                <span class="font-normal text-sm text-primary.main">Retest</span>
                <x-component.material-icon name='restart_alt' class="w-6 h-6 aspect-square text-primary.main" />
            </button>
        </div>

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
                                                    'text-secondary.main': isSubmit && isBought && answers[
                                                            question.id] ==
                                                        keyChoice && answers[
                                                            question.id] !== question.correct,
                                                    'text-success.main': isSubmit && isBought && keyChoice === question
                                                        .correct
                                                }">
                                                <span x-text="orderType[idxChoice]"></span>.
                                            </p>
                                            <label :for="'question' + question.id + '-choice' + idxChoice"
                                                :class="{
                                                    'text-primary.main': !isSubmit && answers[question.id] ==
                                                        keyChoice,
                                                    'text-secondary.main': isSubmit && isBought && answers[
                                                            question.id] ==
                                                        keyChoice && answers[
                                                            question.id] !== question.correct,
                                                    'text-success.main': isSubmit && isBought && keyChoice === question
                                                        .correct

                                                }">
                                                <span x-text="question.choices[keyChoice]"></span>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            {{-- Explaination --}}
                            <div class="space-y-2 border border-primary.main rounded-lg p-4" x-show="isBought">
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
                        </div>
                    </template>
                </div>
                {{-- Buy Btn --}}
                @if ($isSubmit && !$isBought)
                    <div class="flex flex-col items-center space-y-3">
                        <form method="post" action="/course/direct-payment">
                            @csrf
                            {{-- <input class="hidden" type="number" name="item_id" value="{{ $course->id }}"> --}}
                            <input class="hidden" type="text" name="item_name" value="webinar_id">
                            @if (auth()->user())
                                <button type="submit"
                                    class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                    {{-- <span>{{ trans('course.Read more') }} ({{ handlePrice($course->price) }})</span> --}}
                                    <span>{{ trans('course.Read more') }} 1000k</span>
                                    <x-component.material-icon name="arrow_downward" />
                                </button>
                            @else
                                <button type="button" onclick="showModalAuth()"
                                    class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                    <span>{{ trans('course.Read more') }} 1000k</span>
                                    <x-component.material-icon name="arrow_downward" />
                                </button>
                            @endif

                        </form>
                        <p class="font-normal text-sm text-text.light.secondary">
                            {{ trans('course.Đăng ký để nhận kết quả') }}
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
    function quizApp(questions, answers, isSubmit, isBought, score) {
        return {
            orderType: ['A', 'B', 'C', 'D'],
            showModal: false,
            showSubmitModal: false,
            questions: questions,
            answers: answers || {},
            isSubmit: isSubmit || false,
            isBought: isBought || false,
            score: score || 0,
            submitQuiz() {
                this.showSubmitModal = false;
                // Submit answer and save in BE
                // return isSubmit true
            },
            retakeQuiz() {
                // Refresh Answers in BE
                // isSubmit false
                // shuffle question and choice
            }
        };
    }
</script>
