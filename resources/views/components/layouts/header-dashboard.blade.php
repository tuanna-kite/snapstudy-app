@props(['title'])

<nav class="flex items-center justify-between">
    <div class="lg:hidden block">
        <x-component.nav-mobile />
    </div>
    <h1 class="font-bold text-3xl hidden lg:block text-text.light.primary">{{ $title }}</h1>
    <div class="flex items-center gap-6">
        <x-layouts.btn-language />
        <div class="hidden md:block">
            <x-search.search-header />
        </div>
        <div class="block md:hidden">
            <x-search.search-mobile />
        </div>
        {{-- TODO: handle responsive with icon --}}
        <x-component.group-icon />
    </div>
</nav>
