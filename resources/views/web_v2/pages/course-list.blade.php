@extends('web_v2.layouts.index')

@php
    // Get Categories
    $categoriesAll = array_map(fn($category)=> $category['slug'],$categoriesAll);
    $categoriesAll = array_diff($categoriesAll, ['RMIT']);
@endphp

@section('title', 'Course Page')

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-24">
            {{-- Search Bar --}}
            <div class="flex items-center gap-2 mb-12 md:mb-24">
                <div class="flex-1">
                    <x-search.search-doc />
                </div>
                <div class="block md:hidden">
                    <x-pages.course-list.filter-button :categories="$categoriesAll" />
                </div>
            </div>
            <div class="flex gap-6">
                {{-- Filter Sidebar --}}
                <div class="w-1/4 hidden md:block">
                    <x-pages.course-list.form formId="filterForm1" :categories="$categoriesAll">
                        <div class="flex items-center justify-between">
                            <h2 class="font-bold text-2xl text-primary.main">
                                Filter By
                            </h2>
                            <div>
                                <button type="button" id='clearOptionBtn' onclick="clearQueryParams()"
                                    class="flex items-center gap-1 rounded-full border py-0.5 px-1 border-border-disabled text-text.light.disabled">
                                    <span class="font-medium text-xs">Clear All</span>
                                    <x-component.material-icon name="close" style="font-size:18px !important" />
                                </button>
                            </div>
                        </div>
                    </x-pages.course-list.form>
                </div>
                {{-- List Courses --}}
                <div class="w-full md:w-3/4 grid gap-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
                    @foreach ($webinars as $trending)
                        <div class="{{ count($webinars) <= 4 ? 'max-h-72 flex' : 'flex' }}">
                            <x-documents.document-card :trending="$trending" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mt-32">
                {{ $webinars->appends(request()->input())->links('components.pagination.index') }}
            </div>

        </div>
    </x-layouts.home-layout>
@endsection
