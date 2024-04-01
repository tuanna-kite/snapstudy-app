@extends('web_v2.layouts.index')
@section('title', 'My Learning')

@section('content')
    <x-layouts.dashboard-layout title="My Learning">
        <x-tab>
            <div class="bg-white p-6">
                <div x-show="activeTab === 1" class="">
                    <!-- Content for Tab 1 -->
                    <x-documents.document-grid :webinar="$webinars" />
                </div>
            </div>
{{--            <x-component.pagination />--}}
        </x-tab>
    </x-layouts.dashboard-layout>

@endsection
