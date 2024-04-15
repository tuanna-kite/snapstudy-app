{{-- interface data {
    label:string;
    name:string;
    options: string[];
} --}}
@props(['isOverlapping' => false, 'data'])

<div class="space-y-2 relative" id="{{ $data['id'] ?? '' }}">
    @if ($isOverlapping)
        <label for="{{ $data['name'] }}">
            <span
                class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                {{ $data['label'] }}
            </span>
        </label>
    @else
        <label for="{{ $data['name'] }}" class="text-sm font-semibold"> {{ $data['label'] }}</label>
    @endif
    <div class="">
        <select id="{{ $data['name'] }}" name="{{ $data['name'] }}"
            class="w-full border border-grey-300 rounded-xl p-[18px]">
            @foreach ($data['options'] as $key => $value)
                <option value={{ $key }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
