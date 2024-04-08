@props(['handleBtn'])
<div x-data="{ inputType: 'password' }" class="rounded-xl p-3 flex items-center bg-white justify-between border">
    <input x-bind:type="inputType" class="flex-1"
        {{ $attributes->merge(['name' => '', 'type' => 'password', 'placeholder' => '', 'id' => '']) }}>
    <button type="button" @click="inputType = (inputType === 'text') ? 'password' : 'text'">
        <x-component.icon name='ic_eye' width='24' height='24' />
    </button>
</div>
