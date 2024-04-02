@props(['name'])


<span {{ $attributes->merge(['class' => 'material-icons-round', 'style' => '']) }}>
    {{ $name }}
</span>
