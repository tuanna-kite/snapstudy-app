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
