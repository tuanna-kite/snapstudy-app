@extends('layouts.index')
@section('title', 'My Document')

@section('content')
    <x-layouts.dashboard-layout title="Document">
        <div class="flex flex-1 md:flex-row bg-white rounded-3xl">
            {{-- Sidechat --}}
            <div class="w-full md:max-w-80 md:border-r border-border-disabled">
                <x-pages.my-document.sidechat />
            </div>
            {{-- Content Chat --}}
            <div class="flex-1 flex-col hidden md:flex">
                <div class="border-b border-border-disabled">
                    <x-pages.my-document.headerchat />
                </div>
                <div class="flex-1">
                    <x-pages.my-document.bodychat />
                </div>
                <div class="border-t border-border-disabled">
                    <x-pages.my-document.bodychat.chat />
                </div>
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
