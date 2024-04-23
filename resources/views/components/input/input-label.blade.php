@props(['isOverlapping' => false, 'data'])

{{-- interface data{
    name:string;
    label:string;
    placeholder:string;
    type:string;
    value:string;
    disabled:boolean
} --}}

<div class="space-y-2 relative">
    @if ($isOverlapping)
        <label for="{{ $data['name'] }}">
            <span
                class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                {{ $data['label'] }}
            </span>
        </label>
    @else
        <label for="{{ $data['name'] }}" class="font-semibold text-sm text-text.light.primary">
            {{ $data['label'] }}</label>
    @endif
    <input {{ isset($data['disabled']) && $data['disabled'] ? 'disabled' : '' }} value="{{ $data['value'] ?? '' }}"
        class="px-3 py-4 border rounded-lg w-full border-grey-300" id="{{ $data['name'] }}"
        type="{{ $data['type'] ?? 'text' }}" name="{{ $data['name'] }}" placeholder="{{ $data['placeholder'] }}"
        {{ old($data['name']) }}>
</div>
