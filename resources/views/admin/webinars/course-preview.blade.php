@extends('admin.layouts.app')

@section('title', 'Course Preview')

@push('styles_top')
    <script src="/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="/assets/admin/vendor/poper/popper.min.js"></script>
    <script src="/assets/admin/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="/assets/admin/vendor/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="/assets/admin/vendor/moment/moment.min.js"></script>
    <script src="/assets/admin/js/stisla.js"></script>
    <script src="/assets/default/vendors/toast/jquery.toast.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .table_contents h2 {
            display: none;
        }

        .table_contents ul li {
            color: #032482;
        }

        .table_contents ul li ul li {
            padding-left: 20px;
        }

        #document-content ul {
            padding-inline-start: 24px !important;
            list-style: square !important;
        }

        #document-content ul li {
            margin: 0 !important;
        }

        #document-content table {
            display: block;
            overflow: auto;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto">
                <div class="max-w-[960px] mx-auto space-y-6">
                    <h1 class="font-normal text-3xl text-text.light.primary">
                        {{ $course->category->slug }}
                    </h1>
                    <h2 class="font-extrabold text-5xl text-primary.main">
                        {{ $course->title }}
                    </h2>
                    <p class="font-normal text-base text-text.light.primary">
                        {{ $course->seo_description }}
                    </p>
                    {{-- TODO: open view after handle logic --}}
                    {{-- <div>
                        <x-pages.course-detail.button-support />
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class='container mx-auto py-16' x-data="{ scrolled: false }"
                @scroll.window="scrolled = (window.scrollY > document.getElementById('targetDiv').offsetTop + document.getElementById('targetDiv').offsetHeight)">
                {{-- Content --}}
                <div class="max-w-[960px] mx-auto space-y-16">
                    {{-- Table Content --}}
                    <div x-data="{ openTab: 1 }" id="targetDiv" class="bg-white  mx-auto">
                        <div class="border border-grey-300 rounded-2xl">
                            <div class="px-6 py-3 bg-primary.main rounded-t-2xl flex justify-between items-center text-white"
                                x-on:click="openTab !== 1 ? openTab = 1 : openTab = null">
                                <h6 class="font-bold text-xl">
                                    {{ trans('course.Table of Contents') }}
                                </h6>
                            </div>
                            <div class="table_contents px-6 py-4" x-show="openTab === 1">
                                {!! $docTrans->table_contents !!}
                            </div>
                        </div>
                    </div>

                    {{--  Content  --}}
                    <div class="space-y-6  mx-auto">
                        <h3 class="font-bold text-3xl text-primary.main">
                            {{ trans('course.Content') }}
                        </h3>
                        @if (!$hasBought)
                            <div id="document-content" class="relative">
                                {!! $docTrans->preview_content !!}
                                <div class="h-40 w-full absolute bottom-0"
                                    style="background: linear-gradient(360deg, #FFFFFF 0%, rgba(245, 246, 250, 0.1) 100%);">
                                </div>
                            </div>
                            <div class="flex flex-col items-center space-y-3">
                                <form method="post" action="/course/direct-payment">
                                    @csrf
                                    <input class="hidden" type="number" name="item_id" value="{{ $course->id }}">
                                    <input class="hidden" type="text" name="item_name" value="webinar_id">
                                    @if (auth()->user())
                                        <button type="submit"
                                            class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                            <span>{{ trans('course.Read more') }} ({{ handlePrice($course->price) }})</span>
                                            <x-component.material-icon name="arrow_downward" />
                                        </button>
                                    @else
                                        <button type="button" onclick="showModalAuth()"
                                            class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                            <span>{{ trans('course.Read more') }} ({{ handlePrice($course->price) }})</span>
                                            <x-component.material-icon name="arrow_downward" />
                                        </button>
                                    @endif

                                </form>
                                <p class="font-normal text-sm text-text.light.secondary">
                                    {{ trans('course.Charge your account to get a detailed instruction for the assignment') }}
                                </p>
                            </div>
                        @else
                            <div id="document-content" style="overflow: hidden; max-width: 100vw !important;">
                                {!! $docTrans->content !!}
                            </div>
                        @endif
                    </div>
                    <div class="row mt-5">
                        <div class="col-12">
                            @can('admin_webinars_edit')
                                <a class="btn btn-primary" href="{{ route('webinar.edit', ['id' => $course->id]) }}">Edit</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

