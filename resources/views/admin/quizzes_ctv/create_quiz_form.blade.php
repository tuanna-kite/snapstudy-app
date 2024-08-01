@php
    if (!empty($quiz)) {
        $subject = \App\Models\Category::find($quiz->webinar->category_id);
        $major = \App\Models\Category::where('id', $subject->parent_id)
            ->with('subCategories')
            ->first();

        $school = \App\Models\Category::where('id', $major->parent_id)
            ->with('subCategories')
            ->first();
    }
@endphp
<form action="{{ getAdminPanelUrl() }}/quizzes/assign/{{ !empty($quiz) ? $quiz->id . '/update' : 'store' }}" method="POST" id="quizzForm"
      class="js-content-form quiz-form webinar-form">
    {{ csrf_field() }}
    <section>
        <div class="row">
            <div class="col-12 col-md-4">

                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h2 class="section-title">
                            {{ !empty($quiz) ? trans('public.edit') . ' (' . $quiz->title . ')' : trans('quiz.new_quiz') }}
                        </h2>

                        @if (!empty($creator))
                            <p>{{ trans('admin/main.instructor') }}: {{ $creator->full_name }}</p>
                        @endif
                    </div>
                </div>

                @if (!empty(getGeneralSettings('content_translate')))
                    <div class="form-group">
                        <label class="input-label">{{ trans('auth.language') }}</label>
                        <select name="locale" disabled
                                class="form-control {{ !empty($quiz) ? 'js-edit-content-locale' : '' }}">
                            @foreach ($userLanguages as $lang => $language)
                                <option value="{{ $lang }}" @if (mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>
                                    {{ $language }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                @else
                    <input type="hidden" name="locale"
                           value="{{ getDefaultLocale() }}">
                @endif

                <div class="form-group mt-15 ">
                    <label class="input-label d-block">{{ trans('panel.course_type') }}</label>
                    <select name="genre" disabled
                            class="custom-select @error('genre')  is-invalid @enderror">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" @if (!empty($quiz) ? $quiz->webinar->genre : old('genre') == $genre->id) selected @endif>
                                {{ $genre->title }}</option>
                        @endforeach
                    </select>

                    @error('genre')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <input type="hidden" name="teacher_id"
                       value="{{ Auth::user()->id }}" id="">
                <input type="hidden" name="creator_id"
                       value="{{ Auth::user()->id }}" id="">

                <div class="form-group">
                    <label class="input-label">{{ trans('quiz.quiz_title') }}</label>
                    <input type="text" name="title" disabled
                           value="{{ !empty($quiz) ? $quiz->title : old('title') }}" class="form-control @error('title')  is-invalid @enderror"
                           placeholder="" />
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="input-label">{{ trans('public.seo_description') }}</label>
                    <textarea type="text" name="seo_description" rows="5" disabled
                              class="js-ajax-seo_description form-control " placeholder="">{{ !empty($quiz) ? $quiz->webinar->seo_description : old('seo_description') }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group mt-15">
                    <label class="input-label">{{ trans('public.implementation_cost') }}
                        ( VND )</label>
                    <input type="text" name="implementation_cost" disabled
                           value="{{ (!empty($quiz)) ? convertPriceToUserCurrency($quiz->webinar->implementation_cost) : old('implementation_cost') }}"
                           class="form-control @error('implementation_cost')  is-invalid @enderror"
                           placeholder="{{ trans('public.0_for_free') }}"/>
                    @error('implementation_cost')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="input-label">{{ trans('public.choose_school') }}</label>
                    <select id="school" name="school_id" disabled
                            class="form-control {{ !empty($quiz) ? 'js-edit-content-school_id' : '' }}">
                        <option {{ !empty($school) ? '' : 'selected' }}>
                            {{ trans('public.choose_school') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ (!empty($school) and $school->id == $category->id) ? 'selected' : '' }}>
                                {{ $category->title }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label class="input-label">{{ trans('public.choose_major') }}</label>
                    <select id="major" name="major_id" disabled
                            class="form-control {{ !empty($quiz) ? 'js-edit-content-major_id' : '' }}">
                        @if (!empty($quiz) && $quiz->webinar->category_id)
                            <option value="{{ $major->id }}">
                                {{ $major->title }}</option>
                        @else
                            <option {{ !empty($quiz) ? '' : 'selected' }}>
                                {{ trans('public.choose_major') }}</option>
                        @endif
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label class="input-label">{{ trans('public.choose_subject') }}</label>
                    <select id="subject" name="category_id" disabled
                            class="form-control @error('category_id')  is-invalid @enderror">
                        @if (!empty($quiz) && $quiz->webinar->category_id)
                            <option value="{{ $subject->id }}">
                                {{ $subject->title }}</option>
                        @else
                            <option {{ !empty($quiz) ? '' : 'selected' }}>
                                {{ trans('public.choose_subject') }}</option>
                        @endif
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group mt-15">
                    <label class="input-label">{{ trans('Cộng tác viên') }}</label>
                    <select id="assigned_user" class="form-control @error('assigned_user')  is-invalid @enderror"
                            name="assigned_user" required disabled>
                        <option {{ !empty($webinar->assigned_user) ? '' : 'selected' }} disabled>
                            {{ trans('Choose User') }}</option>
                        @foreach ($ctv as $user)
                            <option value="{{ $user->id }}"
                                {{ (!empty($webinar) and $webinar->assigned_user == $user->id) ? 'selected' : '' }}>
                                {{ $user->full_name }}</option>
                        @endforeach
                    </select>

                    @error('assigned_user')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

            </div>
        </div>
    </section>

    @if (!empty($quiz))
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-center pb-20">
                <h2 class="section-title after-line">{{ trans('public.questions') }}</h2>
                {{-- TODO: navigate to create_multiple_ques  --}}
                <a  href="{{ route('quizzes-question.create', ['quizID' => $quiz->id]) }}"
                    class="btn btn-primary btn-sm ml-2 mt-3">{{ trans('quiz.add_multiple_choice') }}</a>
                {{-- <button id="add_descriptive_question" data-quiz-id="{{ $quiz->id }}" type="button" class="btn btn-primary btn-sm ml-2 mt-3">{{ trans('quiz.add_descriptive') }}</button> --}}
            </div>
            @if ($quizQuestions)
                <ul class="draggable-questions-lists draggable-questions-lists-{{ $quiz->id }}"
                    data-drag-class="draggable-questions-lists-{{ $quiz->id }}"
                    data-order-table="quizzes_questions" data-quiz="{{ $quiz->id }}">
                    @foreach ($quizQuestions as $question)
                        <li data-id="{{ $question->id }}" class="quiz-question-card d-flex align-items-center mt-4">
                            <div class="flex-grow-1">
                                <h4 class="question-title">{!! $question->title !!} </h4>
                                <div class="font-12 mt-3 question-infos">
                                    <span>{{ $question->type === App\Models\QuizzesQuestion::$multiple ? trans('quiz.multiple_choice') : trans('quiz.descriptive') }}
                                        | {{ trans('quiz.grade') }}: {{ $question->grade }}</span>
                                </div>
                            </div>

                            <i data-feather="move" class="move-icon mr-10 cursor-pointer" height="20"></i>

                            <div class="btn-group dropdown table-actions">
                                <button type="button" class="btn-transparent dropdown-toggle" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu text-left">
                                    {{-- TODO: navigate to create_multiple_ques  --}}
                                    <a type="button" href="{{ route('quizzes-question.edit',['id' => $question->id]) }}"
                                        class="btn btn-sm btn-transparent">{{ trans('public.edit') }}</a>
                                    @include('admin.includes.delete_button', [
                                        'url' => getAdminPanelUrl(
                                            '/quizzes-questions/' . $question->id . '/delete'),
                                        'btnClass' => 'btn-sm btn-transparent',
                                        'btnText' => trans('public.delete'),
                                    ])
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    @endif


    <input type="hidden" name="draft" value="no" id="forDraft" />

    <div class="mt-20 mb-20">
        <button type="button" id="saveAssign"
            class="js-submit-quiz-form btn btn-sm btn-primary">Lưu</button>

        @if (!empty($webinar))
                <button type="button" id="saveReview"
                        class="btn btn-sm btn-warning">Gửi phê duyệt</button>
        @endif
    </div>

</form>

@if ($webinar->status == \App\Models\Webinar::$inactive)
    <section class="mt-3">
        <h2 class="section-title after-line">{{ trans('Lý do từ chối') }}</h2>
        <div class="row">
            <div class="col-12">
                <div class="form-group mt-15">
                    <textarea name="message_for_reviewer" rows="10" class="form-control" disabled>{{ !empty($webinar) && $webinar->message_for_reviewer ? $webinar->message_for_reviewer : '' }}</textarea>
                </div>
            </div>
        </div>
    </section>
@endif


{{-- NOTE: Remove Modal --}}
{{-- @if (!empty($quiz))
    @include('admin.quizzes.modals.multiple_question')
    @include('admin.quizzes.modals.descriptive_question')
@endif --}}

@push('scripts_bottom')
    <script src="https://cdn.tiny.cloud/1/8xk85wmn4362fr0m3iy2yb46zb634hhd7upi6ejitzxbb435/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        function initTinymce() {
            tinymce.init({
                selector: 'textarea.tinymce',
                plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker permanentpen advtable advcode editimage advtemplate mentions tableofcontents footnotes mergetags inlinecss markdown',
                toolbar: 'fullscreen tableofcontents blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | addcomment showcomments | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                images_file_types: 'jpg,svg,webp,png',
                height: 600,
            });
        }

        initTinymce()
    </script>
@endpush
