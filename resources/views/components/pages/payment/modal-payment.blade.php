@php

@endphp

<div x-data="{ showModal: true }" x-init="$watch('showModal', value => {
    document.body.style.overflow = value ? 'hidden' : 'auto';
})">
    <!-- Modal -->
    <div id='modal' x-show="showModal"
        class="fixed h-screen w-screen z-10 top-0 left-1/2 -translate-x-1/2 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="fixed inset-0 bg-black opacity-50 z-10" @click="showModal = false"></div>
        <div id='contentmodal' class="bg-white p-4 rounded-3xl shadow-lg border z-20">
            {{-- Content --}}
            <div class="">
                <button type="button" class="w-full text-end" @click="showModal = false">
                    <x-component.material-icon name='close' />
                </button>
                <div class="space-y-4 flex flex-col items-center text-center px-10 pb-10">
                    <img src="{{ asset('img/logo/check-circle-outline.png') }}" class="w-12 aspect-square" />
                    <div class="space-y-1">
                        <h1 class="font-bold text-2xl text-text.light.primary">
                            Payment success
                        </h1>
                        <h2 class="text-base text-text.light.secondary">
                            Wish you have interesting experiences
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
