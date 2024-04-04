<div class="px-4 py-3 rounded-tr-3xl bg-white flex justify-between items-center">
    <div class="flex items-center gap-4">
        <div class="p-3 rounded-full bg-primary.lighter w-12 h-12 flex items-center justify-center">
            <x-component.icon name="note-favorite" class="w-12 h-12" />
        </div>
        <p class="font-semibold text-sm text-text.light.primary">{{ $selectSupport->title }}</p>
    </div>
    <div class="flex items-center gap-4">
        <x-component.material-icon name='search'/>
        <x-component.material-icon name='more_vert'/>
    </div>

</div>
