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
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo/logo.png') }}" class="max-w-32 w-full" alt="Logo">
        </a>

        <div class="flex items-center gap-2">
            <x-layouts.btn-language />
            @if (!auth()->check())
                <a href="/panel"
                    class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-3 sm:px-8 bg-primary.main">
                    <span class="font-medium text-sm text-white">{{ trans('header.Dashboard') }}</span>
                </a>
            @else
                <x-auth.btn-login />
            @endif
        </div>
    </div>
</nav>
