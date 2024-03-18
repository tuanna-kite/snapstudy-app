<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <button class="p-2 rounded-full transparent focus:outline-none" onclick="handleClick()">
        <x-icon name='cart' />
    </button>
    <button class="p-2 rounded-full transparent focus:outline-none" onclick="handleClick()">
        <x-icon name='notifications' />
    </button>
    <button class="p-2 rounded-full transparent focus:outline-none" onclick="handleClick()">
        <img src="img/logo/avatar.png" alt="" width="48" height="48">
    </button>
</div>
