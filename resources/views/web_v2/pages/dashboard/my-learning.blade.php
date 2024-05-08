@extends('web_v2.layouts.index')
@section('title', 'My Learning')

@php
    $listTab = [trans('dashboard.All'), trans('Private'), trans('dashboard.Completed')];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="My Learning">
        <x-tab :listTab="$listTab">
            {{-- TODO: Add submitHref here --}}
{{--            <x-input.group-filter />--}}

            <x-slot name="tab1">
                <x-documents.document-grid :webinar="$webinars" />
            </x-slot>

            <x-slot name="tab2">
                <x-documents.document-grid :webinar="$webinar_privates" />
            </x-slot>

{{--            <x-slot name="tab3">--}}
{{--                <h1>i'm Completed</h1>--}}
{{--            </x-slot>--}}


            {{-- {{ $webinars->appends(request()->input())->links('components.pagination.dashboard') }} --}}
        </x-tab>
    </x-layouts.dashboard-layout>

@endsection
