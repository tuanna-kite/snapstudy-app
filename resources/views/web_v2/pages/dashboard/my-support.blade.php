@extends('web_v2.layouts.index')
@section('title', 'My Support')

@section('content')
    <x-layouts.dashboard-layout title="New Support">
        <div class="px-6 py-8 bg-white rounded-2xl space-y-4">
            <x-input.input-label />
            <x-input.select-label />
            <x-input.select-label />
            <x-input.textarea-label />
            <x-input.file-label>
                <x-button.button text="Send Message" />
            </x-input.file-label>
        </div>
    </x-layouts.dashboard-layout>
@endsection
