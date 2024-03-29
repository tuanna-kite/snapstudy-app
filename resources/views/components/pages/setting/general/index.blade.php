<div class="flex flex-col md:flex-row items-start">
    <!-- Content for Tab 1 -->
    <div class="w-full md:w-1/3">
        <x-pages.setting.general.update-avatar/>
    </div>
    <div class="w-full md:w-2/3">
        <x-pages.setting.general.update-user :user="$user"/>
    </div>
</div>
