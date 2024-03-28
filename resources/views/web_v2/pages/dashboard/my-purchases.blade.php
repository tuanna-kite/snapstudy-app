@extends('web_v2.layouts.index')
@section('title', 'My Purchases')

@section('content')
    <x-layouts.dashboard-layout title="My Purchases">
        <div class="space-y-3">
            <x-pages.my-purchases.info :purchasedCount="$purchasedCount"/>
            <div class="bg-white rounded-3xl">
                <div class="p-6">
                    <x-input.input-group />
                </div>
                <div>
                    @if(!empty($sales) and !$sales->isEmpty())
                        @foreach($sales as $sale)

                                <x-pages.my-purchases.card :sale="$sale"/>
            {{--                    <x-pages.my-purchases.card />--}}
            {{--                    <x-pages.my-purchases.card />--}}

                        @endforeach
                    @endif
                </div>
                <x-component.pagination />
            </div>
        </div>
    </x-layouts.dashboard-layout>
@endsection
