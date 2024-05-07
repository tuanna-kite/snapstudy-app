@php
    $inputs = [
        [
            'label' => trans('dashboard.Subject'),
            'name' => 'subject',
            'placeholder' => '',
            'value' => trans('course.Set up personalized editing support'),
            'disabled' => true,
        ],
        [
            'label' => trans('course.Syllabus support'),
            'name' => 'syllabus-support',
            'placeholder' => '',
            // TODO: Pass assignment name to key below
            'value' => 'Assignment Name',
            'disabled' => true,
        ],
        [
            'label' => trans('course.Your phone number'),
            'name' => 'phone',
            'placeholder' => trans('course.Enter your phone number'),
            'type' => 'number',
            'required' => true,
        ],
    ];

    $textarea = [
        'name' => 'message',
        'label' => trans('dashboard.Message'),
        'required' => true,
    ];
@endphp


<div x-data="{ showModal: false }" x-init="$watch('showModal', value => {
    document.body.style.overflow = value ? 'hidden' : 'auto';
})">
    <!-- Button to toggle the modal -->
    <button class="rounded-lg px-5 py-3 bg-secondary.main text-white hover:opacity-90" @click="showModal = true">
        <span class="font-medium text-sm">
            {{ trans('course.Send a personalization request') }}
        </span>
    </button>

    <!-- Modal -->
    <div id='modal' x-show="showModal"
        class="fixed h-screen w-screen z-10 top-0 left-1/2 -translate-x-1/2 flex items-center justify-center"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90"
        @click.away="showModal = false">
        <div class="fixed inset-0 bg-black opacity-50 z-10" @click="showModal = false"></div>
        <div id='contentmodal' class="bg-white p-6 space-y-4 w-full rounded-3xl shadow-lg max-w-2xl border z-20">
            <!-- Modal content -->
            <div class="flex items-start justify-between">
                <h1 class="text-primary.main font-bold text-xl sm:text-3xl">
                    {{trans('course.Personalized 1-1')}}
                </h1>
                <button type="button" class="" @click="showModal = false">
                    <x-component.material-icon name='close' />
                </button>
            </div>
            <div class="bg-white rounded-2xl">
                <form class="space-y-4" action="{{ route('course.personalization') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @foreach ($inputs as $input)
                        <x-input.input-label :data="$input" />
                        @error($input['name'])
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @endforeach
                    <input class="hidden" type="number" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="order_type" value="personalization">
                    <x-input.textarea-label :data="$textarea" />
                    <div class="flex flex-col sm:flex-row justify-between items-end gap-4">
                        <x-input.file-label :extends_title="true" />
{{--                        <input type="file" id="file" name='attach' class=""  />--}}
                        <div class="flex sm:flex-col flex-row justify-between items-center w-full sm:w-fit">
                            <p class="font-semibold text-base text-secondary.main">
                                ({{ handlePrice(999000) }})
                            </p>
                            <input type="hidden" name="amount" value="999000">
                            <button type="submit" class="py-2 px-8 rounded-xl bg-secondary.main min-w-28">
                                <span class="font-medium text-sm text-white">
                                    {{trans('course.Send')}}
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
