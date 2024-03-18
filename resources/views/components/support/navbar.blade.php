<div class="p-5 space-y-4">
    {{-- avatar --}}
    <div>
        <button class="rounded-full transparent relative" onclick="handleClick()">
            <img src="img/logo/avatar.png" alt="" width="48" height="48">
            <div class="absolute -right-0.5 -bottom-0.5">
                <x-icon name="online" width="10" height="10"/>
            </div>
        </button>
    </div>
    {{-- Search --}}
    <x-search.search class="flex-row-reverse"/>
    {{-- Chat List --}}
    <div>
        <x-support.chat-card/>
        <x-support.chat-card/>
        <x-support.chat-card/>
        <x-support.chat-card/>
    </div>
</div>
