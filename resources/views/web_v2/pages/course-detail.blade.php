@extends('web_v2.layouts.index')

@section('title', 'Course Detail')

@push('styles_top')
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
    <x-layouts.home-layout>
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
                    @if ($hasBought)
                        <div>
                            <x-pages.course-detail.button-support :course="$course" />
                        </div>
                    @endif
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
                                <x-component.material-icon name="expand_more" x-show="openTab === null" />
                                <x-component.material-icon name="expand_less" x-show="openTab === 1" />
                            </div>
                            <div class="table_contents px-6 py-4" x-show="openTab === 1">
                                {!! !empty($docTrans) ? $docTrans->table_contents : '' !!}
                            </div>
                        </div>
                    </div>
                    {{-- Scroll Btn  --}}
                    @if ($hasBought)
                        <div x-show='scrolled'>
                            <div x-data="{ showModal: false, buttonPosition: { top: 0, right: 0 } }">
                                <!-- Button to toggle the modal -->
                                <button id="scrollBtn"
                                    class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
                                    @click="showModal = true; buttonPosition = $event.target.getBoundingClientRect()">
                                    {{ trans('course.Table of Contents') }}
                                </button>
                                <!-- Modal -->
                                <div x-show="showModal"
                                    class="fixed z-10 bottom-16 right-0 w-3/5 bg-white h-1/2 overflow-y-auto shadow-xl rounded-l-xl max-w-[240px]"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-90"
                                    x-transition:enter-end="opacity-100 transform scale-100"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 transform scale-100"
                                    x-transition:leave-end="opacity-0 transform scale-90" @click.away="showModal = false">
                                    <div class="table_contents bg-white p-6">
                                        <h3 class="text-lg my-4 font-semibold">{{ trans('course.Table of Contents') }}</h3>
                                        <!-- Modal content -->
                                        {!! !empty($docTrans) ? $docTrans->table_contents : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--  Content  --}}
                    <div class="space-y-6  mx-auto">
                        <h3 class="font-bold text-3xl text-primary.main">
                            {{ trans('course.DETAILED INSTRUCTION') }}
                        </h3>
                        @if (!$hasBought)
                            {{-- Content Preview --}}
                            <div id="document-content" class="relative">
                                {!! $docTrans->preview_content !!}
                                <div class="h-40 w-full absolute bottom-0"
                                    style="background: linear-gradient(360deg, #FFFFFF 0%, rgba(245, 246, 250, 0.1) 100%);">
                                </div>
                            </div>
                            {{-- Buy Btn --}}
                            <div class="flex flex-col items-center space-y-3">
                                <form method="post" action="/course/direct-payment">
                                    @csrf
                                    <input class="hidden" type="number" name="item_id" value="{{ $course->id }}">
                                    <input class="hidden" type="text" name="item_name" value="webinar_id">
                                    @if (auth()->user())
                                        <button type="submit"
                                            class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                            <span>{{ trans('course.Read more') }} ({{ $course->price }} AUD)</span>
                                            <x-component.material-icon name="arrow_downward" />
                                        </button>
                                    @else
                                        <button type="button" onclick="showModalAuth()"
                                            class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                            <span>{{ trans('course.Read more') }} ({{ $course->price }} AUD)</span>
                                            <x-component.material-icon name="arrow_downward" />
                                        </button>
                                    @endif

                                </form>
                                <p class="font-normal text-sm text-text.light.secondary">
                                    {{ trans('course.Charge your account to get a detailed instruction for the assignment') }}
                                </p>
                            </div>
                        @else
                            {{-- Content Detail --}}
                            <div id="document-content" style="overflow: hidden; max-width: 100vw !important;">
                                {!! !empty($docTrans) ? $docTrans->content : '' !!}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </x-layouts.home-layout>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('webinar.view', ['webinar' => $course->id]) }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response.message);

            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
