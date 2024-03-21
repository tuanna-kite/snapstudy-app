@props(['name'])


<span {{ $attributes->merge(['class' => 'material-icons']) }}>
    {{ $name }}
</span>
