<footer class="bg-primary.light">
    <div>
        {{--  --}}
        <div class='flex flex-col gap-12 pt-12 md:flex-row container mx-auto'>
            <div class="flex-1">
                <a href="#">
                    <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
                </a>
                <ul class="mt-4 space-y-2">
                    <li class="text-sm font-semibold text-text.light.primary">
                        <a href="#">
                            {{ trans('footer.The service provides detailed outlines for all student assignments') }}
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a href="#">
                            {{ trans('footer.Hong Linh Education Investment and Development Joint Stock Company') }}
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a href="#">
                            {{ trans('footer.Address: 37 Xa Dan, Hanoi, Vietnam') }}
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a href="#">
                            Hotline: (024) 682213
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a href="#">
                            Email: honglinh.education@gmail.com
                        </a>
                    </li>
                    <li class="text-sm text-text.light.secondary">
                        <a target="_blank" href="https://snapstudy.co/">
                            Web: https://snapstudy.co/
                        </a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-1">
                <div class="flex-1 pt-4">
                    <span class="text-base font-semibold text-text.light.primary uppercase">
                        {{ trans('footer.Information') }}
                    </span>
                    <ul class="space-y-2 mt-3">
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.About') }}
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Outline') }}
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Contact') }}
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Promotion') }}
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Notification') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1 pt-4">
                    <span class="text-base font-semibold text-text.light.primary uppercase">
                        {{ trans('footer.Support') }}
                    </span>
                    <ul class="space-y-2 mt-3">
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Frequently asked questions') }}
                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Outline user manual') }}

                            </a>
                        </li>
                        <li class="text-sm font-medium text-text.light.secondary">
                            <a href="#">
                                {{ trans('footer.Payment Guide') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class='flex flex-col pt-4 pb-8 gap-12 md:flex-row container mx-auto'>
            <div class="flex-1">
                <img src="{{ asset('img/image-footer.png') }}" />
            </div>
            <div class="flex flex-1 items-start">
                <div class="flex-1 space-y-2">
                    <p class="uppercase text-sm text-text.light.secondary">
                        {{ trans('footer.Payment support') }}
                    </p>
                    <ul class="flex gap-3">
                        <li>
                            <img src="{{ asset('img/logo/momo-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                        <li>
                            <img src="{{ asset('img/logo/vnpay-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                        <li>
                            <img src="{{ asset('img/logo/visa-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                    </ul>
                </div>
                <div class="flex-1 space-y-2">
                    <p class="uppercase text-sm text-text.light.secondary">
                        {{ trans('footer.connect with us') }}
                    </p>
                    <ul class="flex gap-3">
                        <li>
                            <img src="{{ asset('img/logo/facebook-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                        <li>
                            <img src="{{ asset('img/logo/insta-footer.png') }}" alt=""
                                class="w-10 h-10 aspect-square">
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    </div>


    <div style="border-top:1px solid #637381">
        <div class="container mx-auto py-6">
            <div>
                <span class="text-sm font-medium text-text.light.secondary">
                    © 2024 Snaps. All rights reserved.
                </span>
            </div>
        </div>
    </div>
</footer>
