@props(['title'])

<nav class="flex items-center justify-between">
    <div class="lg:hidden flex items-center gap-2">
        <x-component.nav-mobile />
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo/logo.png') }}" class="max-w-32 w-full" alt="Logo">
        </a>
    </div>
    <h1 class="font-bold text-3xl hidden lg:block text-text.light.primary">{{ $title }}</h1>
    <div class="flex items-center gap-6">
        <div class="hidden md:flex">
            <x-search.search-header />
        </div>
        <div class="block md:hidden">
            <x-search.search-mobile />
        </div>
        <x-component.btn-language />
        <div class='flex items-center gap-4'>
            <a href="{{ route('Notification.index') }}">
                <button class="flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
                    <x-component.material-icon name="notifications" />
                </button>
            </a>
            <div class="hidden lg:block">
                <img src="{{ $authUser->getAvatar() ? $authUser->getAvatar() : '' }}"
                    class="w-10 aspect-square rounded-full" alt="avt">
            </div>
        </div>
    </div>
</nav>
