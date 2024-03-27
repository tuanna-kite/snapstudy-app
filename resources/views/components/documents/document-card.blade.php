@props(['trending'])

<article class="flex flex-col flex-1 shadow-lg px-5 py-6 rounded-2xl bg-white space-y-4">
    <a class="text-primary.main p-2 bg-primary.lighter w-fit rounded-md">{{ $trending->category->title }}</a>
    <p class="flex items-center space-x-2">
        <img src="{{ asset('img/logo/rmit-logo.png') }}" alt="rmit-logo" width="40px" height="40px">
        <span class="font-semibold text-sm text-text.light.primary">RMIT University</span>
    </p>
    <a href="{{ $trending->getUrl() }}"
        class="text-primary.main font-semibold text-lg uppercase line-clamp-3">{{ clean($trending->title, 'title') }}</a>
    <p class="text-text.light.primary text-sm line-clamp-3">
        {{ $trending->seo_description }}
    </p>
</article>
