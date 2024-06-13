@extends('admin.layouts.app')

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.css">
    <link href="/assets/default/vendors/sortable/jquery-ui.min.css" />
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ trans('admin/main.quizzes') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ getAdminPanelUrl() }}">{{ trans('admin/main.dashboard') }}</a>
                </div>
                <div class="breadcrumb-item">{{ trans('admin/main.quizzes') }}</div>
            </div>
        </div>

        <div class="section-body">
            @include('admin.quizzes.modals.multiple_question', ['quiz' => $quiz])
        </div>
    </section>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/feather-icons/dist/feather.min.js"></script>
    <script src="/assets/default/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="/assets/default/vendors/sortable/jquery-ui.min.js"></script>

    <script>
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
    </script>

    <script src="/assets/default/js/admin/quiz.min.js"></script>

    <script src="https://cdn.tiny.cloud/1/8mkg9v8whf8cy0r8589h2cvrm67v8gw6xzf1k9ey6c4shsea/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        function initTinymce() {
            console.log("INIT TINY MCE")
            tinymce.init({
                selector: 'textarea.tinymce',
                plugins: 'fullscreen anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker permanentpen advtable advcode editimage advtemplate mentions tableofcontents footnotes mergetags inlinecss markdown',
                toolbar: 'fullscreen tableofcontents blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | addcomment showcomments | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                images_file_types: 'jpg,svg,webp,png',
                height: 300,
            });
        }

        initTinymce()
    </script>
@endpush
