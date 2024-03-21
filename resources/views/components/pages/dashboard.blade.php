<x-layouts.dashboard-layout title="Dashboard">
    <div class="space-y-3 h-[3000px]">
        <div class="flex flex-col gap-3 lg:flex-row">
            <div class="w-full lg:w-3/5">
                <x-component.welcome />
            </div>
            <div class="w-full lg:w-2/5 flex flex-col justify-between gap-3">
                <x-component.pay />
                <div class="flex justify-center items-center p-24 lg:flex-1 rounded-3xl bg-white">
                    <span class="text-3xl font-bold">
                        Diamond
                    </span>
                </div>
            </div>
        </div>
        {{-- Syllabus --}}
        <div class="rounded-3xl p-6 bg-whit">
            <div class="flex items-center justify-between">
                <h1 class="font-bold text-lg">My Syllabus</h1>
                <a href="#">
                    <span class="flex items-center">
                        View all <x-component.material-icon name="chevron_right" />
                    </span>
                </a>
            </div>
            <div class="">
                <x-documents.document-grid />
            </div>
        </div>
    </div>

</x-layouts.dashboard-layout>
