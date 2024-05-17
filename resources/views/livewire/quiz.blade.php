@php
    // dd($answers);
@endphp

<div>
    {{-- Btn Popup --}}
    <x-pages.question-detail.btn-popup :data="$data" />

    <div>
        <h3 class="font-bold text-3xl text-primary.main mb-6">
            Questions - 120/120
        </h3>
        {{-- Question --}}
        <div class="space-y-6">
            <div class="space-y-8">
                @foreach ($data as $key => $item)
                    <div class="space-y-4">
                        <p class="font-bold text-lg text-text.light.primary">
                            Questions {{ $key + 1 }}: {{ $item['ques'] }}
                        </p>
                        <div class="space-y-4">
                            @foreach ($item['choices'] as $index => $choice)
                                <div class="flex gap-2 items-start">
                                    <input type="radio" name="question_{{ $key }}" value="{{ $index }}"
                                        wire:model="answers.{{ $key }}" class="w-6 h-6 aspect-square">
                                    <div class="flex gap-2">
                                        <p class="font-semibold text-text.light.primary">
                                            {{ $orderType[$index] }}.
                                        </p>
                                        <label for="question_{{ $key }}_option_{{ $index }}"
                                            class="font-normal text-base text-text.light.primary">
                                            {{ $choice }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="py-6 border-t border-grey-300">
                <button type="button" wire:click="btnClick"
                    class="rounded-xl bg-primary.main px-5 py-2.5 flex items-center gap-2 active:opacity-95">
                    <span class="text-white text-sm font-medium">
                        Submit
                    </span>
                    <x-component.material-icon name="arrow_forward" class="text-white w-6 h-6 aspect-square" />
                </button>
            </div>
        </div>
    </div>
</div>
