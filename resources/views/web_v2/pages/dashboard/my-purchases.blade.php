@extends('web_v2.layouts.index')
@section('title', 'My Purchases')

@section('content')
    <x-layouts.dashboard-layout title="My Purchases">
        <div class="space-y-3">
            <x-pages.my-purchases.info :purchasedCount="$purchasedCount" />
            <div class="bg-white rounded-3xl">
                <div class="p-6">
                    {{-- TODO: Add submitHref here --}}
                    <x-input.group-filter />
                </div>
                <div>
                    @if (!empty($sales) and !$sales->isEmpty())
                        @foreach ($sales as $sale)
                            <x-pages.my-purchases.card :sale="$sale" />
                        @endforeach
                    @endif
                </div>
                {{ $sales->appends(request()->input())->links('components.pagination.dashboard') }}
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
