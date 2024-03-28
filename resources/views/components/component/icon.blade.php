@props(['name'])


@if (file_exists("img/icon/$name.svg"))
    <img src="{{ asset('img/icon/' . $name . '.svg') }}" alt="cart"
        {{ $attributes->merge(['width' => 24, 'height' => 24]) }}>
@else
    <img alt="no-icon">
@endif
