@extends('web_v2.layouts.index')
@section('title', 'My Learning')

@php
    $listTab = ['All', 'In Progress', 'Completed'];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="My Learning">
        <x-tab :listTab="$listTab">
            {{-- TODO: Add submitHref here --}}
            <x-input.group-filter />

            <x-slot name="tab1">
                <x-documents.document-grid :webinar="$webinars" />
            </x-slot>

            <x-slot name="tab2">
                <h1>i'm Inprogress</h1>
            </x-slot>

            <x-slot name="tab3">
                <h1>i'm Completed</h1>
            </x-slot>
            {{-- {{ $webinars->appends(request()->input())->links('components.pagination.dashboard') }} --}}
        </x-tab>
    </x-layouts.dashboard-layout>

@endsection
