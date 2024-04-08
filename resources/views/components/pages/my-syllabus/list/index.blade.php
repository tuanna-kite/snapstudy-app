@props(['title', 'webinars', 'href' => ''])

<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl text-text.light.primary">
            {{ $title }}
        </h1>

        @if ($href)
            <a href={{ $href }}
                class="font-medium text-xs text-text.light.disabled rounded-lg border border-border-disabled py-1 px-4">
                <span class="flex items-center">
                    {{ trans('dashboard.See All') }} <x-component.material-icon name="chevron_right" />
                </span>
            </a>
        @endif
    </div>
    <div>
        <x-documents.document-grid :webinar="$webinars" />
    </div>
</div>
