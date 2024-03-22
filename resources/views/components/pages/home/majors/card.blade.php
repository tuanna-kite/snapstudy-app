@props(['major'])

<a href="#">
    <div class="flex items-center w-48 bg-primary.light p-2 gap-2 rounded-2xl">
        <div>
            <x-component.icon :name="$major['icon']" width=48 height=48 />
        </div>
        <div>
            <span class="text-primary.main text-sm font-semibold">
                {{ $major['content'] }}
            </span>
        </div>
    </div>
</a>
