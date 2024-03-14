@props(['iconName', 'content'])

<a href="#">
    <div class="flex items-center w-60 bg-primary.light p-2 gap-2 rounded-2xl">
        <div>
            <x-icon :name='$iconName' width=48 height=48 />
        </div>
        <div>
            <span class="text-primary.main text-sm font-semibold">
                {{ $content }}
            </span>
        </div>
    </div>
</a>
