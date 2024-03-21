@props(['menuItem'])

<div class="rounded-lg mb-2">
    <button @click="openTab ===  {{ $menuItem['href'] }}  ? openTab = null : openTab = {{ $menuItem['href'] }}"
        class="relative z-10 w-full">
        <div :class="{ 'bg-primary.light': openTab === {{ $menuItem['href'] }}, 'bg-transparent': openTab !==
            {{ $menuItem['href'] }} }"
            class="min-w-48 flex gap-3 p-0.5 items-center rounded-xl hover:bg-primary.light">
            <div class="p-4 bg-white rounded-xl">
                <x-component.icon name="menu" width="24" height="24" />
            </div>
            <div>
                <span class="font-semibold text-sm text-text.light.disabled ">
                    {{ $menuItem['title'] }}
                </span>
            </div>
        </div>
    </button>
    <div x-show="openTab === {{ $menuItem['href'] }}"
    x-transition:enter="transition ease-out duration-500 transform opacity-0"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    >
        <!-- Content for Accordion Item-->
        <div class="min-w-48 -mt-4 mb-4">
            <x-slidebar.sub-card />
            <x-slidebar.sub-card class="-mt-3" />
        </div>
    </div>
</div>
