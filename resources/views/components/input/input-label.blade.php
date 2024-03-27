@props(['isOverlapping' => false])

<div class="space-y-2 relative">
    @if ($isOverlapping)
        <label for="">
            <span
                class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                Type
            </span>
        </label>
    @else
        <label for="price" class="text-sm font-semibold">Type</label>
    @endif
    <div class="">
        <input class="px-3 py-4 border rounded-lg w-full" style="border-color: #DFE3E8" type="text" name="price"
            placeholder="">
    </div>
</div>
