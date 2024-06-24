@php
    $testimonials = [
        [
            'avatar' => asset('img/logo/avatar2.png'),
            'name' => 'Phu Son',
            'major' => trans('home.Economics & Finance at RMIT'),
            'comment' => trans('home.The most fascinating thing about SNAPS'),
        ],
        [
            'avatar' => asset('img/logo/avatar.png'),
            'name' => 'Mai Phuong',
            'major' => trans('home.Economics & Finance at RMIT'),
            'comment' => trans('home.The most fascinating thing about SNAPS'),
        ],
    ];
@endphp


<section class="flex flex-col gap-6 md:flex-row">
    @foreach ($testimonials as $item)
        <x-pages.home.testimonials.card :item="$item" />
    @endforeach
</section>
