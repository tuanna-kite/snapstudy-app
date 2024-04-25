@extends('web_v2.layouts.index')
@section('title', 'Course Page')
@section('content')

    <x-layouts.home-layout>
        <div class="container mx-auto py-24">
            {{-- Search Bar --}}
            <div class="flex items-center gap-2 mb-12 md:mb-24">
                <div class="flex-1">
                    <x-search.search-doc/>
                </div>
                <div class="block lg:hidden">
                    <x-pages.course-list.filter-button :majors="$majors" :school="$school"/>
                </div>
            </div>
            <div class="flex gap-6">
                <div class="w-1/4 hidden lg:block">
                    <x-pages.course-list.form formId="filterForm1" :majors="$majors" :school="$school">
                        <div class="flex items-center justify-between">
                            <h2 class="font-bold text-2xl text-primary.main">
                                {{ trans('course.Filter By') }}
                            </h2>
                            <div>
                                <button type="button" id='clearOptionBtn' onclick="clearQueryParams()"
                                        class="flex items-center gap-1 rounded-full border py-0.5 px-1 border-border-disabled text-text.light.disabled">
                                    <span class="font-medium text-xs">
                                        {{ trans('course.Clear All') }}
                                    </span>
                                    <x-component.material-icon name="close" style="font-size:18px !important"/>
                                </button>
                            </div>
                        </div>
                    </x-pages.course-list.form>
                </div>
                <div class="w-full lg:w-3/4 grid-cols-1 grid gap-4 sm:grid-cols-3 xl:grid-cols-4">

                    @foreach ($subjectAll as $subject)
                        <div class="{{ count($subjectAll) <= 4 ? 'max-h-72 flex' : 'flex' }}">
                            <x-documents.document-card :subject="$subject" :icon="$school->icon" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-32">
                {{ $subjectAll->appends(['school' => request()->query('school')])->links('components.pagination.index') }}
            </div>

        </div>
    </x-layouts.home-layout>
@endsection
