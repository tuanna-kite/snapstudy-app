
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
