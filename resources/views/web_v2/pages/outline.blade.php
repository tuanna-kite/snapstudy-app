@extends('web_v2.layouts.index')

@section('title', 'Outline Page')

@php
$outline_type = [
        'name' => 'Outline',
        ];
$exam_type = [
        'name' => 'Exam',
        ];
$question_type = [
        'name' => 'Question',
        ];
@endphp

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-24 space-y-8">
            {{-- title --}}
            <div class="flex flex-col items-start gap-2 md:flex-row justify-between md:items-center">
                <h1 class="font-bold text-2xl md:text-3xl text-primary.main">
                    {{ $subject }}
                </h1>
                <div class="w-full md:max-w-80">
                    <x-search.search-outline/>
                </div>
            </div>
            {{-- Content --}}
            <x-pages.outline.card :type="$outline_type" :outlines="$outlines"/>
            <x-pages.outline.card :type="$exam_type" :outlines="$exams"/>
            <x-pages.outline.card :type="$question_type" :outlines="$questions"/>
        </div>
    </x-layouts.home-layout>
@endsection
