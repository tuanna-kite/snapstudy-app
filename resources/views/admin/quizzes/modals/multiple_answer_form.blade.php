
<div
    class="add-answer-card mt-4 {{ (empty($answer) or !empty($loop) and $loop->iteration == 1) ? 'main-answer-box' : '' }}">
    <button type="button"
        class="btn btn-sm btn-danger rounded-circle answer-remove {{ (!empty($answer) and !empty($loop) and $loop->iteration > 1) ? '' : 'd-none' }}">
        <i class="fa fa-times"></i>
    </button>

    <div class="row mt-4">
        {{-- <div class="col-12">
            <div class="form-group">
                <label class="input-label">{{ trans('quiz.answer_title') }}</label>
                <input type="text" name="ajax[answers][{{ !empty($answer) ? $answer->id : 'ans_tmp' }}][title]" class="form-control {{ !empty($answer) ? 'js-ajax-answer-title-'.$answer->id : '' }}" value="{{ !empty($answer) ? $answer->title : '' }}"/>
            </div>
        </div> --}}
        <div class="col-12">
            <div class="form-group">
                <div class="form-group d-flex justify-content-between align-items-center mb-1">
                    <label>{{ trans('quiz.answer_title') }}</label>
                </div>
                <textarea name="ajax[answers][{{ !empty($answer) ? $answer->id : 'ans_tmp' }}][title]" id=""
                    class="form-control tinymce {{ !empty($answer) ? 'js-ajax-answer-title-' . $answer->id : '' }}" rows="5"
                    value="{!! !empty($answer) ? $answer->title : '' !!}" placeholder="{{ trans('forms.webinar_description_placeholder') }}">{!! !empty($answer) ? $answer->title : '' !!}</textarea>
            </div>
        </div>
    </div>

    <div class="row mt-2 align-items-end">
        <div class="col-12 col-md-8">
            <div class="form-group">
                <label class="input-label">{{ trans('quiz.answer_image') }} <span
                        class="braces">({{ trans('public.optional') }})</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <button type="button" class="input-group-text admin-file-manager"
                            data-input="file{{ !empty($answer) ? $answer->id : 'ans_tmp' }}" data-preview="holder">
                            <i class="fa fa-arrow-up" class="text-white"></i>
                        </button>
                    </div>
                    <input id="file{{ !empty($answer) ? $answer->id : 'ans_tmp' }}" type="text"
                        name="ajax[answers][{{ !empty($answer) ? $answer->id : 'ans_tmp' }}][file]"
                        value="{{ !empty($answer) ? $answer->image : '' }}" class="form-control lfm-input" />
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group mt-2 d-flex align-items-center justify-content-between js-switch-parent">
                <label class="js-switch"
                    for="correctAnswerSwitch{{ !empty($answer) ? $answer->id : '' }}">{{ trans('quiz.correct_answer') }}</label>
                <div class="custom-control custom-switch">
                    <input id="correctAnswerSwitch{{ !empty($answer) ? $answer->id : '' }}" type="checkbox"
                        name="ajax[answers][{{ !empty($answer) ? $answer->id : 'ans_tmp' }}][correct]"
                        @if (!empty($answer) and $answer->correct) checked @endif class="custom-control-input js-switch">
                    <label class="custom-control-label js-switch"
                        for="correctAnswerSwitch{{ !empty($answer) ? $answer->id : '' }}"></label>
                </div>
            </div>
        </div>
    </div>
</div>
