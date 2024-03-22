@php
    $listMenu = [
        [
            'icon' => 'menu',
            'title' => 'Dashboard',
            'href' => '1',
        ],
        [
            'icon' => 'document-text',
            'title' => 'My Syllabus',
            'href' => '2',
        ],
        [
            'icon' => 'task',
            'title' => 'My Purchased',
            'href' => '3',
        ],
        [
            'icon' => 'wallet-minus',
            'title' => 'Financial',
            'href' => '4',
        ],
        [
            'icon' => 'device-message',
            'title' => 'Support',
            'href' => '5',
        ],
        [
            'icon' => 'setting-2',
            'title' => 'Setting Account',
            'href' => '6',
        ],
    ];
@endphp

<nav class="p-2 md:p-8 w-full h-full rounded-2xl flex flex-col items-center sm:items-start bg-white">
    {{ $slot }}
    <ul class="flex flex-col gap-3 mt-10 w-full" x-data="{ openTab: null }">
        @foreach ($listMenu as $menu)
            <li class="w-full">
                <x-slidebar.card :menuItem="$menu" />
            </li>
            @if ($loop->index === 4)
                <hr class="border-t-1 border-gray-300">
            @endif
        @endforeach
    </ul>
</nav>
