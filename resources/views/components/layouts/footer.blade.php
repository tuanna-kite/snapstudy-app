<footer class="bg-primary.light">
    <div class='flex flex-col gap-4 py-16 md:flex-row container mx-auto'>
        <div class="flex-1">
            <a href="#">
                <img src="{{ asset('img/logo/logo.png') }}" alt="Logo">
            </a>
            <ul class="mt-4">
                <li class="text-sm font-medium text-text.light.primary">
                    <a href="#">
                        {{ trans('footer.Company name') }}
                    </a>
                </li>
                <li class="text-sm font-medium text-text.light.primary">
                    <a href="#">
                        {{ trans('footer.Company number: 024682213') }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-1 pt-4">
            <span class="text-base font-semibold text-text.light.primary">
                SNAPS
            </span>
            <ul class="flex flex-col gap-2 mt-3">
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.About') }}
                    </a>
                </li>
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.What We Offer') }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-1 pt-4">
            <span class="text-base font-semibold text-text.light.primary">
                {{ trans('footer.MORE') }}
            </span>
            <ul class="flex flex-col gap-2 mt-3">
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.About') }}
                    </a>
                </li>
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.What We Offer') }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-1 pt-4">
            <span class="text-base font-semibold text-text.light.primary">
                {{ trans('footer.HELP') }}
            </span>
            <ul class="flex flex-col gap-2 mt-3">
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.Frequently asked questions') }}
                    </a>
                </li>
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.Terms of use') }}
                    </a>
                </li>
                <li class="text-sm font-medium text-text.light.secondary">
                    <a href="#">
                        {{ trans('footer.Regulations on document sales policy') }}
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
    <div style="border-top:1px solid #637381">
        <div class="container mx-auto py-6 flex flex-col-reverse items-center gap-4 md:justify-between md:flex-row">
            <div>
                <span class="text-sm font-medium text-text.light.secondary">
                    © 2024 Snaps. All rights reserved.
                </span>
            </div>
            <ul class="flex gap-4">
                <li>
                    <img src="{{ asset('img/logo/facebook.png') }}" alt="fb" width="32" height="32">
                </li>
                <li>
                    <img src="{{ asset('img/logo/youtube.png') }}" alt="fb" width="32" height="32">
                </li>
                <li>
                    <img src="{{ asset('img/logo/instagram.png') }}" alt="fb" width="32" height="32">
                </li>
            </ul>
        </div>
    </div>
</footer>
