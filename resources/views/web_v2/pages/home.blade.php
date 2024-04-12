@extends('web_v2.layouts.index')

@section('title', 'Home Page')

@push('styles_top')
    {{-- Swiper css --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
@endpush

@push('scripts_top')
    {{-- Swiper Script --}}
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@endpush


@section('content')
    <x-layouts.home-layout>
        {{-- Slide --}}
        <x-pages.home.slide />
        {{-- Search Document --}}
        <div class="flex flex-col gap-8 p-4 md:p-12 md:flex-row">
            <div class="w-full xl:w-3/4 flex flex-col">
                <div class="w-full xl:w-3/4 mx-auto">
                    <x-search.search-doc />
                </div>
                <h1
                    class="font-bold text-2xl md:text-3xl lg:text-4xl text-primary.main text-center mt-10 md:mt-20 lg:mt-24 mb-8 md:mb-12">
                    {{ trans('home.Search for outlines') }}
                </h1>
                <x-pages.home.majors :category="$category"/>
                <h1
                    class="font-bold text-2xl md:text-3xl lg:text-4xl text-primary.main text-center mt-20 md:mt-24 lg:mt-32 mb-8 md:mb-12">
                    {{ trans('home.We have solutions') }}
                </h1>
                <x-pages.home.statistics />
            </div>
            <div class="w-full xl:w-1/4  flex-col gap-4 hidden xl:flex">
                <img src="img/banner1.png" alt="banner1" class="w-full md:max-w-96">
                <img src="img/banner2.png" alt="banner2" class="w-full md:max-w-96">
            </div>
        </div>

        {{-- Video Tutorial --}}
        <div class="mt-24">
            <x-pages.home.video-tutorial />
        </div>

        {{-- Jump Start --}}
        <div class=" py-16 md:py-32 space-y-12 container mx-auto">
            <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-primary.main text-center uppercase">
                {!! trans('home.JUMPSTART YOUR SUCCESS') !!}
            </h1>
            <div class="">
                {{-- TODO: replace to Upcoming data --}}
                <x-pages.home.assignments.slide :webinarsComing="$upcomingCourses" />
            </div>
        </div>

        {{-- Advertisement --}}
        <div class="py-7 bg-primary.main">
            <div class="container mx-auto flex flex-col lg:flex-row justify-between items-center">
                <p class="font-bold text-2xl md:text-3xl text-white text-center lg:text-left">
                    {!! trans('home.SIGN UP NOW TO PURCHASE') !!}
                </p>
                <a href="{{ route('register') }}" class="mt-4 lg:mt-0">
                    <div class="rounded-full px-5 py-2 bg-secondary.main">
                        <span class="uppercase font-medium text-sm md:text-base text-white">
                            {{ trans('home.SIGN UP FOR FREE TRIAL') }}
                        </span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Start Learning Courses --}}
        <div class="py-10 md:py-24 space-y-10 container mx-auto ">
            <div class="space-y-2 ">
                <div class="flex items-center justify-between">
                    <h1 class="font-bold text-base sm:text-xl md:text-3xl lg:text-4xl text-primary.main">
                        {{ trans('home.Start learning with Top Trending Outlines') }}
                    </h1>
                    <a href="{{ route('classes') }}" class="flex items-center">
                        <span class="font-medium text-xs md:text-base text-text.light.secondary">
                            {{ trans('home.View all') }}
                        </span>
                        <x-component.icon name="icon-right" />
                    </a>
                </div>
                <p class="font-normal text-base md:text-lg text-text.light.primary">
                    {{ trans('home.Make a progress towards high scores') }}
                </p>
            </div>
            <div>
                <x-documents.document-grid :webinar="$webinar" />
            </div>
        </div>

        {{-- Student Result --}}
        <div class=" mt-10 md:mt-24 flex flex-col gap-2 md:flex-row items-center justify-between container mx-auto">
            <div class="space-y-6 md:space-y-12 w-full md:w-1/2">
                <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-primary.main">
                    {!! trans("home.Student's Results with SNAPS") !!}
                </h1>
                <p class="font-normal text-base md:text-lg">
                    <span class="font-bold text-3xl md:text-4xl lg:text-5xl text-secondary.main">96%</span> {{ trans('home.of our customers')}}
                </p>
            </div>
            <div class="w-full md:w-1/2 flex justify-center md:justify-end">
                <img src="img/student.png" alt="student">
            </div>
        </div>

        {{-- Testimonials --}}
        <div class="container  mx-auto space-y-12 mt-10 md:mt-24">
            <div class="text-center space-y-1">
                <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-primary.main uppercase">
                    {{trans('home.THE COMMUNITY WE ARE IN')}}
                </h1>
                <p class="font-normal text-base md:text-lg text-text.light.secondary">
                   {{trans('home.Over 3000 students')}}
                </p>
            </div>
            <x-pages.home.testimonials />
        </div>
        {{-- Advertisement --}}
        <div class="py-16">
            <x-layouts.footer-banner />
        </div>
    </x-layouts.home-layout>
@endsection
