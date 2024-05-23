{{-- <x-layouts.notice-card /> --}}
<nav x-data="{ isScrolled: false, lastScrollTop: 0 }"
    x-on:scroll.window="
       let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
       isScrolled = currentScroll > lastScrollTop && currentScroll > 80 || currentScroll > 200;
       lastScrollTop = currentScroll;
     "
    :class="{
        'transition-transform duration-300 ease-in-out transform -translate-y-full': isScrolled,
        'transition-transform duration-300 ease-in-out transform translate-y-0':
            !isScrolled
    }"
    class="sticky top-0 z-10 bg-white shadow">
    <div class="container mx-auto flex justify-between items-center h-20">
        <div class="flex items-center gap-2">
            @if (auth()->check())
                <div class="block sm:hidden">
                    <x-component.nav-mobile />
                </div>
            @endif
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo/logo.png') }}" class="max-w-32 w-full" alt="Logo">
            </a>
        </div>

        <div class="flex items-center gap-6">
             <x-component.btn-language />
            @if (auth()->check())
                <div class='flex items-center gap-6'>
                    <a href="{{ route('Notification.index') }}">
                        <button class="flex justify-center items-center p-2 rounded-full" onclick="handleClick()">
                            <x-component.material-icon name="notifications" />
                        </button>
                    </a>
                    <div class="hidden sm:block">
                        <x-component.avatar />
                    </div>
                </div>
            @else
                <x-auth.btn-login />
            @endif
        </div>
    </div>
</nav>
