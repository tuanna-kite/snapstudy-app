@php
    $fullNameInput = [
        'name' => 'full_name',
        'label' => trans('auth.Full Name'),
        'placeholder' => trans('auth.Enter your full name'),
    ];

    $emailInput = [
        'name' => 'username',
        'label' => trans('auth.Email'),
        'placeholder' => trans('auth.Enter your email'),
    ];

    $passwordInput = [
        'name' => 'password_signup',
        'label' => trans('auth.Password'),
        'placeholder' => trans('auth.Enter your password'),

    ];

    $codeInput = [
        'name' => 'referral_code',
        'label' => trans('auth.Referral Code'),
        'placeholder' => trans('auth.Enter your code (optional)'),
    ];

@endphp

<div class="">
    <button type="button" class="w-full text-end" onclick="closeModalAuth()">
        <x-component.material-icon name='close' />
    </button>
    <div class="pb-12">
        <div class="text-center mb-6 space-y-2 ">
            <h1 class="text-3xl text-text.light.primary">{{ trans('auth.Sign up') }}</h1>
            <h3 class="text-sm text-text.light.secondary">{{ trans('auth.Learn on your own time from top') }} <br />
                {{ trans('auth.universities and businesses.') }}
            </h3>
        </div>
        <div>
            {{-- TODO: check form field to post --}}
            <form method="post" action="{{ route('popup_register') }}" class="px-12 sm:w-96">
                {{-- Form input --}}
                <div class="space-y-4">
                    <x-input.input-label :data="$fullNameInput" />
                    <x-input.input-label :data="$emailInput" />
                    <x-input.input-password :data="$passwordInput" />
                    <x-input.input-label :data="$codeInput" />
                </div>
                <div class="mt-1" id="errorSignup" style="color: red;"></div>
                <div class="space-y-6">
                    <button type="button" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white"
                        id="signupbtn">
                        <span class="font-medium text-sm">
                            {{ trans('auth.Sign up') }}
                        </span>
                    </button>
                    <p class="text-center text-sm text-text.light.primary">
                        {{ trans('auth.Do you already have an account?') }} <button type="button"
                            onclick="showPage('login')"
                            class="text-primary.main hover:underline">{{ trans('auth.Login') }}</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <script>
        document.getElementById("signupbtn").addEventListener("click", function() {
            var formData = {
                full_name: document.getElementById("full_name").value,
                email: document.getElementById("username").value,
                password: document.getElementById("password_signup").value,
                referral_code: document.getElementById("referral_code").value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: "POST",
                url: "{{ route('popup_register') }}",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        showPage('verify');
                    } else {
                        // Display validation errors
                        var errorContainer = document.getElementById("errorSignup");
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
        });
    </script>
@endpush
