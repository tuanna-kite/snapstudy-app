@props(['cardProps'])

<button class='menubtn' data-target="{{ $cardProps['href'] }}">
    <div class="min-w-48 flex gap-3 p-0.5 items-center rounded-xl  hover:bg-primary.light">
        <div class="p-4 bg-white rounded-xl">
            <x-component.icon :name="$cardProps['icon']" width="24" height="24" />
        </div>
        <div>
            <span class="font-semibold text-sm text-text.light.disabled ">
                {{ $cardProps['title'] }}
            </span>
        </div>
    </div>
</button>

<div class="min-w-48 -mt-1 hidden" id="{{ $cardProps['href'] }}">
    <x-slidebar.sub-card  />
    <x-slidebar.sub-card class="-mt-3" />
</div>
