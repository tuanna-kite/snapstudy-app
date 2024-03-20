@php
    $isLoggedIn = false
@endphp



<x-layouts.notice-card />
<nav class="sticky px-4 top-0 z-10 bg-white shadow">
    <div class="container mx-auto flex justify-between items-center h-20">
        <a href="#">
            <img src="img/logo/logo.png" alt="Logo">
        </a>
        @if ($isLoggedIn)
            <x-component.group-icon />
        @else
            <a class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-8 bg-primary.main">
                <span class="font-medium text-sm text-white">Login</span>
            </a>
        @endif
    </div>
</nav>
