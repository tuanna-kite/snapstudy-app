<div class="flex justify-between">
    <div class="w-full grid gap-8 lg:gap-4 lg:grid-cols-2 xl:grid-cols-4 lg:grid-rows-1 grid-cols-1">
        @foreach ($webinar as $trending)
            <x-documents.document-card :trending="$trending"/>
        @endforeach
    </div>
</div>
