@props(['showIcon' => true])
<form action="#" method="">
    <div
        class="flex items-center justify-between border border-components.input.outlined rounded-lg py-2 px-4">
        <input type="text" class="bg-primary.lighter flex-1" placeholder="Search outline">
        <button type="submit">
            <x-component.icon name="ic_search" />
        </button>
    </div>
</form>
