<div class="rounded-2xl shadow-md  bg-white">
    <div>
        {{-- Content Expand --}}
        @foreach ($outlines as $outline)
            @if ($loop->last)
                <div class="rounded-b-2xl overflow-hidden">
                    <x-pages.outline.sub-card :outline="$outline" />
                </div>
            @else
                <x-pages.outline.sub-card :outline="$outline" />
            @endif
        @endforeach
    </div>
</div>
