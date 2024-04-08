@extends('web_v2.layouts.index')
@section('title', 'My Setting')

@php
    $listTab = [trans('dashboard.General'), trans('dashboard.Notifications'), trans('dashboard.Change Password')];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="Setting">
        <div class="rounded-3xl bg-white">
            <x-tab :listTab="$listTab">
                <x-slot name="tab1">
                    <x-pages.setting.general :user="$user" :countries="$countries" :listCity="$listCity" :listProvinces="$listProvinces" />
                </x-slot>
                <x-slot name="tab2">
                    <x-pages.setting.notifications :user="$user" />
                </x-slot>
                <x-slot name="tab3">
                    <x-pages.setting.update-password :user="$user" />
                </x-slot>
            </x-tab>
        </div>
    </x-layouts.dashboard-layout>
@endsection
