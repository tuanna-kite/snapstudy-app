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
            <form method="post" action="/login" class="px-12 sm:w-96">
                <div class="space-y-4">
                    <x-input.input-label :data="$emailInput" />
                    <x-input.input-password :data="$passwordInput" />
                    <div>
                        <a href="#">
                            <span class="text-sm text-primary.main">
                                {{ trans('auth.Forgot password?') }}
                            </span>
                        </a>
                    </div>
                </div>
                <div class="space-y-6">
                    <button type="submit" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white">
                        <span class="font-medium text-sm">
                            {{ trans('auth.Login') }}
                        </span>
                    </button>
                    <p class="text-center text-sm text-text.light.primary">
                        {{ trans('auth.Do not have an account?') }} <button type="button" @click="page = 'signup'"
                            class="text-primary.main hover:underline">{{ trans('auth.Sign up') }}</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
