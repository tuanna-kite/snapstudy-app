{{--@php--}}
{{--    $listSchools = [--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'nuce',--}}
{{--            'title' => 'ĐẠI HỌC XÂY DỰNG',--}}
{{--            'short' => 'NUCE',--}}
{{--        ],--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'neu',--}}
{{--            'title' => 'ĐẠI HỌC KINH TẾ QUỐC DÂN',--}}
{{--            'short' => 'NEU',--}}
{{--        ],--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'rmit',--}}
{{--            'title' => 'RMIT UNIVERSITY',--}}
{{--            'short' => 'RMIT',--}}
{{--        ],--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'ueh',--}}
{{--            'title' => 'ĐẠI HỌC KINH TẾ THÀNH PHỐ HCM',--}}
{{--            'short' => 'UEH',--}}
{{--        ],--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'uel',--}}
{{--            'title' => 'ĐẠI HỌC KINH TẾ - LUẬT THÀNH PHỐ HCM',--}}
{{--            'short' => 'UEL',--}}
{{--        ],--}}
{{--        [--}}
{{--            'link' => '#',--}}
{{--            'icon' => 'ptit',--}}
{{--            'title' => 'HỌC VIỆN CÔNG NGHỆ BƯU CHÍNH VIỄN THÔNG',--}}
{{--            'short' => 'PTIT',--}}
{{--        ],--}}
{{--    ];--}}
{{--@endphp--}}
<ul class="grid md:grid-cols-3 grid-cols-2 gap-4">
    @foreach ($listSchools as $school)
        <li>
            <x-pages.home.schools.card :school='$school' />
        </li>
    @endforeach
</ul>
