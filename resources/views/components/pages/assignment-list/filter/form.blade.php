@php
    $subject = [
        'Digital Marketing',
        'Professional Communication',
        'Logistics and Supply Chain',
        'Economics - Finance',
        'Economics',
        'Fashion Enterprise',
        'Management & Change',
        'People & Organisation',
        'Business-Foundation',
    ];
    $school = ['RMIT', 'VinUniversity', 'MIT', 'Yale', 'Harvard'];
    $checked = [
        'subject' => [],
        'school' => [],
    ];
@endphp

<div
    x-data='{
    subjectCheckboxes: {!! json_encode($subject) !!},
    schoolCheckboxes: {!! json_encode($school) !!},
    checkedItems: {!! json_encode($checked) !!},
    clearAll: function() {
        // Clear all values from both subject and school keys
        console.log("clear",this.checkedItems);
        this.checkedItems.subject = [];
        this.checkedItems.school = [];
    },
    submitValues: function() {
        console.log("submit",this.checkedItems); // Example: Output selected values to console
    }
}'>
    {{ $slot }}

    <!-- List of subject checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">Subject</h3>
    <template x-for="(checkbox, index) in subjectCheckboxes" :key="index">
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" class="bg-transparent" :value="checkbox" x-model="checkedItems.subject">
                <span x-text="checkbox" class="font-normal text-base text-text.light.primary"></span>
            </label>
        </div>
    </template>
    <!-- List of school checkboxes -->
    <h3 class="font-semibold text-base text-primary.main mt-6 mb-2">School</h3>
    <template x-for="(checkbox, index) in schoolCheckboxes" :key="index">
        <div class="mb-1">
            <label class="space-x-2">
                <input type="checkbox" class="bg-transparent" :value="checkbox" x-model="checkedItems.school">
                <span x-text="checkbox" class="font-normal text-base text-text.light.primary"></span>
            </label>
        </div>
    </template>

    <div class="mt-6">
        <button class="py-1.5 px-10 rounded-xl bg-primary.main text-white" @click="submitValues()">Apply</button>
    </div>
</div>
