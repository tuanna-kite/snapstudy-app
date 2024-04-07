@props(['item'])

<div class="p-6 rounded-3xl gap-4 bg-white">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo/avatar.png') }}" alt="" width="48" height="48">
            <div>
                <div>
                    <span class="font-semibold text-base text-text.light.primary">
                        {{ $item['name'] }}
                    </span>
                </div>
                <div>
                    <span class="font-medium text-sm text-text.light.secondary">
                        {{ $item['major'] }}
                    </span>
                </div>
            </div>
        </div>
        <div>
            <img src="{{ asset('img/logo/quotes.png') }}" alt="quotes" width="38" height="32">
        </div>
    </div>
    <div class='mt-4'>
        <span class="font-normal text-base">
            {{ $item['comment'] }}
        </span>
    </div>

</div>
