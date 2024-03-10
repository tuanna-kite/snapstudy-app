@extends(getTemplate() . '.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/css/css-stars.css">
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush


@section('content')

    <section class="course-cover-container {{ empty($activeSpecialOffer) ? 'not-active-special-offer' : '' }}">
        {{-- <img src="{{ $course->getImageCover() }}" class="img-cover course-cover-img" alt="{{ $course->title }}" /> --}}

        <div class="cover-content pt-40">
            <div class="container position-relative">
                @if (!empty($activeSpecialOffer))
                    @include('web.default.course.special_offer')
                @endif
                <div class="course-body-on-cover ">
                    @if (!empty($course->category))
                        <span class="d-block sub-title mt-20"><a href="{{ $course->category->getUrl() }}" target="_blank"
                                class="font-weight-500">{{ $course->category->title }}</a></span>
                    @endif

                    <h1 class="course-title">
                        {{ $course->title }}
                    </h1>

                    <p class="my-10 content-title">{{$course->seo_description}}</p>

                    <div class="d-flex align-items-center">
                        @include('web.default.includes.webinar.rate', ['rate' => $course->getRate()])
                        {{-- <span class="ml-10 mt-15 view-mj">({{ $course->reviews->pluck('creator_id')->count() }}
                            {{ trans('public.ratings') }})</span> --}}
                    </div>

                    <div class="mt-15 view-mj">
                        {{-- <span class="">{{ trans('public.created_by') }}</span>
                        <a href="{{ $course->teacher->getProfileUrl() }}" target="_blank"
                            class="text-decoration-underline font-weight-500">{{ $course->teacher->full_name }}</a> --}}
                    </div>

                    @php
                        $percent = $course->getProgress();
                    @endphp

                    {{-- @if ($hasBought or $percent)
                            <div class="mt-30 d-flex align-items-center">
                                <div class="progress course-progress flex-grow-1 shadow-xs rounded-sm">
                                    <span class="progress-bar rounded-sm bg-warning"
                                        style="width: {{ $percent }}%"></span>
            </div>

            <span class="ml-15 font-14 font-weight-500">
                @if ($hasBought and (!$course->isWebinar() or $course->isProgressing()))
                {{ trans('public.course_learning_passed', ['percent' => $percent]) }}
                @elseif(!is_null($course->capacity))
                {{ $course->sales_count }}/{{ $course->capacity }} {{ trans('quiz.students') }}
                @else
                {{ trans('public.course_learning_passed', ['percent' => $percent]) }}
                @endif
            </span>
        </div>
        @endif --}}
                </div>
            </div>
        </div>
    </section>

    <section
        class="container course-content-section {{ $course->type }} {{ ($hasBought or $course->isWebinar()) ? 'has-progress-bar' : '' }}">
        <div class="row courses-mjj">
            <div class="col-12 col-lg-8">
                <div class="course-content-body user-select-none">


                    <div class="mt-35">
                        <ul class="nav nav-tabs d-flex align-items-center justify-content-between search-courese-mj"
                            id="tabs-tab" role="tablist">
                            <li class="nav-item ">
                                <a style="width: 100px;" class="position-relative font-14 text-white d-flex align-items-center justify-content-center {{ (empty(request()->get('tab', '')) or request()->get('tab', '') == 'information') ? 'active' : '' }}"
                                    id="information-tab" data-toggle="tab" href="#information" role="tab"
                                    aria-controls="information" aria-selected="true">{{ trans('product.information') }}</a>
                            </li>
                            <li class="nav-item">
                                <a style="width: 100px; " class="position-relative font-14 text-white d-flex align-items-center justify-content-center {{ request()->get('tab', '') == 'content' ? 'active' : '' }} "
                                    id="content-tab" data-toggle="tab" href="#content" role="tab"
                                    aria-controls="content" aria-selected="false">{{ trans('product.content') }}
                                    ({{ $webinarContentCount }})</a>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="position-relative font-14 text-white {{ request()->get('tab', '') == 'reviews' ? 'active' : '' }}" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">{{ trans('product.reviews') }}
                                ({{ $course->reviews->count() > 0 ? $course->reviews->pluck('creator_id')->count() : 0 }})</a>
                        </li> --}}
                        </ul>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade {{ (empty(request()->get('tab', '')) or request()->get('tab', '') == 'information') ? 'show active' : '' }} "
                                id="information" role="tabpanel" aria-labelledby="information-tab">
                                @include(getTemplate() . '.course.tabs.information')
                            </div>
                            <div class="tab-pane fade {{ request()->get('tab', '') == 'content' ? 'show active' : '' }}"
                                id="content" role="tabpanel" aria-labelledby="content-tab">
                                @include(getTemplate() . '.course.tabs.content')
                            </div>
                            <div class="tab-pane fade {{ request()->get('tab', '') == 'reviews' ? 'show active' : '' }}"
                                id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                @include(getTemplate() . '.course.tabs.reviews')
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="course-content-sidebar col-12 col-lg-4 mt-25 mt-lg-0">
                <div class="rounded-lg">
                    {{-- <div class="course-img {{ $course->video_demo ? 'has-video' : '' }}">
                    <div class="course-img {{ $course->video_demo ? 'has-video' : '' }}">
                        <img src="{{ $course->getImage() }}" class="img-cover" alt="">
                        @if ($course->video_demo)
                        <div id="webinarDemoVideoBtn" data-video-path="{{ $course->video_demo_source == 'upload' ? url($course->video_demo) : $course->video_demo }}" data-video-source="{{ $course->video_demo_source }}" class="course-video-icon cursor-pointer d-flex align-items-center justify-content-center">
                            <i data-feather="play" width="25" height="25"></i>
                        </div>
                        @endif
                    </div> --}}
                    <div>
                     <!--   <a href="/panel/financial/account">
                            <img src="/store/2/Rectangle-26.png" alt="" width="100%" class="flex-grow-1">
                        </a>
                        -->
                    </div>

                </div>



                {{-- Cashback Alert --}}
                {{-- @include('web.default.includes.cashback_alert', ['itemPrice' => $course->price]) --}}

                {{-- Gift Card --}}
                {{-- @if (
                    $course->canSale() and
                        !empty(getGiftsGeneralSettings('status')) and
                        !empty(getGiftsGeneralSettings('allow_sending_gift_for_courses')))
                    <a href="/gift/course/{{ $course->slug }}"
                        class="d-flex align-items-center mt-30 rounded-lg border p-15">
                        <div class="size-40 d-flex-center rounded-circle bg-gray200">
                            <i data-feather="gift" class="text-gray" width="20" height="20"></i>
                        </div>
                        <div class="ml-5">
                            <h4 class="font-14 font-weight-bold text-gray">{{ trans('update.gift_this_course') }}</h4>
                            <p class="font-12 text-gray">{{ trans('update.gift_this_course_hint') }}</p>
                        </div>
                    </a>
                @endif --}}

                {{-- @if ($course->teacher->offline)
                    <div class="rounded-lg shadow-sm mt-35 d-flex">
                        <div class="offline-icon offline-icon-left d-flex align-items-stretch">
                            <div class="d-flex align-items-center">
                                <img src="/assets/default/img/profile/time-icon.png" alt="offline">
                            </div>
                        </div>

                        <div class="p-15">
                            <h3 class="font-16 text-dark-blue">{{ trans('public.instructor_is_not_available') }}</h3>
                            <p class="font-14 font-weight-500 text-gray mt-15">{{ $course->teacher->offline_message }}</p>
                        </div>
                    </div>
                @endif

                <div class="rounded-lg shadow-sm mt-35 px-25 py-20">
                    <h3 class="sidebar-title font-16 text-secondary font-weight-bold">
                        {{ trans('webinars.' . $course->type) . ' ' . trans('webinars.specifications') }}</h3>

                    <div class="mt-30">
                        @if ($course->isWebinar())
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <i data-feather="calendar" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('public.start_date') }}:</span>
                                </div>
                                <span class="font-14">{{ dateTimeFormat($course->start_date, 'j M Y | H:i') }}</span>
                            </div>
                        @endif

                        <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                            <div class="d-flex align-items-center">
                                <i data-feather="user" width="20" height="20"></i>
                                <span class="ml-5 font-14 font-weight-500">{{ trans('public.capacity') }}:</span>
                            </div>
                            @if (!is_null($course->capacity))
                                <span class="font-14">{{ $course->capacity }} {{ trans('quiz.students') }}</span>
                            @else
                                <span class="font-14">{{ trans('update.unlimited') }}</span>
                            @endif
                        </div>

                        <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                            <div class="d-flex align-items-center">
                                <i data-feather="clock" width="20" height="20"></i>
                                <span class="ml-5 font-14 font-weight-500">{{ trans('public.duration') }}:</span>
                            </div>
                            <span
                                class="font-14">{{ convertMinutesToHourAndMinute(!empty($course->duration) ? $course->duration : 0) }}
                                {{ trans('home.hours') }}</span>
                        </div>

                        <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                            <div class="d-flex align-items-center">
                                <i data-feather="users" width="20" height="20"></i>
                                <span class="ml-5 font-14 font-weight-500">{{ trans('quiz.students') }}:</span>
                            </div>
                            <span class="font-14">{{ $course->sales_count }}</span>
                        </div>

                        @if ($course->isWebinar())
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('public.sessions') }}:</span>
                                </div>
                                <span class="font-14">{{ $course->sessions->count() }}</span>
                            </div>
                        @endif

                        @if ($course->isTextCourse())
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                    <span
                                        class="ml-5 font-14 font-weight-500">{{ trans('webinars.text_lessons') }}:</span>
                                </div>
                                <span class="font-14">{{ $course->textLessons->count() }}</span>
                            </div>
                        @endif

                        @if ($course->isCourse() or $course->isTextCourse())
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('public.files') }}:</span>
                                </div>
                                <span class="font-14">{{ $course->files->count() }}</span>
                            </div>

                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <img src="/assets/default/img/icons/sessions.svg" width="20" alt="">
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('public.created_at') }}:</span>
                                </div>
                                <span class="font-14">{{ dateTimeFormat($course->created_at, 'j M Y') }}</span>
                            </div>
                        @endif

                        @if (!empty($course->access_days))
                            <div class="mt-20 d-flex align-items-center justify-content-between text-gray">
                                <div class="d-flex align-items-center">
                                    <i data-feather="alert-circle" width="20" height="20"></i>
                                    <span class="ml-5 font-14 font-weight-500">{{ trans('update.access_period') }}:</span>
                                </div>
                                <span class="font-14">{{ $course->access_days }} {{ trans('public.days') }}</span>
                            </div>
                        @endif
                    </div>
                </div> --}}

                {{-- organization --}}
                {{-- @if ($course->creator_id != $course->teacher_id)
                    @include('web.default.course.sidebar_instructor_profile', [
                        'courseTeacher' => $course->creator,
                    ])
                @endif --}}
                {{-- teacher --}}
                {{-- @include('web.default.course.sidebar_instructor_profile', [
                    'courseTeacher' => $course->teacher,
                ]) --}}

                {{-- @if ($course->webinarPartnerTeacher->count() > 0)
                    @foreach ($course->webinarPartnerTeacher as $webinarPartnerTeacher)
                        @include('web.default.course.sidebar_instructor_profile', [
                            'courseTeacher' => $webinarPartnerTeacher->teacher,
                        ])
                    @endforeach
                @endif --}}
                {{-- ./ teacher --}}

                {{-- tags --}}
                {{-- @if ($course->tags->count() > 0)
                    <div class="rounded-lg tags-card shadow-sm mt-35 px-25 py-20">
                        <h3 class="sidebar-title font-16 text-secondary font-weight-bold">{{ trans('public.tags') }}</h3>

                        <div class="d-flex flex-wrap mt-10">
                            @foreach ($course->tags as $tag)
                                <a href=""
                                    class="tag-item bg-gray200 p-5 font-14 text-gray font-weight-500 rounded">{{ $tag->title }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif --}}
                {{-- ads --}}
                {{-- @if (!empty($advertisingBannersSidebar) and count($advertisingBannersSidebar))
                    <div class="row">
                        @foreach ($advertisingBannersSidebar as $sidebarBanner)
                            <div class="rounded-lg sidebar-ads mt-35 col-{{ $sidebarBanner->size }}">
                                <a href="{{ $sidebarBanner->link }}">
                                    <img src="{{ $sidebarBanner->image }}" class="img-cover rounded-lg"
                                        alt="{{ $sidebarBanner->title }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif --}}
            </div>
        </div>

        {{-- Ads Bannaer --}}
        {{-- @if (!empty($advertisingBanners) and count($advertisingBanners))
            <div class="mt-30 mt-md-50">
                <div class="row">
                    @foreach ($advertisingBanners as $banner)
                        <div class="col-{{ $banner->size }}">
                            <a href="{{ $banner->link }}">
                                <img src="{{ $banner->image }}" class="img-cover rounded-sm"
                                    alt="{{ $banner->title }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif --}}
        {{-- ./ Ads Bannaer --}}
    </section>

    {{-- <div id="webinarReportModal" class="d-none">
        <h3 class="section-title after-line font-20 text-dark-blue">{{ trans('product.report_the_course') }}</h3>

        <form action="/course/{{ $course->id }}/report" method="post" class="mt-25">

            <div class="form-group">
                <label class="text-dark-blue font-14">{{ trans('product.reason') }}</label>
                <select id="reason" name="reason" class="form-control">
                    <option value="" selected disabled>{{ trans('product.select_reason') }}</option>

                    @foreach (getReportReasons() as $reason)
                        <option value="{{ $reason }}">{{ $reason }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label class="text-dark-blue font-14"
                    for="message_to_reviewer">{{ trans('public.message_to_reviewer') }}</label>
                <textarea name="message" id="message_to_reviewer" class="form-control" rows="10"></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <p class="text-gray font-16">{{ trans('product.report_modal_hint') }}</p>

            <div class="mt-30 d-flex align-items-center justify-content-end">
                <button type="button"
                    class="js-course-report-submit btn btn-sm btn-primary">{{ trans('panel.report') }}</button>
                <button type="button"
                    class="btn btn-sm btn-danger ml-10 close-swl">{{ trans('public.close') }}</button>
            </div>
        </form>
    </div> --}}
{{--
    @include('web.default.course.share_modal')
    @include('web.default.course.buy_with_point_modal') --}}
@endsection

@push('scripts_bottom')
    <script src="/assets/default/js/parts/time-counter-down.min.js"></script>
    <script src="/assets/default/vendors/barrating/jquery.barrating.min.js"></script>
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var webinarDemoLang = '{{ trans('
            webinars.webinar_demo ') }}';
        var replyLang = '{{ trans('
            panel.reply ') }}';
        var closeLang = '{{ trans('
            public.close ') }}';
        var saveLang = '{{ trans('
            public.save ') }}';
        var reportLang = '{{ trans('
            panel.report ') }}';
        var reportSuccessLang = '{{ trans('
            panel.report_success ') }}';
        var reportFailLang = '{{ trans('
            panel.report_fail ') }}';
        var messageToReviewerLang = '{{ trans('
            public.message_to_reviewer ') }}';
        var copyLang = '{{ trans('
            public.copy ') }}';
        var copiedLang = '{{ trans('
            public.copied ') }}';
        var learningToggleLangSuccess = '{{ trans('
            public.course_learning_change_status_success ') }}';
        var learningToggleLangError = '{{ trans('
            public.course_learning_change_status_error ') }}';
        var notLoginToastTitleLang = '{{ trans('
            public.not_login_toast_lang ') }}';
        var notLoginToastMsgLang = '{{ trans('
            public.not_login_toast_msg_lang ') }}';
        var notAccessToastTitleLang = '{{ trans('
            public.not_access_toast_lang ') }}';
        var notAccessToastMsgLang = '{{ trans('
            public.not_access_toast_msg_lang ') }}';
        var canNotTryAgainQuizToastTitleLang = '{{ trans('
            public.can_not_try_again_quiz_toast_lang ') }}';
        var canNotTryAgainQuizToastMsgLang = '{{ trans('
            public.can_not_try_again_quiz_toast_msg_lang ') }}';
        var canNotDownloadCertificateToastTitleLang =
            '{{ trans('
                public.can_not_download_certificate_toast_lang ') }}';
        var canNotDownloadCertificateToastMsgLang =
            '{{ trans('
                public.can_not_download_certificate_toast_msg_lang ') }}';
        var sessionFinishedToastTitleLang = '{{ trans('
            public.session_finished_toast_title_lang ') }}';
        var sessionFinishedToastMsgLang = '{{ trans('
            public.session_finished_toast_msg_lang ') }}';
        var sequenceContentErrorModalTitle = '{{ trans('
            update.sequence_content_error_modal_title ') }}';
        var courseHasBoughtStatusToastTitleLang = '{{ trans('
            cart.fail_purchase ') }}';
        var courseHasBoughtStatusToastMsgLang = '{{ trans('
            site.you_bought_webinar ') }}';
        var courseNotCapacityStatusToastTitleLang = '{{ trans('
            public.request_failed ') }}';
        var courseNotCapacityStatusToastMsgLang = '{{ trans('
            cart.course_not_capacity ') }}';
        var courseHasStartedStatusToastTitleLang = '{{ trans('
            cart.fail_purchase ') }}';
        var courseHasStartedStatusToastMsgLang = '{{ trans('
            update.class_has_started ') }}';
        var joinCourseWaitlistLang = '{{ trans('
            update.join_course_waitlist ') }}';
        var joinCourseWaitlistModalHintLang = "{{ trans('update.join_course_waitlist_modal_hint') }}";
        var joinLang = '{{ trans('
            footer.join ') }}';
        var nameLang = '{{ trans('
            auth.name ') }}';
        var emailLang = '{{ trans('
            auth.email ') }}';
        var phoneLang = '{{ trans('
            public.phone ') }}';
        var captchaLang = '{{ trans('
            site.captcha ') }}';
    </script>

    <script src="/assets/default/js/parts/comment.min.js"></script>
    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/default/js/parts/webinar_show.min.js"></script>


    @if (
        !empty($course->creator) and
            !empty($course->creator->getLiveChatJsCode()) and
            !empty(getFeaturesSettings('show_live_chat_widget')))
        <script>
            (function() {
                "use strict"

                {
                    !!$course - > creator - > getLiveChatJsCode() !!
                }
            })(jQuery)
        </script>
    @endif
@endpush
