<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl text-text.light.primary">
            Recently Viewed Products
        </h1>
        <button
            class="font-medium text-xs text-text.light.disabled rounded-lg border border-border-disabled py-1 px-4">
            <span class="flex items-center">
                Show 5 more <x-component.material-icon name="chevron_right" />
            </span>
        </button>
    </div>
    <div>
        <x-documents.document-grid/>
    </div>
</div>
