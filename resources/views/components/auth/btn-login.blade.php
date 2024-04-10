<div x-data="{ showModal: false, page: 'login' }" x-init="$watch('showModal', value => {
    document.body.style.overflow = value ? 'hidden' : 'auto';
})">
    <!-- Button to toggle the modal -->
    <button class="rounded-full px-6 py-1.5 bg-primary.main text-white" @click="showModal = true">
        <span class="font-medium text-sm">
            {{ trans('auth.Login') }}
        </span>
    </button>

    <!-- Modal -->
    <div id='modal' x-show="showModal"
        class="fixed h-screen w-screen z-10 top-0 left-1/2 -translate-x-1/2 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="fixed inset-0 bg-black opacity-50 z-10" @click="showModal = false"></div>
        <div id='contentmodal' class="bg-white p-4 rounded-3xl shadow-lg border z-20">
            <!-- Modal content -->
            <div x-show="page =='login'">
                <x-auth.login />
            </div>
            <div x-show="page =='signup'">
                <x-auth.signup />
            </div>
        </div>
    </div>
</div>
