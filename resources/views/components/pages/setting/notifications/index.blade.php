
<form method="post" action="{{ route('user.update.notification') }}">
    @csrf
    <x-input.toggle />
    <div class="rounded-2xl p-6 pb-6 space-y-10 bg-white">
        <div class="space-y-4">
        <h1 class="font-bold text-xs text-text.light.secondary uppercase">
            Activity
        </h1>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_comment" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                Email me when someone comments onmy article
            </p>
        </div>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_answers" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                Email me when someone answers on my form
            </p>
        </div>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_follow" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                Email me hen someone follows me
            </p>
        </div>
    </div>
    <div class="space-y-4">
        <h1 class="font-bold text-xs text-text.light.secondary uppercase">
            Application
        </h1>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_new" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                News and announcements </p>
        </div>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_product_update" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                Weekly product updates </p>
        </div>
        <div class="flex items-center gap-2">
            <label class="switch">
                <input type="checkbox" name="enable_email_blog_weekly" value="1">
                <span class="slider round"></span>
            </label>
            <p>
                Weekly blog digest </p>
        </div>
    </div>
    <div class="flex justify-end w-full">
        <x-button.button text="Save Changes" />
    </div>
</div>
</form>
