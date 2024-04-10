    <div {{ $attributes->merge(['class' => 'flex items-center gap-4 ']) }}>
        <a href="{{ route('Notification.index') }}">
            <button class="flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
                <x-component.material-icon name="notifications_none" />
            </button>
        </a>
        <x-component.avatar />
    </div>
