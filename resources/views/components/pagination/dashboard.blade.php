@if (!empty($paginator) and $paginator->hasPages())
    <nav class="px-2 py-2.5 rounded-b-3xl bg-white flex justify-end border-t" style="border-color: #DFE3E8">
        <ul class="flex items-center justify-end gap-3">
            <li class="">
                <p class="text-text.light ">
                    {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} of {{ $paginator->total() }}
                </p>
            </li>
            @if ($paginator->onFirstPage())
                <li class="w-6 h-6">
                    <a class="pointer-events-none ">
                        <x-component.material-icon name='chevron_left' class="text-text.light.disabled" />
                    </a>
                </li>
            @else
                <li class="w-6 h-6">
                    <a href="{{ $paginator->previousPageUrl() }}" class="">
                        <x-component.material-icon name='chevron_left' class="text-text.light.primary" />
                    </a>
                </li>
            @endif
            @if ($paginator->hasMorePages())
                <li class="w-6 h-6">
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <x-component.material-icon name='chevron_right' class="text-text.light.primary" />
                    </a>
                </li>
            @else
                <li class="w-6 h-6">
                    <a class="pointer-events-none">
                        <x-component.material-icon name='chevron_right' class="text-text.light.disabled" />
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
