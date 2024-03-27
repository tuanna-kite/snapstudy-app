@props(['title'])

<div class="rounded-3xl p-5 flex flex-col gap-4 bg-white">
    <div class="rounded-lg p-2 bg-primary.lighter w-fit">
        <span class="font-normal text-xs text-primary.main">Business Foundation</span>
    </div>
    <div class="flex items-center gap-2">
        <img src="{{ asset('img/logo/rmit-logo.png') }}" alt="logo-rmit" width="32" height="32">
        <span class="font-semibold text-sm text-text.light.primary">
            {{ $title }}
        </span>
    </div>
    <div>
        <span class="font-semibold text-base text-primary.main">SEM C - BUSINESS IN SOCIETY - ASM 3</span>
    </div>
    <div class="truncate-lines-2">
        <span class="font-normal text-sm text-text.light.primary ">Structure and guidance: As well as an Introduction
            and
            Conclusion, you need to include the following sections in the main body of your essay: 1. Define your terms:
            What is CSR? What is Corporate Social Irresponsibility? …</span>
    </div>
    <div class="flex justify-between items-center">
        <span class="font-medium text-xs text-text.light.primary">March 31,2024</span>
        <a href="#">
            <span class="font-medium text-sm text-text.light.disabled">
                See full outline >
            </span>
        </a>
    </div>
</div>

<style>
    .truncate-lines-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        /* Number of lines to show */
    }
</style>
