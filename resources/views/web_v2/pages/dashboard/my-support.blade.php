@extends('web_v2.layouts.index')
@section('title', 'My Support')

@php
    $input = [
        'label' => trans('dashboard.Subject'),
        'name' => 'title',
        'placeholder' => '',
    ];

    $fmDepartments = [];
    // Format Departments
    foreach ($departments as $department) {
        $fmDepartments[$department->id] = $department->title;
    }

    $fmWebinars = [];
    // Format Departments
    foreach ($webinars as $webinar) {
        $fmWebinars[$webinar->id] = $webinar->title . ' - ' . $webinar->creator->full_name;
    }

    $selects = [
        [
            'label' => trans('dashboard.Type'),
            'id' => 'typeInput',
            'name' => 'type',
            'options' => [
                '' => trans('dashboard.Choose'),
                'course_support' => trans('dashboard.Course support'),
                'platform_support' => trans('dashboard.Platform support'),
            ],
        ],
        [
            'label' => trans('dashboard.Department'),
            'id' => 'departmentInput',
            'name' => 'department_id',
            'options' => $fmDepartments,
        ],
        [
            'label' => trans('dashboard.Syllabus'),
            'id' => 'syllabusInput',
            'name' => 'webinar_id',
            'options' => $fmWebinars,
        ],
    ];

    $textarea = [
        'name' => 'message',
        'label' => trans('dashboard.Message'),
    ];

@endphp

@section('content')
    <x-layouts.dashboard-layout title="New Support">
        <div class="p-6 bg-white rounded-2xl">
            <form class="space-y-4" action="{{ route('support.store') }}" method="POST">
                @csrf
                <x-input.input-label :data="$input" />
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                @foreach ($selects as $select)
                    <x-input.select-label :data="$select" />
                @endforeach

                <x-input.textarea-label :data="$textarea" />
                <div class="flex flex-col md:flex-row justify-between items-end">
                    <x-input.file-label />
                    <x-button.button text="{{ trans('dashboard.Send Message') }}" type='submit' class="mb-2" />
                </div>
            </form>
        </div>
    </x-layouts.dashboard-layout>
@endsection
@push('scripts_bottom')
    <script>
        const syllabusInput = document.getElementById('syllabusInput')
        const departmentInput = document.getElementById('departmentInput')

        syllabusInput.style.display = 'none'
        departmentInput.style.display = 'none'
        document.getElementById('type').addEventListener('change', function() {
            const typeValue = this.value; // Get the selected value

            if (typeValue === 'course_support') {
                syllabusInput.style.display = 'block';
                departmentInput.style.display = 'none';
            } else if (typeValue === 'platform_support') {
                syllabusInput.style.display = 'none'
                departmentInput.style.display = 'block'
            } else {
                syllabusInput.style.display = 'none'
                departmentInput.style.display = 'none'
            }
        });
    </script>
@endpush
