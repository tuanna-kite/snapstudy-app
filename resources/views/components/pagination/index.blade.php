@if (!empty($paginator) and $paginator->hasPages())
    <nav>
        <ul class="flex items-center justify-center gap-3">
            @if ($paginator->onFirstPage())
                <li>
                    <a class="pointer-events-none">
                        <p class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full">
                            <x-component.material-icon name="chevron_left" class="text-text.light.disabled" />
                        </p>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="">
                        <p class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full">
                            <x-component.material-icon name="chevron_left" class="text-text.light.primary" />
                        </p>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @php
                    $separate = false;
                @endphp

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if (
                            $page < 2 or
                                $page + 1 > $paginator->lastPage() or
                                $page < $paginator->currentPage() + 2 and $page > $paginator->currentPage() - 2)
                            @php
                                $separate = true;
                            @endphp

                            @if ($page == $paginator->currentPage())
                                <li>
                                    <p
                                        class="w-6 h-6 p-1 text-center box-content border bg-primary.main text-white border-grey-400 rounded-full ">
                                        {{ $page }}
                                    </p>
                                </li>
                            @else
                                <li><a href="{{ $url }}">
                                        <p
                                            class="w-6 h-6 p-1 text-center box-content border  text-text.light.disabled border-grey-400 rounded-full ">
                                            {{ $page }}
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @elseif($separate)
                            <li aria-disabled="true"><span>...</span></li>
                            @php
                                $separate = false;
                            @endphp
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}">
                        <p class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full">
                            <x-component.material-icon name="chevron_right" class="text-text.light.primary" />
                        </p>
                    </a>
                </li>
            @else
                <li>
                    <a class="pointer-events-none">
                        <p class="w-6 h-6 p-1 box-content bg-grey-300 rounded-full">
                            <x-component.material-icon name="chevron_right" class="text-text.light.disabled" />
                        </p>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
@endif
