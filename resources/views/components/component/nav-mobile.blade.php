<div x-data="{ showModal: false }" x-init="$watch('showModal', value => {
    document.body.style.overflow = value ? 'hidden' : 'auto';
})">
    <!-- Button to toggle the modal -->
    <button class="flex" x-show="showModal == false" @click="showModal = true">
        <x-component.material-icon name='menu' />
    </button>
    <button class="flex" x-show="showModal == true" @click="showModal = false">
        <x-component.material-icon name='close' />
    </button>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 h-screen top-20 z-50"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="bg-white p-6 h-full">
            <!-- Modal content -->
            <x-slidebar padding="p-3">
                <div class="flex items-center justify-start w-full gap-3">
                    <img src="{{ $authUser->getAvatar() ? $authUser->getAvatar() : '' }}"
                        class="w-10 aspect-square rounded-full" alt="avt">
                    <span class="text-base font-medium">
                        Quang Anh
                    </span>
                </div>
                <hr class="border-t-1 border-gray-300 w-full">
            </x-slidebar>
        </div>
    </div>
</div>
