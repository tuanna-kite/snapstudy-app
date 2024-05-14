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
    // [
    //   "US" => "English"
    //   "VN" => "Vietnamese"
    // ]
@endphp

{{-- Button Locale Language --}}
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="inline-flex items-center justify-between px-2 py-2 text-sm
         text-gray-700 bg-white md:border border-gray-300 rounded-lg hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
        <span class="flex gap-2 items-center">
            {{-- <x-component.icon
                name="{{ localeToCountryCode(mb_strtoupper(app()->getLocale())) == 'VN' ? 'viet-nam' : 'english' }}" /> --}}

            <span class="hidden sm:block">
                {{ $localLanguage[localeToCountryCode(mb_strtoupper(app()->getLocale()))] }}
            </span>
        </span>
        <x-component.material-icon name="expand_more" x-show="open === false" />
        <x-component.material-icon name="expand_less" x-show="open === true" />
    </button>
    <ul x-show.transition="open" @click.away="open = false"
        class="absolute z-10 bg-white mt-6 rounded-xl overflow-hidden shadow-lg w-40 flex flex-col">
        @foreach ($localLanguage as $language => $languageName)
            <li class="flex-1 hover:bg-gray-200">
                <form action="{{ route('appLocaleRoute') }}" method="POST" class="mb-0">
                    @csrf
                    <input type="hidden" name="locale" value="{{ $language }}">
                    <button type="submit" class="px-4 py-4 text-sm leading-5 text-gray-500 focus:outline-none">
                        <span class="flex gap-2 items-center">
                            {{-- <x-component.icon name="{{ $language == 'VN' ? 'viet-nam' : 'english' }}" /> --}}
                            {{ $languageName }}
                        </span>
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
