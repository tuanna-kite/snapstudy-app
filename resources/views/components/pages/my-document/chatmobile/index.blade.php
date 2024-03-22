<x-layouts.dashboard-layout title="">
    <div class="flex-1 flex-col flex bg-white rounded-3xl">
        <div class="border-b border-border-disabled">
            <x-pages.my-document.headerchat />
        </div>
        <div class="flex-1">
            <x-pages.my-document.bodychat />
        </div>
        <div class="border-t border-border-disabled">
            <x-pages.my-document.bodychat.chat />
        </div>
    </div>
</x-layouts.dashboard-layout>
