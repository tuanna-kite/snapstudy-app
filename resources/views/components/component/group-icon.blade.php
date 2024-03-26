<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <button class="hidden p-2 rounded-full sm:flex justify-center items-center" onclick="handleClick()">
        <x-component.material-icon name="shopping_cart" />
    </button>
    <button class="hidden sm:flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
        <x-component.material-icon name="notifications_none" />
    </button>
    <button class="p-2 rounded-full" onclick="handleClick()">
        <img src="{{ asset('img/logo/avatar.png') }}" alt="" width="48" height="48">
    </button>
</div>
