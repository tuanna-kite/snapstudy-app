@extends('web_v2.layouts.index')
@section('title', 'My Support')

@php
    $input = [
        'name' => 'subject',
        'label' => 'Subject',
    ];

    $typeSelect = [
        'name' => 'type',
        'label' => 'Type',
        'options' => [
            'support' => 'Support',
            'report' => 'Report',
            'refund' => 'Refund',
        ],
    ];
    $syllabusSelect = [
        'name' => 'syllabus-support',
        'label' => 'Syllabus Support',
        'options' => [
            'all' => 'All',
            'rmit' => 'RMIT',
        ],
    ];
    $textarea = ['name' => 'message', 'label' => 'Message'];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="New Support">
        <div class="px-6 py-8 bg-white rounded-2xl space-y-4">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <x-input.input-label :data="$input" />
                <x-input.select-label :data="$typeSelect" />
                <x-input.select-label :data="$syllabusSelect" />
                <x-input.textarea-label :data="$textarea" />
                <div class="flex flex-col md:flex-row justify-between items-end">
                    <x-input.file-label />
                    <x-button.button text="Send Message" type='submit' class="mb-2" />
                </div>
            </form>
        </div>
    </x-layouts.dashboard-layout>
@endsection
