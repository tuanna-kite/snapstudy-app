@props(['listTab'])

<div x-data="{ activeTab: 1 }" class="rounded-3xl bg-white">
    <!-- Tab Buttons -->
    <nav class="rounded-t-3xl flex px-6 py-4">
        <button @click="activeTab = 1" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    1,
                'text-text.light.secondary': activeTab !== 1
            }">{{ $listTab[0] }}</button>
        <button @click="activeTab = 2" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    2,
                'text-text.light.secondary': activeTab !== 2
            }">{{ $listTab[1] }}</button>
        <button @click="activeTab = 3" class="p-3  font-semibold text-sm"
            :class="{
                'border-b-2 border-primary.main text-text.light.primary': activeTab ===
                    3,
                'text-text.light.secondary': activeTab !== 3
            }">{{ $listTab[2] }}</button>
    </nav>

    <!-- Tab Content -->
    <div class="bg-white rounded-b-3xl">
        {{ $slot }}
        <div x-show="activeTab === 1" class="">
            <!-- Content for Tab 1 -->
            {{ $tab1 ?? '' }}
        </div>
        <div x-show="activeTab === 2" class="">
            <!-- Content for Tab 2 -->
            {{ $tab2 ?? '' }}
        </div>
        <div x-show="activeTab === 3" class="">
            <!-- Content for Tab 3 -->
            {{ $tab3 ?? '' }}
        </div>
    </div>
</div>
