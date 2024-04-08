@extends('web_v2.layouts.index')

@section('title', 'Notification Page')

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-24 space-y-8">
            {{-- title --}}
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-2xl md:text-3xl text-primary.main">{{ trans('notification.Your Notifications') }}</h1>
                <a href="{{ route('notification.read') }}">
                    <span class="font-medium text-xs text-primary.main">{{ trans('notification.Mark all as read') }}</span>
                </a>
            </div>
            {{-- Content --}}
            <div class="rounded-3xl p-6 bg-white">
                @if (!empty($notifications) and !$notifications->isEmpty())
                    @foreach ($notifications as $notification)
                        <x-pages.notification.card :notification="$notification" />
                    @endforeach
                @endif
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
