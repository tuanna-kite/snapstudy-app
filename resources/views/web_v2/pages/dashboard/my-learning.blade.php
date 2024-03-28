@extends('web_v2.layouts.index')
@section('title', 'My Learning')

@section('content')
    <x-layouts.dashboard-layout title="My Learning">
        <x-tab>
            <div class="bg-white p-6">
                <div class="p-6">
                    <x-input.input-group />
                </div>
                <div x-show="activeTab === 1" class="">
                    <!-- Content for Tab 1 -->
                    <x-documents.document-grid />
                </div>
                <div x-show="activeTab === 2" class="">
                    <!-- Content for Tab 2 -->
                    <x-documents.document-grid />
                </div>
                <div x-show="activeTab === 3" class="">
                    <!-- Content for Tab 3 -->
                    <x-documents.document-grid />
                </div>
            </div>
            <x-component.pagination />
        </x-tab>
    </x-layouts.dashboard-layout>

@endsection
