@extends('web_v2.layouts.index')
@section('title', 'My Setting')

@php
    $listTab = ['General', 'Notifications', 'Change Password'];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="Setting">
        <div class="rounded-3xl bg-white">
            <x-tab :listTab="$listTab">
                <x-slot name="tab1">
                    <x-pages.setting.general :user="$user" />
                </x-slot>
                {{-- End Content --}}
                <x-slot name="tab2">
                    <x-pages.setting.notifications />
                </x-slot>
                <x-slot name="tab3">
                    <x-pages.setting.update-password />
                </x-slot>
            </x-tab>
        </div>
    </x-layouts.dashboard-layout>
@endsection
