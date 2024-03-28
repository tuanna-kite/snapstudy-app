
    <div {{ $attributes->merge(['class' => 'flex items-center']) }}>
        <button class="hidden p-2 rounded-full sm:flex justify-center items-center" onclick="handleClick()">
            <x-component.material-icon name="shopping_cart" />
        </button>
        <a href="{{ route('Notification.index') }}">
            <button class="hidden sm:flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
                <x-component.materßial-icon name="notifications_none" />
            </button>
        </a>
        <button class="p-2 rounded-full" onclick="handleClick()">
            <img src="{{ $authUser->getAvatar() ? $authUser->getAvatar() : '' }}" alt="" width="40" height="40">
        </button>
    </div>

