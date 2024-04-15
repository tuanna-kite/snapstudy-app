<div x-data="{ openTab: 1 }" class="rounded-2xl shadow-md  bg-white">
    <div class="flex items-center justify-between px-6 py-4" x-on:click="openTab !== 1 ? openTab = 1 : openTab = null">
        <div>
            <p class="font-semibold text-base text-primary.main">
                OUTLINE
            </p>
            <p class="text-xs text-text.light.secondary">
                Lorem ipsum dolor sit amet consectetur.
            </p>
        </div>
        <div class="flex">
            <x-component.material-icon name="expand_more" x-show="openTab === null" />
            <x-component.material-icon name="expand_less" x-show="openTab === 1" />
        </div>
    </div>

    <div x-show="openTab === 1" x-transition:enter="transition ease-out duration-500 transform"
        x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        {{-- Content Expand --}}
        @foreach ($outlines as $outline)
            @if ($loop->last)
                <div class="rounded-b-2xl overflow-hidden">
                    <x-pages.outline.sub-card :outline="$outline" />
                </div>
            @else
                <x-pages.outline.sub-card :outline="$outline" />
            @endif
        @endforeach
    </div>
</div>
