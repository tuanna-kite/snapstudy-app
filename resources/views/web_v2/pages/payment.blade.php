@extends('web_v2.layouts.index')

@section('title', 'Payment Page')

@php
if(empty($payment_type)){
    $payment_type = 'checkout';
}
@endphp

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-16 space-y-8">
            <div class="space-y-1">
                <h1 class="font-bold text-3xl text-primary.main">{{ trans('payment.Check out') }}</h1>
                <p class="text-base text-text.light.secondary">
                    {{ trans('payment.A checkout is a counter where you pay for things you are buying') }}
                </p>
            </div>
            @if ($payment_type == 'checkout')
                <div class="flex flex-col-reverse items-start md:flex-row gap-6">
                    <div class="w-full md:w-2/3 min-h-[350px]">
                        <x-pages.payment.method :order="$order" :payment_type="$payment_type"/>
                    </div>
                    <div class="w-full md:w-1/3 min-h-[350px] lg:self-stretch">
                        <x-pages.payment.card-course :webinar="$webinar" />
                    </div>
                </div>
            @elseif ($payment_type == 'personalization')
                <div class="flex flex-col-reverse items-start md:flex-row gap-6">
                    <div class="w-full md:w-2/3 min-h-[350px]">
                        <x-pages.payment.method :order="$order" :payment_type="$payment_type" :amount="$amount"/>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-start gap-6">
                    <div class="w-full rounded-3xl space-x-8 p-6 bg-white font-bold text-lg">
                        <span class=" text-text.light.primary">{{ trans('payment.Top up:') }}</span>
                        <span class=" text-primary.main">
                            {{ $amount }}
                        </span>
                    </div>
                    <div class="w-full">
                        <x-pages.payment.method :amount="$amount" :payment_type="$payment_type"/>
                    </div>
                </div>
            @endif
        </div>
    </x-layouts.home-layout>
@endsection
