@props(['school'])
@php
    $categoryIds = \App\Models\Category::where('parent_id', $school->id)->pluck('id')->toArray();
    $countWebinar = \App\Models\Webinar::whereIn('category_id', $categoryIds)->count();
@endphp
<a href="{{ route('classes') . '?school[]=' .$school->slug }}">
    <div
        class="rounded-3xl shadow-md gap-3 bg-white p-4 flex flex-col justify-between min-h-60 md:min-h-40  hover:-translate-y-3 transition-transform duration-300">
        <div class="flex flex-col items-center md:flex-row md:items-start gap-3">
            <img src="{{ $school->icon }}" alt="cart" width="48" height="48" class="">
            <div class="text-center md:text-start">
                <p class="font-semibold text-base text-primary.main line-clamp-2">
                    {{ $school->getDescriptionAttribute('description') }}
                </p>
                <p class="text-base text-text.light.secondary">
                    {{ $school->title }}
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-2 md:flex-row items-center justify-between">
            <div class="flex items-center gap-1">
                <x-component.material-icon class="text-text.light.disabled" style="font-size:16px"
                    name="library_books" />
                <p class="text-xs text-text.light.disabled">
                    {{ $countWebinar }} Outline
                </p>
            </div>
            <div class="rounded-lg border border-border-disabled py-1 px-2.5">
                <span class="font-medium text-xs text-action.light.disabled">See more</span>
            </div>
        </div>
    </div>
</a>
