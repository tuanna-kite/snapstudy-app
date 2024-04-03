@props(['title', 'href', 'active'])

<div {{ $attributes->merge(['class' => 'flex']) }}>
    <div class="w-14 h-14 flex justify-center">
        <img src="{{ asset('img/anchor.png') }}" alt="anchor" width="12" height="50"
            class="transform translate-x-1/2">
    </div>
    <div class="flex-1 h-14 relative z-10">
        <a href={{ $href }}>
            <div class="absolute -left-2 bottom-0 min-w-24 w-full p-2 rounded-xl hover:bg-primary.light"
                style="transform:translateY(40%)">
                <span class="text-sm font-semibold text-text.light.disabled"
                    :class="{
                        'text-text.light.primary': {{ $active }},
                    }">
                    {{ $title }}
                </span>
            </div>
        </a>
    </div>
</div>
