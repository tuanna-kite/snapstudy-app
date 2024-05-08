@props(['isOverlapping' => false, 'data'])
{{-- interface data{
    name:string;
    label:string;
} --}}
<div class="space-y-2 relative">
    @if ($isOverlapping)
        <label for={{ $data['name'] }}>
            <span
                class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                {{ $data['label'] }}
            </span>
        </label>
    @else
        <label for={{ $data['name'] }} class="text-sm font-semibold">{{ $data['label'] }}</label>
    @endif
    <div class="">
        <textarea class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" placeholder=""
            id={{ $data['name'] }} name={{ $data['name'] }} rows="5" cols="50" {{ isset($data['required']) && $data['required'] ? 'required' : '' }}>
        </textarea>
    </div>
</div>
