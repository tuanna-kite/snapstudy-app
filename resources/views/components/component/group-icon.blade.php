    <div {{ $attributes->merge(['class' => 'flex items-center gap-6 ']) }}>
        <a href="{{ route('my.learning') }}">
            <button class="hidden p-2 rounded-full sm:flex justify-center items-center" onclick="handleClick()">
                <x-component.material-icon name="shopping_cart" />
            </button>
        </a>
        <a href="{{ route('Notification.index') }}">
            <button class="hidden sm:flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
                <x-component.material-icon name="notifications_none" />
            </button>
        </a>
        <button class="p-0.5 rounded-full border" onclick="handleClick()">
            <img src="{{ $authUser->getAvatar() ? $authUser->getAvatar() : '' }}"
                class="w-10 aspect-square rounded-full" alt="avt">
        </button>
    </div>
