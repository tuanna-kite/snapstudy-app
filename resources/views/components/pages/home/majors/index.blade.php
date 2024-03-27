@php
    $listMajor = [
        [
            'icon' => 'business-foundation',
            'content' => 'Business Foundation',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Logistics & Supply Chain',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'People & Organisation',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Blockchain Enabled Business',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Logistics & Supply Chain',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'People & Organisation',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Blockchain Enabled Business',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
    ];
@endphp


<section>
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($listMajor as $item)
            <li>
                <x-pages.home.majors.card iconName='business-foundation' :major='$item' />
            </li>
        @endforeach
    </ul>
</section>
