@extends('web_v2.layouts.index')
@section('title', 'My Dashboard')

@section('content')
    <x-layouts.dashboard-layout title="{{ trans('panel.dashboard') }}">
        <div class="space-y-3">
            <div class="flex flex-col gap-3 xl:flex-row">
                <div class="w-full xl:w-3/5">
                    <x-pages.dashboard.welcome />
                </div>
                <div class="w-full xl:w-2/5 flex flex-col justify-between gap-3">
                    <x-pages.dashboard.pay :accountCharge="$accountCharge" />
                    {{-- Rank --}}
                    <div class="flex justify-center items-center p-24 xl:flex-1 rounded-3xl bg-white">
                        <span class="text-3xl font-bold">
                            Diamond
                        </span>
                    </div>
                </div>
            </div>
            {{-- Syllabus --}}
            <div class="rounded-3xl p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-lg">{{ trans('dashboard.My Syllabus') }}</h1>
                    <a href="{{ route('outline') }}">
                        <span class="flex items-center">
                            {{ trans('dashboard.View all') }} <x-component.material-icon name="chevron_right" />
                        </span>
                    </a>
                </div>
                <div class="">
                    @if (count($webinars))
                        <x-documents.document-grid :webinar="$webinars" />
                    @else
                        <div class="flex justify-center">
                            <x-pages.dashboard.no-course />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
