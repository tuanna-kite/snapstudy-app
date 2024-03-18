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
        <select id="cars" name="cars" class="w-full border border-solid rounded-xl p-4"
            style="border-color: #DFE3E8">
            <option value="volvo">Volvo</option>
            <option value="saab">Saab</option>
            <option value="fiat">Fiat</option>
            <option value="audi">Audi</option>
        </select>
    </div>
</div>
