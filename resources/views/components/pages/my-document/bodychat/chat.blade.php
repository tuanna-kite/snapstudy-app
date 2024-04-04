<form action="{{ route('support.reply', ['id' => $selectSupport->id]) }}" method="POST">
    @csrf
    <div class="flex items-center px-4 py-2 bg-white">
        <button class="p-2 hover:bg-slate-300">
            <x-component.icon name='ic_emoji' width='20' height='20' />
        </button>
        <input class="flex-1" type="text" name="message" placeholder="Type a message">
        <div class="flex items-center">
            <button class="p-2 hover:bg-slate-300">
                <x-component.icon name='ic_add_photo' width='20' height='20' />
            </button>
            <button type="submit" class="p-2 hover:bg-slate-300">
                <x-component.icon name='ic_attach_file' width='20' height='20' />
            </button>
            <button class="p-2 hover:bg-slate-300">
                <x-component.icon name='ic_send' width='20' height='20' />
            </button>
        </div>
    </div>
</form>
