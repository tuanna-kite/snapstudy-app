@extends('layouts.index')
@section('title', 'Course Detail')

@section('content')
    <x-layouts.home-layout>
        <div class="py-20 bg-primary.light">
            <div class="container mx-auto space-y-6 ">
                <h1 class="font-normal text-3xl text-text.light.primary">
                    RMIT University
                </h1>
                <h2 class="font-extrabold text-5xl text-primary.main">
                    Assignment 3: Individual Essay
                </h2>
                <p class="font-normal text-base text-text.light.primary">
                    Lorem ipsum dolor sit amet consectetur. Pulvinar maecenas amet adipiscing amet eget. Vitae purus
                    volutpat
                    lacus eget eget mollis nam sit leo. Massa ullamcorper sed sollicitudin egestas amet odio tincidunt
                    ac.
                    Dictum sagittis mauris ultrices felis duis sed. Lobortis semper cursus ultrices nam at nibh nunc
                    amet.
                    Faucibus urna at pellentesque feugiat id arcu ipsum. Morbi quam maecenas vulputate sagittis rhoncus.
                </p>

                <p class="font-normal text-base text-text.light.primary">
                    <span class="font-semibold">1.332.107 </span> đã đăng ký
                </p>
            </div>
        </div>
        <div class='container mx-auto py-16 space-y-16' x-data="{ scrolled: false }"
            @scroll.window="scrolled = (window.scrollY > document.getElementById('targetDiv').offsetTop + document.getElementById('targetDiv').offsetHeight)">
            {{-- Table Content --}}
            <div x-data="{ openTab: 1 }" id="targetDiv" class="bg-white">
                <div class="border border-grey-300 rounded-2xl">
                    <div class="px-6 py-3 bg-primary.main rounded-t-2xl flex justify-between items-center text-white"
                        x-on:click="openTab !== 1 ? openTab = 1 : openTab = null">
                        <h6 class="font-bold text-xl">
                            Table of contents
                        </h6>
                        <x-component.material-icon name="expand_more" x-show="openTab === null" />
                        <x-component.material-icon name="expand_less" x-show="openTab === 1" />
                    </div>
                    <div class="px-6 py-4" x-show="openTab === 1">
                        <ol class="list-none list-inside space-y-2">
                            <li>
                                <a href="#" class="font-normal text-base text-primary.main">
                                    Assessment Recap
                                </a>
                            </li>
                            <li>
                                <a href="#" class="font-normal text-base text-primary.main">
                                    Definition
                                </a>
                            </li>
                            <li>
                                <a href="#" class="font-normal text-base text-primary.main">
                                    Detail outline
                                </a>
                            </li>
                            <li>
                                <a href="#" class="font-normal text-base text-primary.main">
                                    Assessment Conclusion
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            {{-- Mini Btn  --}}
            <div x-show='scrolled'>
                <x-pages.course-detail.button-cnt/>
            </div>
            {{-- <button id="scrollBtn" class="fixed z-10 bottom-4 right-4 px-4 py-2 rounded bg-gray-800 text-white shadow-md;"
                x-show="scrolled">Table of Content</button> --}}
            {{-- Content --}}
            <div class="space-y-6">
                <h3 class="font-bold text-3xl text-primary.main">
                    Content
                </h3>
                <ol class="space-y-6 relative">
                    <li class="space-y-4">
                        <h4 class="font-bold text-xl text-primary.main">
                            I. Assessment Recap
                        </h4>
                        <p class="font-normal text-base">
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                        </p>
                    </li>
                    <li class="space-y-4">
                        <h4 class="font-bold text-xl text-primary.main">
                            II. Definition
                        </h4>
                        <p class="font-normal text-base">
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.

                            Lorem ipsum dolor sit amet consectetur. Ut leo eget ut ultricies vitae tempus est. Elit a eu
                            fermentum eu nibh elit euismod. Nibh tristique eleifend varius tellus curabitur mi.
                            Ullamcorper
                            nascetur nisi amet tempor in nulla nisi. Egestas vel venenatis bibendum venenatis. Aliquam
                            in
                            dui ultricies tortor.
                        </p>
                    </li>
                    <div class="h-32 w-full absolute bottom-0"
                        style="background: linear-gradient(360deg, #F5F6FA 0%, rgba(245, 246, 250, 0) 100%);">
                    </div>
                </ol>

                <div class="flex flex-col items-center space-y-3">
                    <a href="#" class="rounded-lg py-3 px-5 text-white bg-primary.main flex gap-2">
                        <span>
                            Read more (200.000VND)
                        </span>
                        <x-component.material-icon name="arrow_downward" />
                    </a>
                    <p class="font-normal text-sm text-text.light.secondary">
                        Documents cannot be previewed. To view them in full, you need to pay a fee
                    </p>
                </div>
            </div>
        </div>

    </x-layouts.home-layout>
@endsection
