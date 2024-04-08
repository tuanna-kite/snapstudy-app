@props(['submitUrl' => '/search'])

@php
    // TODO: Get option Major and School from DB
    $selectGroup = [
        [
            'name' => 'major',
            'label' => trans('dashboard.Major'),
            'options' => [
                'all' => 'All',
                'math' => 'Math',
                'business' => 'Business Fundamental',
            ],
        ],
        [
            'name' => 'school',
            'label' => trans('dashboard.School'),
            'options' => [
                'all' => 'All',
                'rmit' => 'RMIT',
            ],
        ],
    ];
@endphp

<form action={{ $submitUrl }} method="">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        @foreach ($selectGroup as $select)
            <div class="w-full md:flex-1 h-16">
                <x-input.select-label :isOverlapping=true :data="$select" />
            </div>
        @endforeach
        <div class="w-full md:flex-1 h-16">
            <x-search.search class="border border-grey-300 top-2" />
        </div>
    </div>
</form>
