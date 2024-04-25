<div
        class="py-4 px-6 bg-white flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between border-t border-grey-300 ">
    <div class="flex items-center gap-2 max-w-full overflow-hidden">
        <x-component.material-icon name="menu_book"/>
        <div class="flex flex-col max-w-full overflow-hidden">
            <a href="{{ $outline->getUrl() }}" id="title"
               class="truncate font-semibold text-base text-text.light.primary">
                {{ clean($outline->title, 'title') }}
            </a>
            <p class="truncate text-xs text-text.light.secondary">
                {{ clean($outline->seo_description, 'seo_description') }}
            </p>
        </div>
    </div>
    @if(!$outline->checkUserHasBought(auth()->user(), true, true))
        <div class="flex items-center justify-between gap-4 min-w-56 self-end">
            <p class="font-bold text-lg text-primary.main">{{ $outline->price }} AUD</p>
            <form method="post" action="/course/direct-payment">
                @csrf
                <input class="hidden" type="number" name="item_id" value="{{ $outline->id }}">
                <input class="hidden" type="text" name="item_name" value="webinar_id">

                <button type="submit" class="rounded-lg py-1.5 px-4 bg-secondary.main">
                    <span class="font-medium text-sm text-white">{{ trans('course.Buy now') }}</span>
                </button>
            </form>
        </div>
    @endif

</div>
