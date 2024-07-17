@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/daterangepicker/daterangepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.css">
    <link rel="stylesheet" href="/assets/vendors/summernote/summernote-bs4.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" />
    <style>
        .bootstrap-timepicker-widget table td input {
            width: 35px !important;
        }

        .select2-container {
            z-index: 1212 !important;
        }
    </style>
@endpush



@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ !empty($webinar) ? trans('/admin/main.edit') : trans('admin/main.new') }} {{ trans('admin/main.class') }}
            </h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" id="webinarForm" class="webinar-form"
                                action="{{ getAdminPanelUrl() }}/webinars/content/{{ !empty($webinar) ? $webinar->id . '/update' : 'store' }}">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        @if (!empty(getGeneralSettings('content_translate')))
                                            <div class="form-group">
                                                <label class="input-label">{{ trans('auth.language') }}</label>
                                                <select name="locale"
                                                    class="form-control {{ !empty($webinar) ? 'js-edit-content-locale' : '' }}">
                                                    @foreach ($userLanguages as $lang => $language)
                                                        <option value="{{ $lang }}"
                                                            @if (mb_strtolower(request()->get('locale', app()->getLocale())) == mb_strtolower($lang)) selected @endif>
                                                            {{ $language }}</option>
                                                    @endforeach
                                                </select>
                                                @error('locale')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @else
                                            <input type="hidden" name="locale" value="{{ getDefaultLocale() }}">
                                        @endif

                                        <div class="form-group mt-15 ">
                                            <label class="input-label d-block">{{ trans('panel.course_type') }}</label>
                                            <select name="genre"
                                                class="custom-select @error('genre')  is-invalid @enderror">
                                                @foreach($genres as $genre)
                                                    <option value="{{ $genre->id }}" @if (!empty($webinar) and $webinar->genre or old('genre') == $genre->id) selected @endif>
                                                        {{ $genre->title }}</option>
                                                @endforeach
                                            </select>

                                            @error('genre')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-15">
                                            <label class="input-label">{{ trans('public.title') }}</label>
                                            <input type="text" name="title"
                                                value="{{ !empty($webinar) ? $webinar->title : old('title') }}"
                                                class="form-control @error('title')  is-invalid @enderror" placeholder="" />
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-15">
                                            <label class="input-label">{{ trans('admin/main.class_url') }}</label>
                                            <input type="text" name="slug"
                                                value="{{ !empty($webinar) ? $webinar->slug : old('slug') }}"
                                                class="form-control @error('slug')  is-invalid @enderror" placeholder="" />
                                            <div class="text-muted text-small mt-1">
                                                {{ trans('admin/main.class_url_hint') }}</div>
                                            @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <input type="hidden" name="teacher_id" value="{{ Auth::user()->id }}"
                                            id="">
                                        <input type="hidden" name="creator_id" value="{{ Auth::user()->id }}"
                                            id="">

                                        <div class="form-group mt-15">
                                            <label class="input-label">{{ trans('public.seo_description') }}</label>
                                            <input type="text" name="seo_description"
                                                value="{{ !empty($webinar) ? $webinar->seo_description : old('seo_description') }}"
                                                class="form-control @error('seo_description')  is-invalid @enderror" />
                                            <div class="text-muted text-small mt-1">
                                                {{ trans('admin/main.seo_description_hint') }}</div>
                                            @error('seo_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mt-15">
                                            <div class="d-flex justify-content-between mb-1">
                                                <label class="input-label">{{ trans('public.description') }}</label>
                                                <button type="button" class="btn btn-primary"
                                                    id="edit_description">Edit</button>
                                            </div>

                                            <textarea name="description" id="description_mce" class="form-control @error('description')  is-invalid @enderror"
                                                placeholder="{{ trans('forms.webinar_description_placeholder') }}">{!! !empty($webinar) ? $webinar->description : old('description') !!}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h2 class="section-title after-line">{{ trans('public.additional_information') }}</h2>
                                    <div class="row">
                                        <div class="col-12 col-md-5" style="max-width: 500px">
                                            <div class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class=""
                                                    for="privateSwitch">{{ trans('update.enable_waitlist') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="enable_waitlist"
                                                        class="custom-control-input" id="enable_waitlistSwitch"
                                                        {{ (!empty($webinar) and $webinar->enable_waitlist) ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                        for="enable_waitlistSwitch"></label>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group mt-30 d-flex align-items-center justify-content-between">
                                                <label class="" for="private">{{ trans('Private') }}</label>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="private" class="custom-control-input"
                                                        id="private"
                                                        {{ (!empty($webinar) and $webinar->private) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="private"></label>
                                                </div>
                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('User') }}</label>
                                                <select id="personalization_user" class="custom-select"
                                                    name="personalization_user" required>
                                                    <option {{ !empty($school) ? '' : 'selected' }} disabled>
                                                        {{ trans('Choose User') }}</option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ (!empty($personalization_user) and $personalization_user == $user->id) ? 'selected' : '' }}>
                                                            {{ $user->full_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.implementation_cost') }}
                                                    ( VND )</label>
                                                <input type="text" name="implementation_cost"
                                                    value="{{ (!empty($webinar) and !empty($webinar->implementation_cost)) ? convertPriceToUserCurrency($webinar->implementation_cost) : old('implementation_cost') }}"
                                                    class="form-control @error('price')  is-invalid @enderror"
                                                    placeholder="{{ trans('public.0_for_free') }}" />
                                                @error('implementation_cost')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label d-block">{{ trans('public.tags') }}</label>
                                                <input type="text" name="tags" data-max-tag="5"
                                                    value="{{ !empty($webinar) ? implode(',', $webinarTags) : '' }}"
                                                    class="form-control inputtags"
                                                    placeholder="{{ trans('public.type_tag_name_and_press_enter') }} ({{ trans('admin/main.max') }} : 5)" />
                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.choose_school') }}</label>
                                                <select id="school"
                                                    class="custom-select @error('school_id')  is-invalid @enderror"
                                                    name="school_id" required>
                                                    <option {{ !empty($school) ? '' : 'selected' }} disabled>
                                                        {{ trans('public.choose_school') }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ (!empty($school) and $school->id == $category->id) ? 'selected' : '' }}>
                                                            {{ $category->title }}</option>
                                                    @endforeach
                                                </select>

                                                @error('school_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.choose_major') }}</label>
                                                <select id="major"
                                                    class="custom-select @error('major_id')  is-invalid @enderror"
                                                    name="major_id" required>
                                                    @if (!empty($webinar) && $webinar->category_id)
                                                        <option value="{{ $major->id }}">
                                                            {{ $major->title }}</option>
                                                    @else
                                                        <option {{ !empty($webinar) ? '' : 'selected' }} disabled>
                                                            {{ trans('public.choose_major') }}</option>
                                                    @endif

                                                </select>

                                                @error('major_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-15">
                                                <label class="input-label">{{ trans('public.choose_subject') }}</label>
                                                <select id="subject"
                                                    class="custom-select @error('category_id')  is-invalid @enderror"
                                                    name="category_id" required>
                                                    @if (!empty($webinar) && $webinar->category_id)
                                                        <option value="{{ $subject->id }}">
                                                            {{ $subject->title }}</option>
                                                    @else
                                                        <option {{ !empty($webinar) ? '' : 'selected' }} disabled>
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
                                                <select id="assigned_user" class="custom-select"
                                                        name="assigned_user" required>
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

                                            <div class="form-group mt-15 {{ (!empty($webinarCategoryFilters) and count($webinarCategoryFilters)) ? '' : 'd-none' }}"
                                                id="categoriesFiltersContainer">
                                                <span
                                                    class="input-label d-block">{{ trans('public.category_filters') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{-- Submit --}}
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" name="draft" value="no" id="forDraft" />
                                        <button type="submit" id="saveAndPublish"
                                            class="btn btn-success">{{ !empty($webinar) ? trans('admin/main.save') : trans('admin/main.save_and_continue') }}</button>

                                        @if (!empty($webinar))
                                            @can('admin_webinars_qlnd')
                                                <button type="button" id="saveReject"
                                                    class="btn btn-warning">{{ $webinar->status == 'active' ? trans('update.unpublish') : trans('public.reject') }}</button>
                                            @endcan
                                            @include('admin.includes.delete_button', [
                                                'url' =>
                                                    getAdminPanelUrl() . '/webinars/content/' . $webinar->id . '/delete',
                                                'btnText' => trans('public.delete'),
                                                'hideDefaultClass' => true,
                                                'btnClass' => 'btn btn-danger',
                                            ])
                                        @endif
                                    </div>
                                </div>
                            </form>
                            @include('admin.webinars.modals.prerequisites')
                            @include('admin.webinars.modals.quizzes')
                            @include('admin.webinars.modals.ticket')
                            @include('admin.webinars.modals.chapter')
                            @include('admin.webinars.modals.session')
                            @include('admin.webinars.modals.file')
                            @include('admin.webinars.modals.interactive_file')
                            @include('admin.webinars.modals.faq')
                            @include('admin.webinars.modals.testLesson')
                            @include('admin.webinars.modals.assignment')
                            @include('admin.webinars.modals.extra_description')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts_bottom')
    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var titleLang = '{{ trans('admin/main.title') }}';
        var zoomJwtTokenInvalid = '{{ trans('admin/main.teacher_zoom_jwt_token_invalid') }}';
        var editChapterLang = '{{ trans('public.edit_chapter') }}';
        var requestFailedLang = '{{ trans('public.request_failed') }}';
        var thisLiveHasEndedLang = '{{ trans('update.this_live_has_been_ended') }}';
        var quizzesSectionLang = '{{ trans('quiz.quizzes_section') }}';
        var filePathPlaceHolderBySource = {
            upload: '{{ trans('update.file_source_upload_placeholder') }}',
            youtube: '{{ trans('update.file_source_youtube_placeholder') }}',
            vimeo: '{{ trans('update.file_source_vimeo_placeholder') }}',
            external_link: '{{ trans('update.file_source_external_link_placeholder') }}',
            google_drive: '{{ trans('update.file_source_google_drive_placeholder') }}',
            dropbox: '{{ trans('update.file_source_dropbox_placeholder') }}',
            iframe: '{{ trans('update.file_source_iframe_placeholder') }}',
            s3: '{{ trans('update.file_source_s3_placeholder') }}',
        }
    </script>


    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
    <script src="/assets/default/vendors/select2/select2.min.js"></script>
    <script src="/assets/default/vendors/moment.min.js"></script>
    <script src="/assets/default/vendors/daterangepicker/daterangepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="/assets/default/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/vendors/summernote/summernote-bs4.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script src="/assets/default/js/admin/quiz.min.js"></script>
    <script src="/assets/admin/js/webinar.min.js"></script>
@endpush
