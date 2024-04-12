@props(['major'])

<a href="/classes?school={{ $major->id }}">
    <div class="flex items-center w-48 bg-primary.light p-2 gap-2 rounded-2xl">
        <div class="p-3 bg-white rounded-xl">
{{--            <x-component.icon :name="$major['icon']" width=24 height=24 />--}}
        </div>
        <div>
            <span class="text-primary.main text-sm font-semibold">
                {{ $major['slug'] }}
            </span>
        </div>
    </div>
</a>
