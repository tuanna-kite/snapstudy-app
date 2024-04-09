@extends('web_v2.layouts.index')
@section('title', 'My Document')

@section('content')
    <x-layouts.dashboard-layout title="Document">
        <div class="flex flex-1 flex-row bg-white rounded-3xl">
            {{-- Sidechat --}}
            <div class="sm:max-w-80 border-r flex-shrink-0 border-border-disabled">
                <x-pages.my-document.sidechat :supports="$supports" />
            </div>
            {{-- Content Chat --}}
            <div class="flex-1 flex flex-col min-w-80">
                @if (!empty($selectSupport))
                    <div class="border-b border-border-disabled">
                        <x-pages.my-document.headerchat :selectSupport="$selectSupport" />
                    </div>
                    <div class="flex-1">
                        <x-pages.my-document.bodychat :selectSupport="$selectSupport" />
                    </div>
                    <div class="border-t border-border-disabled">
                        <x-pages.my-document.bodychat.chat :selectSupport="$selectSupport" />
                    </div>
                @endif
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
