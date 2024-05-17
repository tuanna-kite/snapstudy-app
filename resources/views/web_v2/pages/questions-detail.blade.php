@extends('web_v2.layouts.index')

@section('title', 'Question Detail')


@push('styles_top')
    <style>
        .table_contents h2 {
            display: none;
        }

        .table_contents ul li {
            color: #032482;
        }

        .table_contents ul li ul li {
            padding-left: 20px;
        }
    </style>
@endpush


@section('content')
    <x-layouts.home-layout>
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto">
                <div class="max-w-[960px] mx-auto space-y-6">
                    <h1 class="font-normal text-3xl text-text.light.primary">
                        {{ $course->category->slug }}
                    </h1>
                    <h2 class="font-extrabold text-5xl text-primary.main">
                        {{ $course->title }}
                    </h2>
                    <p class="font-normal text-base text-text.light.primary">
                        {{ $course->seo_description }}
                    </p>
                    {{-- TODO: open view after handle logic --}}
                    @if ($hasBought)
                        <div>
                            <x-pages.course-detail.button-support :course="$course" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class='container mx-auto py-16'>
                {{-- Content --}}
                <div class="max-w-[960px] mx-auto space-y-16">
                    {{--  Content  --}}
                    <div class="space-y-6 mx-auto">
                        <livewire:quiz />
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
