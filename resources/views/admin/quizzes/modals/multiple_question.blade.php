<div class="@if (!empty($quiz)) multipleQuestionModal{{ $quiz->id }} @endif ">
    <div class="custom-modal-body">
        <h2 class="section-title after-line">{{ trans('quiz.multiple_choice_question') }}</h2>

        <form class=""
            action="{{ getAdminPanelUrl() }}/quizzes-questions/{{ empty($question_edit) ? 'store' : $question_edit->id . '/update' }}"
            method="post">
            @csrf

            <input type="hidden" name="ajax[quiz_id]" value="{{ !empty($quiz) ? $quiz->id : '' }}">
            <input type="hidden" name="ajax[type]" value="{{ \App\Models\QuizzesQuestion::$multiple }}">

            <div class="row mt-3">

                @if (!empty(getGeneralSettings('content_translate')))
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label">{{ trans('auth.language') }}</label>
                            <select name="ajax[locale]"
                                class="form-control {{ !empty($question_edit) ? 'js-quiz-question-locale' : '' }}"
                                data-id="{{ !empty($question_edit) ? $question_edit->id : '' }}">
                                @foreach ($userLanguages as $lang => $language)
                                    <option value="{{ $lang }}"
                                        {{ (!empty($question_edit) and !empty($question_edit->locale)) ? (mb_strtolower($question_edit->locale) == mb_strtolower($lang) ? 'selected' : '') : (app()->getLocale() == $lang ? 'selected' : '') }}>
                                        {{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="ajax[locale]" value="{{ $defaultLocale }}">
                @endif


                <div class="col-12">
                    <div class="form-group">
                        <div class="form-group d-flex justify-content-between align-items-center mb-1">
                            <label>{{ trans('quiz.question_title') }}</label>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="input-group-text admin-file-manager"
                                    data-input="title_image" data-preview="holder">
                                    <i class="fa fa-upload"></i>
                                </button>
                            </div>
                            <input type="text" name="ajax[title_image]" id="title_image"
                                 value="{{ !empty($question_edit) ? $question_edit->title_image :  old('thumbnail') }}"
                                class="form-control @error('title_image')  is-invalid @enderror" />
                            <div class="input-group-append">
                                <button type="button" class="input-group-text admin-file-view" data-input="title_image">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('title_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <textarea name="ajax[title]" id="question_title" class="js-ajax-title form-control tinymce" rows="5"
                            value="{{ !empty($question_edit) ? $question_edit->title : '' }}"
                            placeholder="{{ trans('forms.webinar_description_placeholder') }}">{!! !empty($question_edit) ? $question_edit->title : '' !!}</textarea>
                        <span class="invalid-feedback"></span>
                    </div>
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="form-group d-flex justify-content-between align-items-center mb-1">
                            <label>Giải thích</label>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="input-group-text admin-file-manager"
                                    data-input="correct_image" data-preview="holder">
                                    <i class="fa fa-upload"></i>
                                </button>
                            </div>
                            <input type="text" name="ajax[correct_image]" id="correct_image"
                                 value="{{ !empty($question_edit) ? $question_edit->correct_image : old('thumbnail') }}"
                                class="form-control @error('correct_image')  is-invalid @enderror" />
                            <div class="input-group-append">
                                <button type="button" class="input-group-text admin-file-view" data-input="correct_image">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('correct_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <textarea name="ajax[correct]" id="explaination" class="js-ajax-correct form-control tinymce" rows="5"
                            value="{{ !empty($question_edit) ? $question_edit->correct : '' }}"
                            placeholder="{{ trans('forms.webinar_description_placeholder') }}">{!! !empty($question_edit) ? $question_edit->correct : '' !!}</textarea>
                    </div>
                </div>

            </div>

            <div class="mt-3">
                <h2 class="section-title after-line">{{ trans('public.answers') }}</h2>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button"
                        class="btn btn-sm btn-primary mt-2 add-answer-btn">{{ trans('quiz.add_an_answer') }}</button>

                    <div class="form-group">
                        <input type="hidden" name="ajax[current_answer]" class="form-control" />
                        <span class="invalid-feedback"></span>
                    </div>
                </div>
            </div>


            <div class="add-answer-container" style="overflow-y: visible;height:auto">
                @if (!empty($question_edit->quizzesQuestionsAnswers) and !$question_edit->quizzesQuestionsAnswers->isEmpty())
                    @foreach ($question_edit->quizzesQuestionsAnswers as $answer)
                        @include('admin.quizzes.modals.multiple_answer_form', ['answer' => $answer])
                    @endforeach
                @else
                    @include('admin.quizzes.modals.multiple_answer_form', ['random' => random_str(5)])
                    @include('admin.quizzes.modals.multiple_answer_form', ['random' => random_str(5)])
                    @include('admin.quizzes.modals.multiple_answer_form', ['random' => random_str(5)])
                    @include('admin.quizzes.modals.multiple_answer_form', ['random' => random_str(5)])
                @endif
            </div>

            <div class="d-flex align-items-center justify-content-end mt-3">
                <button type="submit" class=" btn btn-sm btn-primary">{{ trans('public.save') }}</button>
            </div>


        </form>
    </div>
</div>
