@php
    $fullNameInput = [
        'name' => 'fullName',
        'label' => 'Full Name',
        'placeholder' => 'Enter your full name',
    ];

    $emailInput = [
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
        <div class="text-center mb-6 space-y-2 ">
            <h1 class="text-3xl text-text.light.primary">Sign up</h1>
            <h3 class="text-sm text-text.light.secondary">Learn on your own time from top <br /> universities and
                businesses.
            </h3>
        </div>
        <div>
            <form method="post" action="/register"  class="px-12 sm:w-96">
                {{-- Form input --}}
                <div class="space-y-4">
                    <x-input.input-label :data="$fullNameInput" />
                    <x-input.input-label :data="$emailInput" />
                    <x-input.input-password :data="$passwordInput" />
                </div>
                <div class="space-y-6">
                    <button type="submit" class="rounded-lg w-full px-5 py-2 mt-12 bg-primary.main text-white">
                        <span class="font-medium text-sm">
                            Sign up
                        </span>
                    </button>
                    <p class="text-center text-sm text-text.light.primary">
                        Do you already have an account? <button type="button" @click="page = 'login'"
                            class="text-primary.main hover:underline">Login</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
