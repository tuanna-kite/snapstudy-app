<form method="post" action="{{ route('user.update.notification') }}">
    @csrf
    <x-input.toggle />
    <div class="rounded-2xl p-6 pb-6 space-y-10 bg-white">
        <div class="space-y-4">
            <h1 class="font-bold text-xs text-text.light.secondary uppercase">
                {{ trans('dashboard.Activity') }}
            </h1>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_comment" value="1"
                        {{ $user->enable_email_comment ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.Email me when someone comments onmy article') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_answers" value="1"
                        {{ $user->enable_email_answers ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.Email me when someone answers on my form') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_follow" value="1"
                        {{ $user->enable_email_follow ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.Email me hen someone follows me') }}
                </p>
            </div>
        </div>
        <div class="space-y-4">
            <h1 class="font-bold text-xs text-text.light.secondary uppercase">
                {{ trans('dashboard.Application') }}
            </h1>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_new" value="1"
                        {{ $user->enable_email_new ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.News and announcements') }} </p>
            </div>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_product_update" value="1"
                        {{ $user->enable_email_product_update ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.Weekly product updates') }} </p>
            </div>
            <div class="flex items-center gap-2">
                <label class="switch">
                    <input type="checkbox" name="enable_email_blog_weekly" value="1"
                        {{ $user->enable_email_blog_weekly ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>
                <p>
                    {{ trans('dashboard.Weekly blog digest') }} </p>
            </div>
        </div>
        <div class="flex justify-end w-full">
            <x-button.button text="{{ trans('dashboard.Save Changes') }}" />
        </div>
    </div>
</form>
