@extends('web_v2.layouts.index')
@section('title', 'My Document')

@section('content')
    <x-layouts.dashboard-layout title="Document">
        <div class="flex flex-1 md:flex-row bg-white rounded-3xl">
            {{-- Sidechat --}}
            <div class="w-full md:max-w-80 md:border-r border-border-disabled">
                <x-pages.my-document.sidechat :supports="$supports"/>
            </div>
            {{-- Content Chat --}}
            @if(!empty($selectSupport))
                <div class="flex-1 flex-col hidden md:flex">
                    <div class="border-b border-border-disabled">
                        <x-pages.my-document.headerchat :selectSupport="$selectSupport" />
                    </div>
                    <div class="flex-1">
                        <x-pages.my-document.bodychat :selectSupport="$selectSupport"/>
                    </div>
                    <div class="border-t border-border-disabled">
                        <x-pages.my-document.bodychat.chat :selectSupport="$selectSupport"/>
                    </div>
                </div>
            @endif
        </div>
    </x-layouts.dashboard-layout>
@endsection
