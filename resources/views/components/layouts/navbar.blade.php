{{-- <x-layouts.notice-card /> --}}
<nav x-data="{ isScrolled: false, lastScrollTop: 0 }"
     x-on:scroll.window="
       let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
       isScrolled = currentScroll > lastScrollTop && currentScroll > 80;
       lastScrollTop = currentScroll;
     "
     :class="{'transition-transform duration-300 ease-in-out transform -translate-y-full': isScrolled, 'transition-transform duration-300 ease-in-out transform translate-y-0' :!isScrolled }"
     class="sticky top-0 z-10 bg-white shadow">
    <div class="container mx-auto flex justify-between items-center h-20">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
        </a>

        @if (auth()->check())
            <x-component.group-icon />
        @else
            <a href="{{ route('login') }}" class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-8 bg-primary.main">
                <span class="font-medium text-sm text-white">Login</span>
            </a>
        @endif
    </div>
</nav>
