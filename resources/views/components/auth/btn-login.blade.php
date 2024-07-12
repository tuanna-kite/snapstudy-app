{{-- <div id="button_login" x-data="{
    showModal: false,
    page: 'login'
}" x-init="$watch('showModal', value => {
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
            <div x-show="page =='verify'">
                <x-auth.verify />
            </div>
        </div>
    </div>
</div> --}}

<div id="button_login">
    <!-- Button to toggle the modal -->
    <button id="login_button" class="rounded-full px-6 py-1.5 bg-primary.main text-white">
        <span class="font-medium text-sm">{{trans("auth.Login")}}</span>
    </button>
    <button id="register_button" class="rounded-full px-6 py-1.5 bg-primary.main text-white">
        <span class="font-medium text-sm">{{trans("auth.register")}}</span>
    </button>

    <!-- Modal -->
    <div id='modal'
        class="fixed h-screen w-screen z-10 top-0 left-1/2 -translate-x-1/2 hidden flex items-center justify-center">
        <div id='overlay' class="fixed inset-0 bg-black opacity-50 z-10"></div>
        <div id='contentmodal' class="bg-white p-4 rounded-3xl shadow-lg border z-20">
            <!-- Modal content -->
            <div id="login_page">
                <x-auth.login />
                <!-- Login Form content -->
            </div>
            <div id="signup_page" class="hidden">
                <x-auth.signup />
                <!-- Signup Form content -->
            </div>
            <div id="verify_page" class="hidden">
                <x-auth.verify />
                <!-- Verify Form content -->
            </div>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <script>
        // Get references to elements
        const buttonLogin = document.getElementById('login_button');
        const buttonRegister = document.getElementById('register_button');
        const modal = document.getElementById('modal');
        const overlay = document.getElementById('overlay');
        // const contentModal = document.getElementById('contentmodal');
        const loginPage = document.getElementById('login_page');
        const signupPage = document.getElementById('signup_page');
        const verifyPage = document.getElementById('verify_page');

        // Event listener for button click
        buttonLogin.addEventListener('click', function() {
            showModalAuth()
            showPage('login')
        });

        buttonRegister.addEventListener('click', function() {
            showModalAuth()
            showPage('signup')
        });

        // Event listener to close modal when overlay is clicked
        overlay.addEventListener('click', function() {
            if (!verifyPage.classList.contains('hidden')) {
                return; // Prevent closing modal if verify page is shown
            }
            closeModalAuth();
        });

        // Function to close modal
        function closeModalAuth() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showModalAuth() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // Function to switch between pages
        function showPage(pageName) {
            if (pageName === 'login') {
                loginPage.classList.remove('hidden');
                signupPage.classList.add('hidden');
                verifyPage.classList.add('hidden');
            } else if (pageName === 'signup') {
                loginPage.classList.add('hidden');
                signupPage.classList.remove('hidden');
                verifyPage.classList.add('hidden');
            } else if (pageName === 'verify') {
                loginPage.classList.add('hidden');
                signupPage.classList.add('hidden');
                verifyPage.classList.remove('hidden');
            }
        }
    </script>
@endpush
