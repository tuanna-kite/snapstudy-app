@props(['title'])

<div class="bg-primary.lighter min-h-[100vh]">
    {{-- sidebar --}}
    <div class="h-screen p-5 hidden lg:block lg:fixed">
        <x-slidebar.index>
            <img src="{{ asset('img/logo/logo.png') }}" alt="logo-snaps" width="130" height="50">
        </x-slidebar.index>
    </div>
    {{-- content --}}
    <div class="p-2 md:p-5 lg:pl-[296px] min-h-[100vh] flex flex-col">
        <x-layouts.header-dashboard :title="$title" />
        <div class="mt-10 flex-1 flex flex-col">
            {{ $slot }}
        </div>
    </div>
</div>
