@php
    $listMenu = [
        [
            'icon' => 'menu',
            'title' => 'Dashboard',
            'href' => '#',
        ],
        [
            'icon' => 'document-text',
            'title' => 'My Syllabus',
            'href' => '#',
        ],
        [
            'icon' => 'task',
            'title' => 'My Purchased',
            'href' => '#',
        ],
        [
            'icon' => 'wallet-minus',
            'title' => 'Financial',
            'href' => '#',
        ],
        [
            'icon' => 'device-message',
            'title' => 'Support',
            'href' => '#',
        ],
        [
            'icon' => 'setting-2',
            'title' => 'Setting Account',
            'href' => '#',
        ],
    ];
@endphp

<nav class="p-8 h-screen w-64 rounded-2xl bg-white">
    <img src="img/logo/logo.png" alt="logo-snaps">
    <ul class="flex flex-col gap-3 mt-10">
        @foreach ($listMenu as $menu)
            <li>
                <x-slidebar.card :cardProps="$menu" />
            </li>
            @if ($loop->index === 4)
                <hr class="border-t-1 border-gray-300">
            @endif
        @endforeach
    </ul>
</nav>
