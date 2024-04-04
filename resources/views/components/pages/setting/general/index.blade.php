@php
$message = $message ?? '';

@endphp

<form method="post" action="{{ route('user.update') }}">
    @csrf
    <div class="flex flex-col md:flex-row items-start">
        <div class="w-full md:w-1/3">
            <x-pages.setting.general.update-avatar/>
        </div>
        <div class="w-full md:w-2/3">
            <x-pages.setting.general.update-user :user="$user" :message="$message" :listCity="$listCity"
                                                 :listProvinces="$listProvinces" :countries="$countries"/>
        </div>
    </div>
</form>
