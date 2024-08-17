@extends('web_v2.layouts.index')

@section('title', 'Question Detail')

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
        $ques['correct'] = (string) $correct;
        $ques['explaination'] = $quizQuestion->correct;
        array_push($questions, $ques);
    }


@endphp
@section('content')
    <x-layouts.home-layout>
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto">
                <div class="max-w-[960px] mx-auto space-y-6">
                    <h1 class="font-normal text-3xl text-text.light.primary">
                        {{ $webinar->category->title }}
                    </h1>
                    <h2 class="font-bold text-5xl text-primary.main">
                        {!! $webinar->title !!}
                    </h2>
                    <p class="font-normal text-base text-text.light.primary">
                        {{ $webinar->seo_description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class='container mx-auto py-16'>
                {{-- Content --}}
                <div class="max-w-[960px] mx-auto space-y-16">
                    {{--  Content  --}}
                    <div class="space-y-6 mx-auto">
                        <div x-data="quizApp({{ json_encode($questions) }})" class="p-6" id="quiz">

                            <!-- Btn Popup -->
                            <x-pages.question-detail.btn-popup />
                            <x-pages.question-detail.submit-popup />

                            <div class="space-y-6">

                                <div>
                                    <!-- Question -->
                                    <h3 class="font-bold text-3xl text-primary.main mb-6">Questions</h3>
                                    <div class="space-y-6">
                                        <div class="space-y-8 relative">
                                            <template x-for="(question, idxQues) in questions" :key="idxQues">
                                                <div class="space-y-4">
                                                    {{-- Question --}}
                                                    <p class="font-bold text-lg text-black" :id="'question' + idxQues">
                                                        Question <span x-text="idxQues + 1"></span>: <span x-html="question.title"
                                                                                                           style="display: inline-block"></span>
                                                    </p>
                                                    {{-- Choices --}}
                                                    <div class="space-y-4">
                                                        <template x-for="(keyChoice, idxChoice) in Object.keys(question.choices)"
                                                                  :key="keyChoice">
                                                            <div class="flex gap-2 items-start">
                                                                <div>
                                                                    <input :disabled="isSubmit" type="radio"
                                                                           :id="'question' + question.id + '-choice' + idxChoice"
                                                                           :name="'question' + question.id + '-choice' + idxChoice"
                                                                           :value="keyChoice" x-model="answers[question.id]"
                                                                           class="w-6 h-6 aspect-square">
                                                                </div>
                                                                <div class="flex gap-2">
                                                                    <p class="font-semibold"
                                                                       :class="{
                                                    'text-primary.main': !isSubmit && answers[question.id] ==
                                                        keyChoice,
                                                    'text-secondary.main': isSubmit && hasBought && answers[question
                                                            .id] ==
                                                        keyChoice && answers[question.id] !== question.correct,
                                                    'text-success.main': isSubmit && hasBought && keyChoice === question
                                                        .correct
                                                }">
                                                                        <span x-text="orderType[idxChoice]"></span>.
                                                                    </p>
                                                                    <label :for="'question' + question.id + '-choice' + idxChoice"
                                                                           :class="{
                                                    'text-primary.main': !isSubmit && answers[question.id] ==
                                                        keyChoice,
                                                    'text-secondary.main': isSubmit && hasBought && answers[question
                                                            .id] ==
                                                        keyChoice && answers[question.id] !== question.correct,
                                                    'text-success.main': isSubmit && hasBought && keyChoice === question
                                                        .correct
                                                }">
                                                                        <span x-html="question.choices[keyChoice]"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.home-layout>
@endsection

@push('scripts_bottom')
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
                    // this.questions = shuffle(this.question);
                    this.score = 0;
                    $.ajax({
                        url: '{{ route('quizzes.destroy', ['id' => $quiz->id]) }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            this.isSubmit = true;
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to destroy quiz');
                            console.log(xhr.responseText);
                        }
                    });
                }
            };
        }
    </script>
@endpush
