<form id="searchForm" action="{{ route('outline') }}" method="GET"
    class="rounded-full pl-6 px-1 md:pr-0.5 py-0.5 h-11 bg-white shadow-lg flex items-center justify-between">
    <input id="searchInput" class="flex-1 p-1 focus:border-transparent" type="text" name="search"
        placeholder="{{ trans('forms.Search a document') }}">
    <button type="submit" class="bg-primary.main rounded-full px-5 py-2 hidden md:block">
        <span class="font-medium text-sm text-white">
            {{ trans('forms.Search') }}
        </span>
    </button>
    <button type="submit" class="flex md:hidden">
        <x-component.material-icon name="search" />
    </button>
</form>
