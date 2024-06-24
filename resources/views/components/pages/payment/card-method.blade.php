@props(['data'])

<label class="card relative bg-white rounded-2xl border-2 p-2 hover:shadow-lg">
    <div class="text-end">
        <input class="radio checked:accent-secondary.main" name="{{ $data['name'] }}" value="{{ $data['value'] }}" @checked($data['checked']) type="radio">
    </div>
    <div class="flex flex-col items-center gap-3 pb-6">
        <img src="{{ $data['img'] }}" class=" h-12" />
        <div class="text-center">
            <p class="font-semibold text-base">
                {{ $data['title'] }}
            </p>
            <p class="font-sm text-text.light.secondary">
                {{ $data['sub'] }}
            </p>
        </div>
    </div>
</label>
