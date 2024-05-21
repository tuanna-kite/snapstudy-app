@extends('web_v2.layouts.index')

@section('title', 'Question Detail')


@section('content')
    <x-layouts.home-layout>
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto">
                <div class="max-w-[960px] mx-auto space-y-6">
                    <h1 class="font-normal text-3xl text-text.light.primary">
                        {{ $webinar->category->slug }}
                    </h1>
                    <h2 class="font-extrabold text-5xl text-primary.main">
                        {{ $webinar->title }}
                    </h2>
                    <p class="font-normal text-base text-text.light.primary">
                        {{ $webinar->seo_description }}
                    </p>
                    {{-- TODO: open view after handle logic --}}
                    @if ($hasBought)
                        <div>
                            <x-pages.course-detail.button-support :course="$webinar" />
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
                        <x-pages.question-detail.quiz :quizQuestions="$quizQuestions" :totalQuestionsCount="$totalQuestionsCount"/>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
