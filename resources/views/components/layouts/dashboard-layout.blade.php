@props(['title'])

<div>
    {{-- sidebar --}}
    <div class="h-screen p-5 hidden lg:block lg:fixed ">
        <x-slidebar.index />
    </div>
    {{-- content --}}
    <div class="pl-10 pt-10 pr-10 lg:pl-[296px] ">
        <x-layouts.header-dashboard :title="$title" />
        <div class="mt-10">
            {{ $slot }}
        </div>
    </div>
</div>
