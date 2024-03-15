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
    ];
@endphp


<div>
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($listMajor as $item)
            <li>
                <x-majors.card iconName='business-foundation' :content='$item' />
            </li>
        @endforeach
    </ul>
</div>
