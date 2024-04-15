@props(['showIcon' => true])
<form action="{{ route('outline') }}">
    <div class="flex items-center justify-between border border-components.input.outlined rounded-lg py-2 px-4">
        <input type="text" name="search" class="bg-primary.lighter flex-1"
            placeholder="{{ trans('course.Search outline') }}" {{ old('name') }}>
        <button type="submit">
            <x-component.icon name="ic_search" />
        </button>
    </div>
</form>
