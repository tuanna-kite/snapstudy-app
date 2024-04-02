@props(['menuItem', 'currentUrl'])

@php
    $tempCurrentUrl = url()->current();
@endphp

<div class="rounded-lg mb-2">
    @if (is_array($menuItem['tab']))
        <button x-effect="console.log(openTab)"
            @click="openTab ===  {{ json_encode($menuItem['href']) }}  ? openTab = null : openTab = {{ json_encode($menuItem['href']) }}"
            class="relative z-10 w-full">
            <div :class="{
                'bg-primary.light': openTab === {{ json_encode($menuItem['href']) }},
            }"
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
    @else
        <a href="{{ $menuItem['href'] }} ">
            <div :class="{
                'bg-primary.light': openTab === {{ json_encode($menuItem['href']) }},
            }"
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
        </a>
    @endif
    @if (is_array($menuItem['tab']))
        <div x-show="openTab === {{ json_encode($menuItem['href']) }}"
            x-transition:enter="transition ease-out duration-500 transform opacity-0"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <!-- Content for Accordion Item-->
            <div class="min-w-48 -mt-4 mb-4">
                @foreach ($menuItem['tab'] as $key => $value)
                    <x-slidebar.sub-card :title="$key" :href="$value" :active="$value === $tempCurrentUrl ? 'true' : 'false'" />
                @endforeach
            </div>
        </div>
    @endif
</div>
