@props(['title'])

<nav class="flex items-center justify-between">
    <h1 class="font-bold text-3xl text-text.light.primary">{{ $title }}</h1>
    <div class="flex items-center gap-8">
        <div class="hidden sm:block">
            <x-search.search />
        </div>
        <x-component.group-icon class="gap-8" />
    </div>
</nav>
