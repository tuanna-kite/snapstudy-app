@extends('web_v2.layouts.index')

@section('title', 'Information')

@section('content')
    <x-layouts.home-layout>
        <div class="container mx-auto py-16 flex">
            <div class="hidden lg:w-1/4 lg:block space-y-6">
                <h1 class="font-bold text-2xl text-primary.main uppercase">
                    Thông tin
                </h1>
                <ul class="space-y-3">
                    <li class="{{ $slug == 'guidelines' ? 'font-semibold' : '' }} text-base text-text.light.primary">
                        <a href="{{ route('information', ['slug' => 'guidelines']) }}">Hướng dẫn mua khóa học ôn tập</a>
                    </li>
                    <li class="{{ $slug == 'payment-policy' ? 'font-semibold' : '' }} text-base text-text.light.primary">
                        <a href="{{ route('information', ['slug' => 'payment-policy']) }}">Chính sách thanh toán</a>
                    </li>
                    <li class="{{ $slug == 'privacy-policy' ? 'font-semibold' : '' }} text-base text-text.light.primary">
                        <a href="{{ route('information', ['slug' => 'privacy-policy']) }}">Chính sách bảo mật thông tin khách
                            hàng</a>
                    </li>
                    <li class="{{ $slug == 'refund-policy' ? 'font-semibold' : '' }} text-base text-text.light.primary">
                        <a href="{{ route('information', ['slug' => 'refund-policy']) }}">Chính sách đổi trả và hoàn
                            tiền</a>
                    </li>
                    <li class="{{ $slug == 'complaint-process' ? 'font-semibold' : '' }} text-base text-text.light.primary">
                        <a href="{{ route('information', ['slug' => 'complaint-process']) }}">Quy trình tiếp nhận và xử lý
                            khiếu nại</a>
                    </li>
                </ul>
            </div>
            <div class="w-full lg:w-3/4 rounded-3xl bg-white p-6">
                @if ($slug == 'guidelines')
                    <x-pages.information.guideline />
                @elseif ($slug == 'payment-policy')
                    <x-pages.information.payment-policy />
                @elseif ($slug == 'privacy-policy')
                    <x-pages.information.privacy-policy />
                @elseif ($slug == 'refund-policy')
                    <x-pages.information.refund-policy />
                @elseif ($slug == 'complaint-process')
                    <x-pages.information.complaint-process />
                @else
                    <p>No information available for this section.</p>
                @endif
            </div>
        </div>
    </x-layouts.home-layout>
@endsection
