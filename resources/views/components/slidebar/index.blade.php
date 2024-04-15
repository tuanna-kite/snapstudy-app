@props(['padding' => 'p-4'])

@php
    $listMenu = [
        [
            'icon' => 'menu',
            'title' => trans('dashboard.Dashboard'),
            'href' => route('dashboard'),
            'tab' => null,
        ],
        [
            'icon' => 'document-text',
            'title' => trans('dashboard.My Syllabus'),
            'href' => '1',
            'tab' => [
                trans('dashboard.Home') => route('my.syllabus'), // href here
                trans('dashboard.My Learning') => route('my.learning'), // href here
            ],
        ],
        [
            'icon' => 'task',
            'title' => trans('dashboard.My Purchased'),
            'href' => route('purchases'),
            'tab' => null,
        ],
        [
            'icon' => 'wallet-minus',
            'title' => trans('dashboard.Financial'),
            'href' => route('financial.summary'),
            'tab' => null,
        ],
        [
            'icon' => 'device-message',
            'title' => trans('dashboard.Support'),
            'href' => '2',
            'tab' => [
                trans('dashboard.New') => route('support.create'), // href here
                trans('dashboard.Document') => route('support.tickets'), // href here
            ],
        ],
        [
            'icon' => 'setting-2',
            'title' => trans('dashboard.Setting'),
            'href' => route('setting'),
            'tab' => null,
        ],
        [
            'icon' => 'logout',
            'title' => trans('dashboard.Log out'),
            'href' => route('logout'),
            'tab' => null,
        ],
    ];

    $currentUrl = url()->current();
    if ($currentUrl === route('my.syllabus') || $currentUrl === route('my.learning')) {
        $currentUrl = '1';
    }
    if ($currentUrl === route('support.create') || $currentUrl === route('document')) {
        $currentUrl = '2';
    }

@endphp

<nav class="p-2 md:p-6 space-y-4 w-full h-full rounded-2xl flex flex-col items-center sm:items-start bg-white">
    {{ $slot }}
    <ul class="flex flex-col gap-4 w-full overflow-y-auto" x-data="{ openTab: '{{ $currentUrl }}' }">
        @foreach ($listMenu as $menu)
            <li class="w-full">
                <x-slidebar.card :padding="$padding" :menuItem="$menu" :currentUrl="$currentUrl" />
            </li>
            @if ($loop->index === 4)
                <hr class="border-t-1 border-gray-300">
            @endif
        @endforeach
    </ul>
</nav>
