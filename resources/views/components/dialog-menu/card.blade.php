@props(['cardProps'])

<a href="{{ $cardProps['href'] }}">
    <div class="min-w-48 flex gap-3 items-center rounded-xl bg-white hover:bg-primary.light">
        <div class="p-2 bg-white rounded-xl">
            <x-component.icon :name="$cardProps['icon']" width="20" height="20" />
        </div>
        <div>
            <span class="font-normal text-sm ">
                {{ $cardProps['title'] }}
            </span>
        </div>
    </div>
</a>
