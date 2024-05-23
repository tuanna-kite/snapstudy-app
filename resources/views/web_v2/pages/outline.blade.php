@extends('web_v2.layouts.index')

@section('title', 'Outline Page')

@php
    $listTab = [trans('home.Outline'), trans('home.Exam'), trans('home.Question')];
@endphp

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-24 space-y-8">
            {{-- title --}}
            <div class="flex flex-col items-start gap-2 md:flex-row justify-between md:items-center">
                <h1 class="font-bold text-2xl md:text-3xl text-primary.main">
                    {{ !empty($subject) ? $subject->title : '' }}
                </h1>
                <div class="w-full md:max-w-80">
                    <x-search.search-outline />
                </div>
            </div>
            {{-- Content --}}
            <div class="rounded-3xl bg-white">
                <x-pages.outline.tab :listTab="$listTab">
                    <x-slot name="tab1">
                        <x-pages.outline.card :outlines="$outlines" />
                    </x-slot>
                    <x-slot name="tab2">
                        <x-pages.outline.card :outlines="$exams" />
                    </x-slot>
                    <x-slot name="tab3">
                        <x-pages.outline.card :outlines="$quizzes" />
                    </x-slot>
                </x-pages.outline.tab>
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
