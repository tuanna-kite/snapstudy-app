@php
    $listMajor = [
        [
            'link' => '/classes?subjectOptions%5B%5D=Business+Foundation',
            'icon' => 'major-icon0',
            'slug' => 'Business-Foundation',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon10',
            'slug' => 'Digital Marketing',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Professional+Communication',
            'icon' => 'major-icon1',
            'slug' => 'Professional Communication',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Economics+Finance',
            'icon' => 'major-icon2',
            'slug' => 'Economics Finance',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Logistics+and+Supply+Chain',
            'icon' => 'major-icon3',
            'slug' => 'Logistics Supply Chain',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=People+%26+Organisation',
            'icon' => 'major-icon4',
            'slug' => 'People & Organisation',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Global+Business',
            'icon' => 'major-icon5',
            'slug' => 'Global-Business',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Management+%26+Change',
            'icon' => 'major-icon6',
            'slug' => 'Management & Change',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=IT',
            'icon' => 'major-icon7',
            'slug' => 'Blockchain Enabled Business',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Digital+Marketing',
            'icon' => 'major-icon8',
            'slug' => 'Digital Film & Video',
        ],
        [
            'link' => '/classes?subjectOptions%5B%5D=Fashion+Enterprise',
            'icon' => 'major-icon9',
            'slug' => 'Fashion Enterprise',
        ],
    ];
@endphp

@push('styles_top')
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar for webkit browsers */
        }

        .hide-scrollbar {
            scrollbar-width: none;
            /* Hide scrollbar for Firefox */
        }
    </style>
@endpush


<section class="overflow-x-hidden">
    <ul class="flex overflow-auto justify-start sm:flex-wrap sm:justify-center gap-4 hide-scrollbar">
        @foreach ($listMajor as $majorItem)
            <li>
                <x-pages.home.majors.card :major='$majorItem' />
            </li>
        @endforeach
    </ul>
</section>
