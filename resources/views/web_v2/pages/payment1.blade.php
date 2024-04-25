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
                        <div class="p-6 rounded-3xl bg-white shadow-lg">
                            <h2 class="font-semibold text-base text-text.light.primary mb-6 ">{{ trans('payment.Payment method') }}</h2>
                            <div>
                                <form class="space-y-10" action='{{ route('payment.request') }}' method="post">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
                                        <label class="card relative bg-white rounded-2xl border-2 p-2 hover:shadow-lg">
                                            <div class="text-end">
                                                <input class="radio checked:accent-secondary.main" name="gateway"
                                                       value="paypal" type="radio" checked>
                                            </div>
                                            <div class="flex flex-col items-center gap-3 pb-6">
                                                <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                                     class="w-full"/>
                                                <div class="text-center">
                                                    <p class="font-semibold text-base">
                                                        Pay with Paypal
                                                    </p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <button type="submit" class="rounded-lg px-6 py-1.5 bg-primary.main">
                                        <span class="font-medium text-sm text-white">
                                            {{ trans('payment.Start Payment') }}
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3 min-h-[350px] lg:self-stretch">
                        <x-pages.payment.card-course :webinar="$webinar"/>
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
