@props(['displayChatIcon' => true])

<div {{ $attributes->merge(['class' => 'flex gap-4 items-start bg-white']) }}>
    @if ($displayChatIcon)
        <div class="p-3 rounded-full bg-primary.lighter">
            <x-component.icon name="note-favorite" />
        </div>
    @endif
    <div class="space-y-2">
        <p class="font-normal text-xs text-text.light.disabled">
            4:02 PM
        </p>
        <p class="rounded-lg p-3 bg-light-neutral">
            Hey John, I am looking for the best admin template. Could you please help me to find it out? 🤔
        </p>
    </div>
</div>
