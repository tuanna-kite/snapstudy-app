<section id="footer-banner" class="w-full flex justify-center">
    <div class="py-8 md:py-0 relative flex-1 flex justify-between flex-col md:flex-row items-center lg:rounded-2xl px-10 bg-primary.light"
        style="max-width: 1200px">
        <div class="flex flex-col md:w-3/5 w-full">
            <h3 class="text-primary.main text-2xl font-semibold">
                {{ trans('home.Get ahead to achieve') }}
            </h3>
            <p class="my-6 text-primary.main">
                {!! trans('home.Sign up now to receive a FREE TRIAL') !!}
            </p>
            <a href="{{ route('register') }}">
                <button class="bg-primary.main text-white rounded-full px-6 h-12 max-w-60 uppercase">
                    {{ trans('home.REGISTER FOR FREE') }}
                </button>
            </a>
        </div>
        <div class="w-full mt-5 hidden md:mt-0 md:w-fit sm:flex sm:justify-center md:justify-end">
            <img class="w-9/12 md:w-full" style="max-width: 360px; height: 100%"
                src="{{ asset('assets/default/image/footer-3d.png') }}" alt="footer-3d" />
        </div>
    </div>
</section>
