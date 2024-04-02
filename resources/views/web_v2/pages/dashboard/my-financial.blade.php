@extends('web_v2.layouts.index')
@section('title', 'My Financial')

@section('content')
    <x-layouts.dashboard-layout title="My Financial">
        <div class="rounded-t-3xl pt-6 bg-white">
            <table class="table-auto min-w-full overflow-x-auto">
                <!-- Table header -->
                <thead class="bg-light-neutral">
                    <x-pages.my-financial.financial-head />
                </thead>
                <tbody class="bg-white py-4 px-6">
                    @foreach($accountings as $accounting)
                    <!-- Table rows -->
                        <x-pages.my-financial.financial-row :accounting="$accounting"/>
                    @endforeach
                    <!-- More table rows... -->
                </tbody>
            </table>
            <x-component.pagination />
        </div>

        <!-- Pagination -->

    </x-layouts.dashboard-layout>

@endsection
