@php
    $listMajor = [
        [
            'link' => '/classes?schoolOptions%5B%5D=Business-Foundation',
            'icon' => 'business-foundation',
            'content' => 'Business Foundation',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'business-foundation',
            'content' => 'Digital Marketing',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Professional+Communication',
            'icon' => 'business-foundation',
            'content' => 'Professional Communication',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Economics+-+Finance',
            'icon' => 'business-foundation',
            'content' => 'Economics Finance',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Logistics+and+Supply+Chain',
            'icon' => 'business-foundation',
            'content' => 'Logistics Supply Chain',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=People+%26+Organisation',
            'icon' => 'business-foundation',
            'content' => 'People & Organisation',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Global-Business',
            'icon' => 'business-foundation',
            'content' => 'Global - Business',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Management+%26+Change',
            'icon' => 'business-foundation',
            'content' => 'Management & Change',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=IT',
            'icon' => 'business-foundation',
            'content' => 'Blockchain Enabled Business',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'business-foundation',
            'content' => 'Digital Film & Video',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'business-foundation',
            'content' => 'Fashion Enterprise',
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
