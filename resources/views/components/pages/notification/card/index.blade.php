@props(['isRead' => true])

<div
    class="sm:p-4 border-b border-grey-300 flex items-start gap-4 @unless ($isRead) bg-primary.lighter @endunless">
    <div class="w-12 h-12">
        <img src="img/logo/avatar.png" alt="logo" class="w-12 h-12">
    </div>
    <div class="space-y-1 flex-1">
        <p class="text-base md:text-base text-text.light.primary">
            <span class="font-semibold">SNAPS</span> published a new syllabus:
            <span class="font-semibold">
                Assignment 3: Individual Essay
            </span>
        </p>
        <div class="flex items-center gap-3 text-text.light.secondary">
            <x-component.material-icon name="calendar_today" />
            <p class="text-base">
                Available from 31/3/2024
            </p>
        </div>
        <p class="text-text.light.secondary text-xs">
            2 days ago
        </p>
    </div>
</div>
