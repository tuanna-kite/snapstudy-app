@props(['name'])


<span {{ $attributes->merge(['class' => 'material-icons', 'style' => '']) }}>
    {{ $name }}
</span>
