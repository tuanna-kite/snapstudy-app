@props(['trending', 'subject'])

<article class="flex flex-col flex-1 shadow-lg px-5 py-6 rounded-2xl bg-white space-y-4">
{{--    <a class="text-primary.main p-2 bg-primary.lighter w-fit rounded-md">{{ !empty($subject) ? $subject->title :$trending->category->title }}</a>--}}
    <p class="flex items-center space-x-2">
        <img src="{{ !empty($subject) ? $subject->category->icon : asset('img/logo/rmit-logo.png') }}" alt="rmit-logo" width="40px" height="40px">
        <span class="font-semibold text-sm text-text.light.primary">{{ !empty($subject) ? $subject->category->title : '' }}</span>
    </p>
    <a href="{{ !empty($subject) ? $subject->slug : $trending->getUrl() }}"
        class="text-primary.main font-semibold text-lg uppercase line-clamp-3">{{ !empty($subject) ? $subject->title : clean($trending->title, 'title') }}</a>
    <p class="text-text.light.primary text-sm line-clamp-3">
        {{ !empty($subject) ? $subject->getDescriptionAttribute('description') :$trending->seo_description }}
    </p>
</article>
