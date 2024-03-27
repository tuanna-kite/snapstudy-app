@php
    $listStatistic = [
        [
            'number' => '1200+',
            'title' => 'Assessment & Questions',
            'content' => 'We have access to all assessment details and test questions of your chosen courses',
            'color' => '#1684EA',
        ],
        [
            'number' => '1500+',
            'title' => 'Outlines',
            'content' => 'Unlock your assignments with the most detailed and comprehensive instructions',
            'color' => '#6544F9',
        ],
        [
            'number' => '50+',
            'title' => 'Experts',
            'content' => 'All the Outlines are proofreaded by our experts to ensure you a high score',
            'color' => '#54CE91',
        ],
        [
            'number' => '70%',
            'title' => 'Time Saved',
            'content' => 'Save your time to 70% and Boost your Efficiency to 180%',
            'color' => '#D04091',
        ],
    ];
@endphp

<section>
    <ul class="flex gap-8 flex-col md:flex-row">
        @foreach ($listStatistic as $item)
        <li>
            <x-pages.home.statistics.card :data="$item" />
        </li>
        @endforeach
    </ul>
</section>
