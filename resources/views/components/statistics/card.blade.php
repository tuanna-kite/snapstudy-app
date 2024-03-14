@props(['data'])

<div class="flex flex-col gap-4 text-center">
    <div>
        <span class="text-4xl font-extrabold" style="color:{{ $data['color'] }}">
            {{ $data['number'] }}
        </span>
    </div>
    <div>
        <span class="text-base font-semibold" style="color:#032482">
            {{ $data['title'] }}
        </span>
    </div>
    <div>
        <span class="text-sm font-medium">
            {{ $data['content'] }}
        </span>
    </div>
</div>
