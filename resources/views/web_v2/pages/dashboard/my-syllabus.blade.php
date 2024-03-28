@extends('web_v2.layouts.index')
@section('title', 'My Syllabus')

@section('content')
    <x-layouts.dashboard-layout title="Home">
        <div class="w-full space-y-12">
            <div class="space-y-4">
                <h1 class="font-normal text-2xl text-text.light.primary">
                    Continue Learning
                </h1>
                <div class="flex flex-col md:flex-row items-start gap-6">
                    <div class="w-full md:flex-1">
                        <x-documents.document-card />
                    </div>
                    <div class="w-full md:flex-1">
                        <x-pages.my-syllabus.status-card />
                    </div>
                </div>
            </div>
            {{-- List my syllabus --}}
            <div>
                <x-pages.my-syllabus.list />
            </div>
            <div>
                <x-pages.my-syllabus.list />
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
