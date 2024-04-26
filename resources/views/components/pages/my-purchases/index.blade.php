<x-layouts.dashboard-layout title="My Purchases">
    <div class="space-y-3">
        <x-pages.my-purchases.info />
        <div class="bg-white rounded-3xl">
{{--            <div class="p-6">--}}
{{--                <x-input.group-filter />--}}
{{--            </div>--}}
            <div>
                <x-pages.my-purchases.card />
                <x-pages.my-purchases.card />
                <x-pages.my-purchases.card />
            </div>
            <x-component.pagination />
        </div>
    </div>
</x-layouts.dashboard-layout>
