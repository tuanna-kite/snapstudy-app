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
        [
            'icon' => 'logout',
            'title' => 'Log out',
            'href' => '#',
        ],
    ];
@endphp

<nav class="p-6 inline-block rounded-3xl bg-white">
    <ul class="flex flex-col gap-3">
        @foreach ($listMenu as $menu)
            <li>
                <x-dialog-menu.card :cardProps="$menu" />
            </li>
            @if ($loop->index === 4)
                <hr class="border-t-1 border-gray-300">
            @endif
        @endforeach
    </ul>
</nav>
