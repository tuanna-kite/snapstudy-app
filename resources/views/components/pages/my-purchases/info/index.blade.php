<div class="rounded-3xl p-6 bg-white flex items-center justify-between">
    <p class="font-bold text-lg">
        {{ trans('dashboard.Cart') }} ({{ $purchasedCount }} {{ trans('dashboard.syllabus') }})
    </p>
    <a href="{{ route('classes') }}" class="flex items-center">
        <span class="font-medium text-xs text-text.light.disabled">
            {{ trans('dashboard.Continue Shopping') }}
        </span>
        <x-component.icon name='icon-right' width="18" height="18" />
    </a>
</div>
