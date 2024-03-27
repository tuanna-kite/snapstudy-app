<div x-data="{ activeTab: 1 }" class="rounded-3xl bg-white">
    <!-- Tab Buttons -->
    <nav class="rounded-t-3xl flex border-b border-gray-300 px-6">
        <button @click="activeTab = 1" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    1,
                'text-text.light.secondary': activeTab !== 1
            }">All</button>
        <button @click="activeTab = 2" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    2,
                'text-text.light.secondary': activeTab !== 2
            }">In
            Progress</button>
        <button @click="activeTab = 3" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    3,
                'text-text.light.secondary': activeTab !== 3
            }">Completed</button>
    </nav>

    <!-- Tab Content -->
    {{ $slot }}
</div>
