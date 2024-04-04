<a href="{{ route('support.conversations', ['id' => $support->id]) }}" >
    <div class="py-3 bg-white flex items-center gap-4">
    <div class="p-3 rounded-full bg-primary.lighter w-12 h-12 flex items-center justify-center">
        <x-component.icon name="note-favorite" class="w-12 h-12" />
    </div>
    <div class="flex-1">
        <div class="flex items-center justify-between">
            <p class="font-semibold text-sm text-text.light.primary">
                {{ $support->title }}
            </p>
            <p class="font-normal text-xs text-text.light.disabled">
                {{ dateTimeFormatForHumans($support->created_at,true,null,1) }}
            </p>
        </div>
        <div class="flex items-center justify-between gap-2">
            <p class="font-normal text-sm text-text.light.secondary max-w-48 truncate md:text-clip">
                @if(count($support->conversations) > 0)
                    {{ $support->conversations[0]->message }}
                @else
                    {{ $support->title }}
                @endif
            </p>
            <x-component.icon name='unread' width="10" height="10" />
        </div>
    </div>
</div>
</a>
