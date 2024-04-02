@extends('web_v2.layouts.index')
@section('title', 'My Learning')

@php
    $listTab = ['All', 'In Progress', 'Completed'];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="My Learning">
        <x-tab :listTab="$listTab">
            <x-input.input-group />
            <x-slot name="tab1">
                <!-- Content for In Progress tab -->
                <h1>I'm All</h1>
            </x-slot>
            {{-- End Content --}}
            <x-slot name="tab2">
                <!-- Content for In Progress tab -->
                <h1>i'm Inprogress</h1>
            </x-slot>
            <x-slot name="tab3">
                <!-- Content for Completed tab -->
                <h1>i'm Completed</h1>
            </x-slot>
            {{-- <x-component.pagination /> --}}
        </x-tab>
    </x-layouts.dashboard-layout>

@endsection
