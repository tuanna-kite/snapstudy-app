<div x-data="{ openTab: 1 }" x-on:click="openTab !== 1 ? openTab = 1 : openTab = null"
    class="rounded-2xl shadow-md  bg-white">
    <div class="flex items-center justify-between px-6 py-4">
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

    <div class="" x-show="openTab === 1">
        {{-- Content Expand --}}
        <x-pages.outline.sub-card />
        <x-pages.outline.sub-card />
        <x-pages.outline.sub-card />
        <div class="rounded-b-2xl overflow-hidden">
            <x-pages.outline.sub-card />
        </div>
    </div>
</div>
