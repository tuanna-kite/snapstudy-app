@php
    $listMajor = [
        [
            'link' => '/classes?schoolOptions%5B%5D=Business-Foundation',
            'icon' => 'major-icon0',
            'content' => 'Business Foundation',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon10',
            'content' => 'Digital Marketing',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Professional+Communication',
            'icon' => 'major-icon1',
            'content' => 'Professional Communication',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Economics+-+Finance',
            'icon' => 'major-icon2',
            'content' => 'Economics Finance',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Logistics+and+Supply+Chain',
            'icon' => 'major-icon3',
            'content' => 'Logistics Supply Chain',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=People+%26+Organisation',
            'icon' => 'major-icon4',
            'content' => 'People & Organisation',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Global-Business',
            'icon' => 'major-icon5',
            'content' => 'Global - Business',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Management+%26+Change',
            'icon' => 'major-icon6',
            'content' => 'Management & Change',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=IT',
            'icon' => 'major-icon7',
            'content' => 'Blockchain Enabled Business',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon8',
            'content' => 'Digital Film & Video',
        ],
        [
            'link' => '/classes?schoolOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon9',
            'content' => 'Fashion Enterprise',
        ],
    ];
@endphp


<section>
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($listMajor as $item)
            <li>
                <x-pages.home.majors.card :major='$item' />
            </li>
        @endforeach
    </ul>
</section>
