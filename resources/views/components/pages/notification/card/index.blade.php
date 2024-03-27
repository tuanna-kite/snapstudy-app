@props(['notification'])

<div
    class="sm:p-4 border-b border-grey-300 flex items-start gap-4 @unless ($notification->notificationStatus ? true : false) bg-primary.lighter @endunless">
    <div class="w-12 h-12">
        <img src="{{ asset('img/logo/avatar.png') }}" alt="logo" class="w-12 h-12">
    </div>
    <div class="space-y-1 flex-1">
        <p class="text-base md:text-base text-text.light.primary">
            <span class="font-semibold">{{ $notification->title }}
            </span>
        </p>
        <div class="flex items-center gap-3 text-text.light.secondary">
            <x-component.material-icon name="calendar_today" />
            <p class="text-base">
                {!! truncate($notification->message, 150, true) !!}
            </p>
        </div>
        <p class="text-text.light.secondary text-xs">
            {{ dateTimeFormatForHumans($notification->created_at) }}
        </p>
    </div>
</div>
