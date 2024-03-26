@extends('layouts.index')

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
                    <x-pages.assignment-list.filter.filter-button />
                </div>
            </div>
            <div class="flex gap-6">
                <div class="w-1/4 hidden md:block">
                    <x-pages.assignment-list.filter.form>
                        <div class="flex items-center justify-between">
                            <h2 class="font-bold text-2xl text-primary.main">
                                Filter By
                            </h2>
                            <div>
                                <button
                                    class="flex items-center gap-1 rounded-full border py-0.5 px-1 border-border-disabled text-text.light.disabled"
                                    @click="clearAll()">
                                    <span class="font-medium text-xs">Clear All</span>
                                    <x-component.material-icon name="close" style="font-size:18px !important" />
                                </button>
                            </div>
                        </div>
                    </x-pages.assignment-list.filter.form>
                </div>
                <div class="w-full md:w-3/4 grid gap-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
                    <div>
                        <x-documents.document-card />
                    </div>
                    <div>
                        <x-documents.document-card />
                    </div>
                    <div>
                        <x-documents.document-card />
                    </div>
                    <div>
                        <x-documents.document-card />
                    </div>
                    <div>
                        <x-documents.document-card />
                    </div>
                </div>
            </div>
            <div class="mt-32">
                <x-pages.assignment-list.pagination />
            </div>

        </div>
    </x-layouts.home-layout>
@endsection
