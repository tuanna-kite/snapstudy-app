@props(['showIcon' => true])
<form action="{{ route('outline') }}" method="GET">
    <div {{ $attributes->merge(['class' => 'rounded-xl py-3 px-5 flex items-center bg-white justify-between relative']) }}>
        @if (!$showIcon)
            <label for="">
                <span
                    class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                    {{ trans('forms.Search') }}
                </span>
            </label>
        @endif
        <input id="searchInput" class="flex-1" type="text" name="search" placeholder=" {{ trans('forms.Search') }}">
        <button id='btnSearch' class="" type="submit">
            <x-component.icon name="ic_search" class="aspect-square" />
        </button>
    </div>
</form>
