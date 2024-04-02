<div class="p-6 rounded-3xl bg-primary.light">
    <a href="{{ route('my.learning') }}">
        <div class="flex items-center justify-between py-3">
            <p class="font-normal text-base text-text.light.primary">
                My learning ({{ $countlearningWebinars }})
            </p>
            <x-component.icon name='icon-right' width='24' height='24' />
        </div>
    </a>
{{--    <div class="flex items-center justify-between py-3">--}}
{{--        <p class="font-normal text-base text-text.light.primary">--}}
{{--            Completed--}}
{{--        </p>--}}
{{--        <x-component.icon name='icon-right' width='24' height='24' />--}}
{{--    </div>--}}
</div>
