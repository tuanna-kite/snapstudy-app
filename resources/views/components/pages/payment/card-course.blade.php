
<div class="rounded-3xl h-full bg-white shadow-lg">
    <div class="py-8 px-6 space-y-4">
{{--        <a class="text-primary.main p-2 bg-primary.lighter w-fit rounded-md">--}}
{{--            --}}{{-- {{ $trending->category->title }} --}}
{{--            Business Foundation--}}
{{--        </a>--}}
        <p class="flex items-center space-x-2">
            <img src="{{ asset('img/logo/rmit-logo.png') }}" alt="rmit-logo" width="40px" height="40px">
            <span class="font-semibold text-sm text-text.light.primary"> {{ $webinar->category->title }}</span>
        </p>
        <a href="#" class="text-primary.main font-semibold text-base uppercase line-clamp-3">
             {{ clean($webinar->title, 'title') }}
        </a>
        <p class="text-text.light.primary text-xs line-clamp-3">
             {{ $webinar->seo_description }}
        </p>
    </div>
    <hr class="border-t-1 border-gray-300 w-full">
    <div class="flex justify-between items-center p-6">
        <p class="font-bold text-lg text-text.light.primary">Total:</p>
        <p class="font-bold text-lg text-primary.main">
            {{ handlePrice($webinar->price) }}
        </p>
    </div>
</div>
