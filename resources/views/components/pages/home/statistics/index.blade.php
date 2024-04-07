@php
    $listStatistic = [
        [
            'number' => '1200+',
            'title' => trans('home.Assessment & Questions'),
            'content' => trans('home.We have access to all assessment'),
            'color' => '#1684EA',
        ],
        [
            'number' => '1500+',
            'title' => trans('home.Outlines'),
            'content' => trans('home.Unlock your assignments'),
            'color' => '#6544F9',
        ],
        [
            'number' => '50+',
            'title' => trans('home.Experts'),
            'content' => trans('home.All the Outlines'),
            'color' => '#54CE91',
        ],
        [
            'number' => '70%',
            'title' => trans('home.Time Saved'),
            'content' => trans('home.Save your time'),
            'color' => '#D04091',
        ],
    ];
@endphp

<section>
    <ul class="flex gap-8 flex-col md:flex-row">
        @foreach ($listStatistic as $item)
            <li class="flex-1">
                <x-pages.home.statistics.card :data="$item" />
            </li>
        @endforeach
    </ul>
</section>
