@props(['formId'])

@php
    $subjectOptions = [
        'Digital Marketing',
        'Professional Communication',
        'Logistics and Supply Chain',
        'Economics - Finance',
        'Economics',
        'Fashion Enterprise',
        'Management & Change',
        'People & Organisation',
        'Business-Foundation',
        'IT',
        'Global Business',
    ];
    $schoolOptions = ['RMIT', 'VinUniversity', 'MIT', 'Yale', 'Harvard'];
@endphp

<form id={{ $formId }} action="/classes" method="GET">
    {{ $slot }}
    <!-- List of subject checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">Subject</h3>
    @foreach ($subjectOptions as $subject)
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" name="subjectOptions[]" value="{{ $subject }}"
                    @if (in_array($subject, request()->get('subjectOptions', []))) checked="checked" @endif>
                <span>{{ $subject }}</span>
            </label>
        </div>
    @endforeach
    <!-- List of school checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">School</h3>
    @foreach ($schoolOptions as $school)
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" name="schoolOptions[]" value="{{ $school }}"
                    @if (in_array($school, request()->get('schoolOptions', []))) checked="checked" @endif>
                <span>{{ $school }}</span>
            </label>
        </div>
    @endforeach
    <div class="mt-6">
        <button type="submit" class="py-1.5 px-10 rounded-xl bg-primary.main text-white">Apply</button>
    </div>
</form>


