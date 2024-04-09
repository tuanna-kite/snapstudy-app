@php
    $loginInput = [
        'name' => 'email',
        'label' => 'Email',
        'placeholder' => 'Enter your mail',
    ];
    $passwordInput = [
        'name' => 'password',
        'label' => 'Password',
        'placeholder' => 'Enter your password',
    ];

@endphp

<div class="">
    <button type="button" class="w-full text-end" @click="showModal = false">
        <x-component.material-icon name='close' />
    </button>
    <div class="pb-12">
        <div class="text-center mb-6">
            <h1 class="text-3xl text-text.light.primary">Welcome back!</h1>
            <h3 class="text-sm text-text.light.secondary">Login to your account</h3>
        </div>
        <div>
            <form method="post" action="/login" class="px-12 sm:w-96">
                <div class="space-y-4">
                    <x-input.input-label :data="$loginInput" />
                    <x-input.input-password :data="$passwordInput" />
                    <div>
                        <a href="#">
                            <span class="text-sm text-primary.main">
                                Forgot password?
                            </span>
                        </a>
                    </div>
                </div>
                <div class="space-y-6">
                    <button type="submit" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white">
                        <span class="font-medium text-sm">
                            Login
                        </span>
                    </button>
                    <p class="text-center text-sm text-text.light.primary">
                        Do not have an account? <button type="button" @click="page = 'signup'"
                            class="text-primary.main hover:underline">Sign
                            up</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
