{{-- Button Locale Language --}}
<div x-data="{ open: false }" class="relative flex">
    <button @click="open = !open" class="rounded-full">
        <img src="{{ $authUser->getAvatar() ? $authUser->getAvatar() : '' }}" class="w-10 aspect-square rounded-full"
            alt="avt">
    </button>
    <ul x-show.transition="open" @click.away="open = false"
        class="absolute right-0 top-10 z-20 bg-white mt-6 rounded-xl overflow-hidden shadow-lg w-40 min-w-64">
        <x-slidebar padding="p-2">
        </x-slidebar>
    </ul>
</div>
