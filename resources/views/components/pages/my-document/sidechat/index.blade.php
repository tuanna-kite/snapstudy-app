<div class="p-5 bg-white space-y-4 rounded-3xl md:rounded-tl-3xl ">
    {{-- avatar --}}
    <div>
        <button class="rounded-full transparent relative" onclick="handleClick()">
            <img src="img/logo/avatar.png" alt="" width="48" height="48">
            <div class="absolute -right-0.5 -bottom-0.5">
                <x-component.icon name="online" width="10" height="10" />
            </div>
        </button>
    </div>
    {{-- Search --}}
    <x-search.search class="" class="border border-grey-300 flex-row-reverse" />
    {{-- Chat List --}}
    <div class="w-full">
        <x-pages.my-document.sidechat.chat-card />
        <x-pages.my-document.sidechat.chat-card />
        <x-pages.my-document.sidechat.chat-card />
        <x-pages.my-document.sidechat.chat-card />
    </div>
</div>
