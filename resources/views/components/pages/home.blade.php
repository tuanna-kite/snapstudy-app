<div class="" style="height: 200vh">
    <x-layouts.navbar />
    <x-component.slide-section />
    {{--  --}}
    <div class="flex gap-8 p-12">
        <div class="w-3/4 flex flex-col">
            <div class="w-3/4 mx-auto">
                <x-search.search-doc />
            </div>
            <h1 class="font-bold text-3xl text-primary.main text-center mt-20 mb-12">
                Search for outlines that fit your major
            </h1>
            <x-majors.list />
            <h1 class="font-bold text-3xl text-primary.main text-center mt-24 mb-12">
                We have solutions for all your assessments and test questions
            </h1>
            <x-statistics.list />
        </div>
        <div class="w-1/4 flex flex-col gap-4">
            <img src="img/banner1.png" alt="banner1" class="max-w-96">
            <img src="img/banner2.png" alt="banner2" class="max-w-96">
        </div>
    </div>
    {{--  --}}
    <div>
        <x-component.video-tutorial />
    </div>
    {{--  --}}
    <div class="py-32 space-y-12 container mx-auto">
        <h1 class="font-bold text-3xl text-primary.main text-center uppercase">
            JUMPSTART YOUR SUCCESS <br />
            FOR THE UPCOMING ASSIGNMENT
        </h1>
        <x-assignments.slide />
    </div>
    {{--  --}}
    <div class="py-7 bg-primary.main">
        <div class="container mx-auto flex justify-between items-center">
            <p class="font-bold text-2xl text-white">
                SIGN UP NOW TO PURCHASE THE DETAILED <br />
                INSTRUCTION AT 199,000 VND
            </p>
            <a>
                <div class="rounded-full px-5 py-2 bg-secondary.main">
                    <span class="uppercase font-medium text-sm text-white">Sign up for free trial</span>
                </div>
            </a>
        </div>
    </div>
    {{--  --}}
    <div class="mt-24 space-y-10 container mx-auto">
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h1 class="font-bold text-3xl text-primary.main">
                    Start learning with Top Trending Outlines
                </h1>
                <a href="#" class="flex items-center">
                    <span class="font-medium text-sm text-text.light.secondary">View all
                    </span>
                    <x-component.icon name="icon-right" />
                </a>
            </div>
            <p class="font-normal text-base text-text.light.primary">
                Make a progress towards high scores by starting with the highest-voted outlines
            </p>
        </div>
        <div>
            <x-documents.document-grid />
        </div>
    </div>
    {{--  --}}
    <div class="mt-24 flex items-center justify-between container mx-auto">
        <div class="space-y-6 w-1/2">
            <h1 class="font-bold text-3xl text-primary.main">
                Students' Results <br /> with SNAPS
            </h1>
            <p class="font-normal text-base">
                <span class="font-bold text-3xl text-secondary.main">96%</span> of our customers said that they gained
                higher score and saved a lot of time when
                they use SNAPS to understand their assessment and come up with ideas
            </p>
        </div>
        <div class="w-1/2 flex justify-end">
            <img src="img/student.png" alt="student">
        </div>
    </div>
    {{-- Cummunity We are in --}}
    <div class="container mx-auto space-y-12 mt-24">
        <div class="text-center space-y-1">
            <h1 class="font-bold text-3xl text-primary.main text-center uppercase">
                The Community we are in
            </h1>
            <p class="font-normal text-base text-text.light.secondary">
                Over 3000 students have already joined the SNAPS Community
            </p>
        </div>
        <x-testimonials.list/>
    </div>
    <div class="my-32">
        <x-layouts.footer-banner/>
    </div>
    <x-layouts.footer />
</div>
