@extends('web_v2.layouts.index')

@section('title', 'Not Found')

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto flex flex-col justify-center items-center space-y-16 py-32">
            <div>
                <img src="{{ asset('img/image-404.png') }}" class="max-w-md w-full" />
            </div>
            <div class="text-center space-y-8">
                <div class="space-y-4">
                    <h1 class="font-extrabold text-5xl text-text.light.primary">
                        {{ trans('home.Oops! Page Not Found') }}
                    </h1>
                    <p class="text-text.light.secondary">
                        {!! trans('home.Sorry, this site doesn’t exist or is being upgraded') !!}
                    </p>
                </div>
                <div class="flex justify-center">
                    <a href="{{ route('home') }}"
                        class="rounded-lg px-6 py-3 bg-primary.main flex items-center w-fit space-x-2 hover:opacity-90">
                        <x-component.material-icon name="arrow_back" class="text-white" />
                        <span class="font-medium text-sm text-white">
                            {{ trans('home.Back to home') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
