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


<div>
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($listMajor as $item)
            <li>
                <x-majors.card iconName='business-foundation' :major='$item' />
            </li>
        @endforeach
    </ul>
</div>
