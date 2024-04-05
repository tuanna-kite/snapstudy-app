
<div class="p-5 bg-white space-y-4 rounded-3xl md:rounded-tl-3xl ">
    {{-- avatar --}}
    <div>
        <button class="rounded-full transparent relative" onclick="handleClick()">
            <img src="{{ auth()->user()->getAvatar() }}" alt="" width="48" height="48">
            <div class="absolute -right-0.5 -bottom-0.5">
                <x-component.icon name="online" width="10" height="10" />
            </div>
        </button>
    </div>
    {{-- Search --}}
    <form action="{{ route('support.tickets') }}" method="GET">
        <div class='rounded-xl p-4 flex items-center bg-white justify-between relative border border-grey-300 flex-row-reverse'>
                <span
                    class="absolute left-4 top-0 transform -translate-y-1/2 p-1 bg-white text-text.light.disabled font-normal text-xs">
                    Search
                </span>
            <input class="flex-1" type="text" name="searchTicket" placeholder="Search...">
            <button id='btnSearch' class="" type="submit">
                <x-component.icon name="ic_search" />
            </button>
        </div>
    </form>
    {{-- Chat List --}}
    <div class="w-full">
        @foreach($supports as $support)
            <x-pages.my-document.sidechat.chat-card :support="$support"/>
        @endforeach
    </div>
</div>
