@php
    $emailInput = [
        'name' => 'email',
        'label' => trans('auth.Email'),
        'placeholder' => trans('auth.Enter your email'),
    ];
    $passwordInput = [
        'name' => 'password',
        'label' => trans('auth.Password'),
        'placeholder' => trans('auth.Enter your password'),
    ];

@endphp

<div class="">
    <button type="button" class="w-full text-end" @click="showModal = false">
        <x-component.material-icon name='close' />
    </button>
    <div class="pb-12">
        <div class="text-center mb-6">
            <h1 class="text-3xl text-text.light.primary">{{ trans('auth.Welcome back!') }}</h1>
            <h3 class="text-sm text-text.light.secondary">{{ trans('auth.Login to your account') }}</h3>
        </div>
        <div>
            {{-- TODO: check form field to post --}}
            <div class="px-12 sm:w-96">
                <div class="space-y-4">
                    <x-input.input-label :data="$emailInput" />
                    <x-input.input-password :data="$passwordInput" />
                    <div id="errorContainer" style="color: red;"></div>
                    <div>
                        <a href="#">
                            <span class="text-sm text-primary.main">
                                {{ trans('auth.Forgot password?') }}
                            </span>
                        </a>
                    </div>
                </div>
                <div class="space-y-6">
                    <button type="button" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white"
                        id="loginBtn">
                        <span class="font-medium text-sm">
                            {{ trans('auth.Login') }}
                        </span>
                    </button>
{{--                    <p class="text-center text-sm text-text.light.primary">--}}
{{--                        {{ trans('auth.Do not have an account?') }} <button type="button" @click="page = 'signup'"--}}
{{--                            class="text-primary.main hover:underline">{{ trans('auth.Sign up') }}</button>--}}
{{--                    </p>--}}
                    <p class="text-center text-sm text-text.light.primary">
                        {{ trans('auth.Do not have an account?') }} <a type="button"  href="{{ route('register') }}"
                        class="text-primary.main hover:underline">{{ trans('auth.Sign up') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts_bottom')
    <script>
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');

        function submitForm() {
            var formData = {
                email: emailInput.value,
                password: passwordInput.value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: "POST",
                url: "{{ route('popupLogin') }}",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        window.location.href = '{{ route('home') }}';
                    } else {
                        // Display validation errors
                        var errorContainer = document.getElementById("errorContainer");
                        errorContainer.innerHTML = ''; // Clear previous errors
                        for (var error in data.errors) {
                            console.log(data.errors[error]);
                            errorContainer.innerHTML += '<p>' + data.errors[error] + '</p>';
                        }
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        // Add event listener to the email input field
        emailInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                submitForm();
            }
        });

        // Add event listener to the password input field
        passwordInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                submitForm();
            }
        });

        loginBtn.addEventListener("click", function() {
            submitForm();
        });
    </script>
@endpush
