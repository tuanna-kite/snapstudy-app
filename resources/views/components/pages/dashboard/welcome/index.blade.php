<div class="rounded-3xl p-3" style="background: linear-gradient(61.28deg, #B0F6F6 -12.4%, #A1A5FC 99.19%);">
    <div class="relative">
        <div class="w-full md:w-5/12 mb-6 p-4">
            <h1 class="font-extrabold text-5xl text-text.light.primary">
                {{ trans('dashboard.Hello') }} <br /> {{ $authUser->full_name }},
            </h1>
            <p class="font-normal text-base text-text.light.primary mt-3">
                {{ trans('panel.have_event', ['count' => !empty($unReadNotifications) ? count($unReadNotifications) : 0]) }}
            </p>
            <a href="{{ route('Notification.index') }}"
                class="mt-12 flex text-xs items-center bg-primary.main py-3 px-5 w-fit rounded-xl font-medium lg:text-base text-white hover:opacity-90">
                {{ trans('panel.view_all_events') }} <x-component.icon name="end-icon" />
            </a>
        </div>
        <img src="img/character_11.png" alt="character" class="md:absolute w-80 md:right-3 md:-top-16">
        <ul class="py-6 px-8 rounded-3xl bg-primary.lighter flex gap-1 justify-between relative z-10">
            <li class="flex flex-col justify-between">
                <p class='text-sm md:text-base font-semibold text-text.light.primary'>
                    {{ $authUser->isUser() ? trans('panel.purchased_courses') : trans('panel.pending_appointments') }}
                </p>
                <p class="text-3xl md:text-5xl font-bold text-primary.main">
                    {{ !empty($pendingAppointments) ? $pendingAppointments : (!empty($webinarsCount) ? $webinarsCount : 0) }}
                </p>
            </li>
            <li class="flex flex-col justify-between">
                <p class='text-sm md:text-base font-semibold text-text.light.primary'>
                    {{ trans('panel.support_messages') }}</p>
                <p class="text-3xl md:text-5xl font-bold text-primary.main">
                    {{ !empty($supportsCount) ? $supportsCount : 0 }}</p>
            </li>
            <li class="flex flex-col justify-between">
                <p class='text-sm md:text-base font-semibold text-text.light.primary'>{{ trans('panel.comments') }}</p>
                <p class="text-3xl md:text-5xl font-bold text-primary.main">
                    {{ !empty($commentsCount) ? $commentsCount : 0 }}</p>
            </li>
        </ul>
    </div>
</div>
