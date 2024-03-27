@extends('web_v2.layouts.index')

@section('title', 'Notification Page')

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-24 space-y-8">
            {{-- title --}}
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-2xl md:text-3xl text-primary.main">Your Notifications</h1>
                <button>
                    <span class="font-medium text-xs text-primary.main">Mark all as read</span>
                </button>
            </div>
            {{-- Content --}}
            <div class="rounded-3xl p-6 bg-white">
                <x-pages.notification.card :isRead=false />
                <x-pages.notification.card />
                <x-pages.notification.card :isRead=false />
                <x-pages.notification.card />
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
