<x-layouts.home-layout>
    <div class="py-20 bg-primary.light">
        <div class="container mx-auto space-y-6 md:px-4" style="max-width: 960px">
            <h1 class="font-normal text-3xl text-text.light.primary">
                {{$course->category->slug}}
            </h1>
            <h2 class="font-extrabold text-5xl text-primary.main">
                {{$course->title}}
            </h2>
            <p class="font-normal text-base text-text.light.primary">
                {{$course->seo_description}}
            </p>

            <p class="font-normal text-base text-text.light.primary">
                <span class="font-semibold">1.332.107 </span> đã đăng ký
            </p>
        </div>
    </div>
    <div class="bg-white">
        <div class='container mx-auto py-16 space-y-16' x-data="{ scrolled: false }"
             @scroll.window="scrolled = (window.scrollY > document.getElementById('targetDiv').offsetTop + document.getElementById('targetDiv').offsetHeight)">
            {{-- Table Content --}}
            <div x-data="{ openTab: 1 }" id="targetDiv" class="bg-white max-w-[960px] mx-auto">
                <div class="border border-grey-300 rounded-2xl">
                    <div class="px-6 py-3 bg-primary.main rounded-t-2xl flex justify-between items-center text-white"
                         x-on:click="openTab !== 1 ? openTab = 1 : openTab = null">
                        <h6 class="font-bold text-xl">
                            Table of contents
                        </h6>
                        <x-component.material-icon name="expand_more" x-show="openTab === null"/>
                        <x-component.material-icon name="expand_less" x-show="openTab === 1"/>
                    </div>
                    <div class="table_contents px-6 py-4" x-show="openTab === 1">
                        {!! $docTrans->table_contents !!}
                    </div>
                </div>
            </div>
            {{-- Scrolled Table of Contents  --}}
            @if($hasBought)
                <div x-show='scrolled'>
                    <div x-data="{ showModal: false, buttonPosition: { top: 0, right: 0 } }">
                        <!-- Button to toggle the modal -->
                        <button id="scrollBtn"
                                class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
                                @click="showModal = true; buttonPosition = $event.target.getBoundingClientRect()">
                            Table of Contents
                        </button>
                        <!-- Modal -->
                        <div x-show="showModal"
                             class="fixed z-10 bottom-16 right-0 w-3/5 bg-white h-1/2 overflow-y-auto shadow-xl rounded-l-xl max-w-[240px]"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             @click.away="showModal = false">
                            <div class="table_contents bg-white p-6">
                                <h3 class="text-lg my-4 font-semibold">Table of Contents</h3>
                                <!-- Modal content -->
                                {!! $docTrans->table_contents !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{--  Content  --}}
            <div class="space-y-6 max-w-[960px] mx-auto bg-white">
                <h3 class="font-bold text-3xl text-primary.main">
                    Content
                </h3>
                @if(!$hasBought)
                    <div id="document-content" class="relative">
                        {!! $docTrans->preview_content !!}
                        <div class="h-40 w-full absolute bottom-0"
                             style="background: linear-gradient(360deg, #FFFFFF 0%, rgba(245, 246, 250, 0.1) 100%);">
                        </div>
                    </div>
                    <div class="flex flex-col items-center space-y-3">
                        <form method="post" action="/course/direct-payment">
                            @csrf
                            <input class="hidden" type="number" name="item_id" value="{{$course->id}}">
                            <input class="hidden" type="text" name="item_name" value="webinar_id">
                            <button class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                                <span>Read more ({{handlePrice($course->price)}})</span>
                                <x-component.material-icon name="arrow_downward"/>
                            </button>
                        </form>
                        <p class="font-normal text-sm text-text.light.secondary">
                            Documents cannot be previewed. To view them in full, you need to pay a fee
                        </p>
                    </div>
                @else
                    <div id="document-content" style="overflow: hidden; max-width: 100vw !important;">
                        {!! $docTrans->content !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.home-layout>