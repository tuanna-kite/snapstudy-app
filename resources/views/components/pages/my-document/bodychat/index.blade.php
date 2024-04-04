
<div class="space-y-6 bg-white p-6">
    @foreach($selectSupport->conversations as $conversation)
        @if($conversation->sender_id == auth()->user()->id)
            <x-pages.my-document.bodychat.chat-box :displayChatIcon="false" :conversation="$conversation" class="justify-end text-end" />
        @else
            <x-pages.my-document.bodychat.chat-box :conversation="$conversation" class="" />
        @endif
    @endforeach
</div>
