@php
    $listMajor = [
        'business-foundation' => 'Business Foundation',
        'business-foundation1' => 'Digital Marketing',
        'business-foundation2' => 'Professional Communication',
        'business-foundation3' => 'Economics - Finance',
        'business-foundation4' => 'Logistics & Supply Chain',
        'business-foundation5' => 'Blockchain Enabled Business',
        'business-foundation6' => 'Blockchain Enabled Business',
        'business-foundation7' => 'Blockchain Enabled Business',
        'business-foundation8' => 'Blockchain Enabled Business',
        'business-foundation9' => 'Blockchain Enabled Business',
        'business-foundation10' => 'Blockchain Enabled Business',
    ];
@endphp


<div>
    <ul class="flex flex-wrap justify-center gap-4">
        @foreach ($listMajor as $key => $item)
            <li>
                <x-majors.card iconName='business-foundation' :content='$item' />
            </li>
        @endforeach
    </ul>
</div>
