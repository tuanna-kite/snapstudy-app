@props(['webinar'])

<div class="rounded-3xl p-5 flex flex-col gap-4 bg-white">
    <div class="rounded-lg p-2 bg-primary.lighter w-fit">
        <span class="font-normal text-xs text-primary.main">{{ $webinar->category->title }}</span>
    </div>
    <div class="flex items-center gap-2">
        <img src="{{ asset('img/logo/rmit-logo.png') }}" alt="logo-rmit" width="32" height="32">
        <span class="font-semibold text-sm text-text.light.primary">
            RMIT University
        </span>
    </div>
    <div class="line-clamp-1">
        <a href="{{ $webinar->getUrl() }}">
            <span class="font-semibold text-base text-primary.main uppercase">
                {{-- {{ clean($webinar->title, 'title') }} --}}
                {{ $webinar->title }}
            </span>
        </a>
    </div>
    <div class="line-clamp-1">
        <span class="font-normal text-sm text-text.light.primary ">
            {{ $webinar->seo_description }}
        </span>
    </div>
    <div class="flex justify-between items-center">
        <span class="font-medium text-xs text-text.light.primary">March 31,2024</span>
        <a href="#">
            <span class="font-medium text-sm text-text.light.disabled">
                See full outline >
            </span>
        </a>
    </div>
</div>
