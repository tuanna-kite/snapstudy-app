@extends('web_v2.layouts.index')

@section('title', 'Payment Page')

@php
    // checkout || charge
    $payment_type = 'charge';
@endphp

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-16 space-y-8">
            <div class="space-y-1">
                <h1 class="font-bold text-3xl text-primary.main">Check out</h1>
                <p class="text-base text-text.light.secondary">
                    a checkout is a counter where you pay for things you are buying
                </p>
            </div>
            @if ($payment_type === 'checkout')
                <div class="flex flex-col-reverse items-start md:flex-row gap-6">
                    <div class="w-full md:w-2/3 min-h-[350px]">
                        <x-pages.payment.method />
                    </div>
                    <div class="w-full md:w-1/3 min-h-[350px] lg:self-stretch">
                        <x-pages.payment.card-course />
                    </div>
                </div>
            @else
                <div class="flex flex-col items-start gap-6">
                    <div class="w-full rounded-3xl space-x-8 p-6 bg-white font-bold text-lg">
                        <span class=" text-text.light.primary">Top up:</span>
                        <span class=" text-primary.main">
                            500,000 VND
                        </span>
                    </div>
                    <div class="w-full">
                        <x-pages.payment.method />
                    </div>
                </div>
            @endif
        </div>
    </x-layouts.home-layout>
@endsection
