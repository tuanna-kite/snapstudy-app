@php
    $userLanguages = !empty($generalSettings['site_language'])
        ? [$generalSettings['site_language'] => getLanguages($generalSettings['site_language'])]
        : [];

    if (!empty($generalSettings['user_languages']) and is_array($generalSettings['user_languages'])) {
        $userLanguages = getLanguages($generalSettings['user_languages']);
    }

    $localLanguage = [];

    foreach ($userLanguages as $key => $userLanguage) {
        $localLanguage[localeToCountryCode($key)] = $userLanguage;
    }

    // dd(localeToCountryCode(mb_strtoupper(app()->getLocale())));

@endphp



{{-- <x-layouts.notice-card /> --}}

{{-- Button Locale Language --}}
<div class="container mx-auto">
    @if (!empty($localLanguage) and count($localLanguage) > 1)
        <form action="{{ route('appLocaleRoute') }}" method="post" class="mr-15 mx-md-20">
            {{ csrf_field() }}

            <input type="hidden" name="locale">

            @if (!empty($previousUrl))
                <input type="hidden" name="previous_url" value="{{ $previousUrl }}">
            @endif

            <div class="relative inline-block">
                <select id="localeSelect" name="locale" onchange="this.form.submit()"
                    class="appearance-none bg-white border border-gray-300 rounded-md py-2 px-4 inline-flex items-center">
                    @foreach ($localLanguage as $language => $languageName)
                        <option value="{{ $language }}"
                            {{ localeToCountryCode(mb_strtoupper(app()->getLocale())) == $language ? 'selected' : '' }}>
                            {{ $languageName }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    @else
        <div class="mr-15 mx-md-20"></div>
    @endif
</div>


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
            <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
        </a>



        @if (auth()->check())
            <a href="/panel" class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-8 bg-primary.main">
                <span class="font-medium text-sm text-white">{{ trans('header.Dashboard') }}</span>
            </a>
        @else
            <a href="{{ route('login') }}"
                class="flex cursor-pointer hover:opacity-90 rounded-full py-1.5 px-8 bg-primary.main">
                <span class="font-medium text-sm text-white">{{ trans('header.Login') }}</span>
            </a>
        @endif
    </div>
</nav>
