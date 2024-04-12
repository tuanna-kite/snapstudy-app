@props(['name'])


<span {{ $attributes->merge(['class' => 'material-symbols-rounded', 'style']) }}>
    {{ $name }}
</span>
