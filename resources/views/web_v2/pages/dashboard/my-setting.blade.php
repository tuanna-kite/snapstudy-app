@extends('layouts.index')
@section('title', 'My Setting')

@section('content')
    <x-layouts.dashboard-layout title="Setting">
        <div class="rounded-3xl bg-white">
            <x-tab>
                <div x-show="activeTab === 1">
                    <x-pages.setting.general />
                </div>
                <div x-show="activeTab === 2" class="">
                    <!-- Content for Tab 2 -->
                    <x-pages.setting.notifications />
                </div>
                <div x-show="activeTab === 3" class="">
                    <!-- Content for Tab 3 -->
                    <x-pages.setting.update-password />
                </div>
            </x-tab>
        </div>
    </x-layouts.dashboard-layout>
@endsection
