@php
    $listMenu = [
        [
            'icon' => 'menu',
            'title' => 'Dashboard',
            'href' => route('dashboard'),
            'tab' => null,
        ],
        [
            'icon' => 'document-text',
            'title' => 'My Syllabus',
            'href' => '1',
            'tab' => [
                'Home' => route('my.syllabus'), // href here
                'My Learning' => route('my.learning'), // href here
            ],
        ],
        [
            'icon' => 'task',
            'title' => 'My Purchased',
            'href' => route('purchases'),
            'tab' => null,
        ],
        [
            'icon' => 'wallet-minus',
            'title' => 'Financial',
            'href' => route('financial.summary'),
            'tab' => null,
        ],
        [
            'icon' => 'device-message',
            'title' => 'Support',
            'href' => '2',
            'tab' => [
                'New' => route('support.create'), // href here
                'Document' => route('document'), // href here
            ],
        ],
        [
            'icon' => 'setting-2',
            'title' => 'Setting',
            'href' => route('setting'),
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

<nav class="p-2 md:p-8 w-full h-full rounded-2xl flex flex-col items-center sm:items-start bg-white">
    {{ $slot }}
    <ul class="flex flex-col gap-3 mt-10 w-full overflow-y-auto" x-data="{ openTab: '{{ $currentUrl }}' }">
        @foreach ($listMenu as $menu)
            <li class="w-full">
                <x-slidebar.card :menuItem="$menu" :currentUrl="$currentUrl" />
            </li>
            @if ($loop->index === 4)
                <hr class="border-t-1 border-gray-300">
            @endif
        @endforeach
    </ul>
</nav>
