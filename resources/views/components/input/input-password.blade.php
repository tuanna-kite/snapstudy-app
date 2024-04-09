@props(['isOverlapping' => false, 'data'])

{{-- interface data{
    name:string;
    label:string;
    placeholder:string;
} --}}

<div x-data="{ inputType: 'password' }" class="space-y-2 relative ">
    @if ($isOverlapping)
        <label for="{{ $data['name'] }}">
            <span
                class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                {{ $data['label'] }}
            </span>
        </label>
    @else
        <label for="{{ $data['name'] }}" class="text-sm text-text.light.primary"> {{ $data['label'] }}</label>
    @endif
    <div class="px-3 py-4 border rounded-lg w-full flex items-center bg-white justify-between">
        <input x-bind:type="inputType" class="flex-1" name="{{ $data['name'] }}"
            type="{{ $data['type'] ?? 'password' }}" placeholder="{{ $data['placeholder'] }}">
        <button type="button" @click="inputType = (inputType === 'text') ? 'password' : 'text'">
            <x-component.icon name='ic_eye' width='24' height='24' />
        </button>
    </div>
</div>
