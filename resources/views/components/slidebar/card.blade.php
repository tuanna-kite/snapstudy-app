@props(['cardProps'])

<a href="{{ $cardProps['href'] }}">
    <div class="min-w-48 flex gap-3 items-center  rounded-xl bg-white hover:bg-primary.light">
        <div class="p-4 bg-white rounded-xl">
            <x-icon :name="$cardProps['icon']" width="24" height="24" />
        </div>
        <div>
            <span class="font-semibold text-sm text-text.light.disabled ">
                {{ $cardProps['title'] }}
            </span>
        </div>
    </div>
</a>
