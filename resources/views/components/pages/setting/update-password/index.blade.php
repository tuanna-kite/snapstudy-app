<form method="post" action="{{ route('user.changePass') }}">
    @csrf
    <div class="bg-white p-6 rounded-2xl space-y-6">
        <x-input.input-password name="oldPassword" placeholder="{{ trans('dashboard.Old Password') }}" type='password' />
        <div class="space-y-2">
            <x-input.input-password name="newPassword" placeholder="{{ trans('dashboard.New Password') }}"
                type='password' />
            <div class="flex gap-1 pl-2">
                <x-component.icon name="ic_info" width="16" height="16" />
                <p class="font-normal text-xs text-text.light.secondary">
                    {{ trans('dashboard.Password must be minimum 6+') }}</p>
            </div>
        </div>
        <x-input.input-password name="confirmNewPasswword" placeholder="{{ trans('dashboard.Confirm New Password') }}"
            type='password' />
        <div class="flex justify-end w-full">
            <x-button.button text="{{ trans('dashboard.Save Changes') }}" />
        </div>
    </div>
</form>
