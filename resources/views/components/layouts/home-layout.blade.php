<div>
    {{-- Header --}}
    <x-layouts.navbar />

    <div class="bg-primary.lighter">
        {{ $slot }}
    </div>
    {{-- Footer --}}
    <x-layouts.footer />
</div>
