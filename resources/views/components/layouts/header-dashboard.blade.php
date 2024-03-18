@props(['title'])

<nav class="flex items-center justify-between">
    <h1 class="font-bold text-3xl text-text.light.primary">{{ $title }}</h1>
    <div class="flex items-center gap-8">
        <x-search.search />
        <x-layouts.icon-group class="gap-8" />
    </div>
</nav>
