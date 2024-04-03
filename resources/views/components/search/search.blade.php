@props(['showIcon' => true])
<form id="searchForm" action="{{ route('home.search') }}" method="GET">
    <div {{ $attributes->merge(['class' => 'rounded-xl p-4 flex items-center bg-white justify-between relative']) }}>
        @if (!$showIcon)
            <label for="">
                <span
                    class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                    Search
                </span>
            </label>
        @endif
        <input class="flex-1" type="text" id="searchInput" placeholder="Search...">
        <button id='btnSearch' class="" type="submit">
            <x-component.icon name="ic_search" />
        </button>
    </div>
</form>
