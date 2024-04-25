@php
    $item = !empty($sale->webinar) ? $sale->webinar : $sale->bundle;

    $lastSession = !empty($sale->webinar) ? $sale->webinar->lastSession() : null;
    $nextSession = !empty($sale->webinar) ? $sale->webinar->nextSession() : null;
    $isProgressing = false;

    if(!empty($sale->webinar) and $sale->webinar->start_date <= time() and !empty($lastSession) and $lastSession->date > time()) {
        $isProgressing = true;
        }
@endphp

@if(!empty($item))
    <div class="px-6 py-8 space-y-4 bg-white border-b" style="border-color: #DFE3E8">
    <div class="flex items-center justify-between gap-8">
        <div class="flex flex-col gap-2 items-start md:flex-row md:items-center justify-between md:gap-12 flex-1">
            <a href="{{ $item->getUrl() }}" class="font-bold text-base text-primary.main">
                {{ $item->title }}
            </a>
            <span class="font-semibold text-base text-secondary.main">
                {{ $item->price }} AUD
            </span>
        </div>
{{--        <x-component.icon name="ic_trash" width="24" height="24" />--}}
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
        {{-- Can Loop --}}
        <div class="space-y-1">
            <p class="font-normal text-sm text-text.light.disabled">
                Item ID
            </p>
            <p class="font-semibold text-sm text-text.light.primary">
                {{ $item->id }}
            </p>
        </div>
        <div class="space-y-1">
            <p class="font-normal text-sm text-text.light.disabled">
                Category
            </p>
            <p class="font-semibold text-sm text-text.light.primary">
                {{ !empty($item->category_id) ? $item->category->title : '' }}
            </p>
        </div>
        <div class="space-y-1">
            <p class="font-normal text-sm text-text.light.disabled">
                Instructor
            </p>
            <p class="font-semibold text-sm text-text.light.primary">
                {{ $item->teacher->full_name }}
            </p>
        </div>
        <div class="space-y-1">
            <p class="font-normal text-sm text-text.light.disabled">
                Purchase Date
            </p>
            <p class="font-semibold text-sm text-text.light.primary">
                {{ dateTimeFormat($sale->created_at,'j M Y') }}
            </p>
        </div>
    </div>
</div>
@endif
