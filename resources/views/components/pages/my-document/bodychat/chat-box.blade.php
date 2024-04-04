@props(['displayChatIcon' => true, 'conversation'])

<div {{ $attributes->merge(['class' => 'flex gap-4 items-start bg-white']) }}>
    @if ($displayChatIcon)
        <div class="p-3 rounded-full bg-primary.lighter">
            <x-component.icon name="note-favorite" />
        </div>
    @endif
    <div class="space-y-2">
        <p class="font-normal text-xs text-text.light.disabled">
            {{ dateTimeFormatForHumans($conversation->created_at,true,null,1) }}
        </p>
        <p class="rounded-lg p-3 bg-light-neutral">
            {{ $conversation->message }}
        </p>
    </div>
</div>
