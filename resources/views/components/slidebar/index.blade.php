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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButtons = document.querySelectorAll('.menubtn');
        toggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var targetId = button.getAttribute('data-target');
                var childDiv = button.querySelector('div')
                var targetDiv = document.getElementById(targetId);

                if (targetDiv.classList.contains('hidden')) {
                    console.log('in', targetId)
                    childDiv.classList.add('bg-primary.light')
                    targetDiv.classList.remove('hidden');
                } else {
                    console.log('out', targetId)
                    targetDiv.classList.add('hidden');
                    childDiv.classList.remove('bg-primary.light')

                }
            });
        });
    });
</script>
