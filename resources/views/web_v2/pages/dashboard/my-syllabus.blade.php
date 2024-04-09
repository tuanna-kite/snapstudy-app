@extends('web_v2.layouts.index')
@section('title', 'My Syllabus')

@section('content')
    <x-layouts.dashboard-layout title="Home">
        <div class="w-full space-y-12">
            <div class="space-y-4">
                <h1 class="font-normal text-2xl text-text.light.primary">
                    {{ trans('dashboard.Continue Learning') }}
                </h1>
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="w-full md:w-1/2">
                        @if (count($learningWebinars))
                            @foreach ($learningWebinars as $key => $trending)
                                @if ($key == 0)
                                    <x-documents.document-card :trending="$trending" />
                                @else
                                    @continue
                                @endif
                            @endforeach
                        @else
                            <x-pages.my-syllabus.no-syllabus />
                        @endif
                    </div>
                    <div class="w-full md:flex-1">
                        <x-pages.my-syllabus.status-card :countlearningWebinars="$countlearningWebinars" />
                    </div>
                </div>
            </div>
            {{-- List my syllabus --}}
            {{-- TODO: add href and controller for view my-syllabus-all --}}
            <div>
                <x-pages.my-syllabus.list title="{{ trans('dashboard.Recently Viewed Products') }}" href="/"
                    :webinars="$viewedWebinars" />
            </div>
            <div>
                <x-pages.my-syllabus.list title="{{ trans('dashboard.News on Snaps') }}" href="/" :webinars="$viewedWebinars" />
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
