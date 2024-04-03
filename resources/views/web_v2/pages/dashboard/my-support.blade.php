@extends('web_v2.layouts.index')
@section('title', 'My Support')

@php
    $input = [
        'name' => 'title',
        'label' => 'Subject',
    ];

    $typeSelect = [
        'name' => 'type',
        'label' => 'Type',
        'options' => [
            'course_support' => 'Course support',
            'platform_support' => 'Platform support',
        ],
    ];

    $textarea = ['name' => 'message', 'label' => 'Message'];
@endphp

@section('content')
    <x-layouts.dashboard-layout title="New Support">
        <div class="px-6 py-8 bg-white rounded-2xl space-y-4">
            <form action="{{ route('support.store') }}" method="POST">
                @csrf
                <x-input.input-label :data="$input" />
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <x-input.select-label :data="$typeSelect" />

                <div class="space-y-2 relative" id="departmentInput">
                    <label for="department" class="text-sm font-semibold">Department</label>
                    <div class="">
                        <select id='department' name='department_id' class="w-full border border-grey-300 rounded-xl p-[18px]">
                            @foreach ($departments as $value => $item)
                                <option value={{ $item->id }}>{{ $item->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-2 relative" id="courseInput">
                    <label for="syllabus" class="text-sm font-semibold">Syllabus</label>
                    <div class="">
                        <select id='syllabus' name='webinar_id' class="w-full border border-grey-300 rounded-xl p-[18px]">
                            @foreach ($webinars as $value => $webinar)
                                <option value="{{ $webinar->id }}">{{ $webinar->title }} - {{ $webinar->creator->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-input.textarea-label :data="$textarea" />
                <div class="flex flex-col md:flex-row justify-between items-end">
                    <x-input.file-label />
                    <x-button.button text="Send Message" type='submit' class="mb-2" />
                </div>
            </form>
        </div>
    </x-layouts.dashboard-layout>
@endsection

<script src="/assets/default/vendors/select2/select2.min.js"></script>
<script src="/assets/default/js/panel/conversations.min.js"></script>
<script>
    $('body').on('change', '#supportType', function (e) {
        const value = $(this).val();

        $('#courseInput,#departmentInput').addClass('d-none');

        if (value === 'course_support') {
            $('#courseInput').removeClass('d-none');
            panelSearchWebinarSelect2();
        } else if (value === 'platform_support') {
            $('#departmentInput').removeClass('d-none');
        }
    })
</script>
