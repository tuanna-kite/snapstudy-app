@php
    $verifyInput = [
        'name' => 'code',
        'label' => trans('auth.Verification code'),
        'placeholder' => trans('auth.Enter your code'),
        'type' => 'tel',
    ];
    // function maskEmail($email)
    // {
    //     // Split email address into local part and domain part
    //     [$localPart, $domainPart] = explode('@', $email);

    //     // Get the first 3 characters of the local part
    //     $maskedLocalPart = substr($localPart, 0, 3);

    //     // Return the masked email address
    //     return $maskedLocalPart . '*****@' . $domainPart;
    // }
@endphp

<div class="">
    <button type="button" class="w-full text-end" onclick="closeModalAuth()">
        <x-component.material-icon name='close' />
    </button>
    <div class="pb-12">
        <div class="text-center mb-6 space-y-2">
            <h1 class="text-3xl text-text.light.primary">{{ trans('auth.Account verification') }}</h1>
            <h3 class="text-sm text-text.light.secondary">
                {{ trans('auth.We have to sent the code verification to your mail') }}</h3>
            {{-- TODO: alter real email  --}}
            <h4 class="font-semibold text-sm text-text.light.primary">
                {{-- {{ maskEmail('toilaemaildemo@gmail.com') }} --}}
            </h4>
        </div>
        <div>
            {{-- TODO: check form field to post --}}
            <form method="post" action="/verification" class="px-12 sm:w-96">
                <div class="space-y-4">
                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="username" value="{{ $usernameValue }}"> --}}

                    <x-input.input-label :data="$verifyInput" />
                    @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="space-y-6">
                    <button type="button" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white"
                        id="verifyBtn">
                        <span class="font-medium text-sm">
                            {{ trans('auth.Verify') }}
                        </span>
                    </button>
                    <div class="text-center mt-6">
                        <a href="#" id="resendbtn"
                            class="font-normal text-sm text-primary.main">{{ trans('auth.Resend code') }}</a>
                    </div>

                </div>
                <div class="mt-1" id="errorVerify" style="color: red;"></div>
            </form>
        </div>
    </div>
</div>

@push('scripts_bottom')
    <script>
        document.getElementById("resendbtn").addEventListener("click", function() {

            $.ajax({
                type: "GET",
                url: "{{ route('popup_resendCode') }}",
                dataType: 'json',
                success: function(data) {
                    var resend = document.getElementById("errorVerify");
                    resend.innerHTML = '';
                    resend.innerHTML += '<p>' + 'Chúng tôi đã gửi mã xác minh đến email của bạn' + '</p>';
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        document.getElementById("verifyBtn").addEventListener("click", function() {
            var formData = {
                username: document.getElementById("username").value,
                code: document.getElementById("code").value,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                type: "POST",
                url: "{{ route('popup_verification') }}",
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        console.log('success');
                        window.location.href = window.location.href = '{{ route('admin.dashboard') }}';
                    } else {
                        // Display validation errors
                        var errorContainer = document.getElementById("errorVerify");
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
