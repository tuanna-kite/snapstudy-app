@props(['title'])

<nav class="flex items-center justify-between">
    <div class="lg:hidden block">
        <x-component.nav-mobile />
    </div>
    <h1 class="font-bold text-3xl hidden lg:block text-text.light.primary">{{ $title }}</h1>
    <div class="flex items-center gap-8">
        <div class="hidden md:block">
            {{-- TODO: when searching, it navigate to old version --}}
            <x-search.search-header />
        </div>
        <div class="block md:hidden">
            <x-search.search-mobile />
        </div>
        <x-component.group-icon class="gap-8" />
    </div>
</nav>
