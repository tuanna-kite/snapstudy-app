@props(['text'])

<button {{ $attributes->merge(['class' => 'rounded-xl px-5 py-1.5 bg-primary.main text-white', 'type' => 'button']) }}>
    <span class="font-medium text-sm">
        {{ $text }}
    </span>
</button>
