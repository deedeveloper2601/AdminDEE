<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { 
    FileText,
    Sparkles,
    Check,
    X,
    Calendar,
    Unlock,
    Key,
    Tag,
    ChevronDown
} from 'lucide-vue-next';

const configStore = useConfigStore();

// 1. Tag Chips state
const tags = ref(['SaaS', 'Cluster', 'API']);
const tagInput = ref('');
const addTag = () => {
    const val = tagInput.value.trim();
    if (val && !tags.value.includes(val)) {
        tags.value.push(val);
    }
    tagInput.value = '';
};
const removeTag = (t) => {
    tags.value = tags.value.filter(tag => tag !== t);
};

// 2. Autocomplete dropdown list
const query = ref('');
const items = ['London Cluster', 'New York Main', 'Paris Node-4', 'Tokyo Cluster-B', 'Sydney Node-2'];
const isSearchOpen = ref(false);
const filteredSearch = computed(() => {
    if (!query.value.trim()) return items;
    return items.filter(it => it.toLowerCase().includes(query.value.toLowerCase()));
});
const selectSearch = (it) => {
    query.value = it;
    isSearchOpen.value = false;
};

// 3. Password strength checking
const password = ref('');
const passwordStrength = computed(() => {
    const pwd = password.value;
    if (!pwd) return { score: 0, label: 'None', color: 'bg-gray-200' };
    
    let score = 0;
    if (pwd.length >= 8) score++;
    if (/[A-Z]/.test(pwd)) score++;
    if (/[0-9]/.test(pwd)) score++;
    if (/[^A-Za-z0-9]/.test(pwd)) score++;

    if (score === 1) return { score: 25, label: 'Weak', color: 'bg-rose-500' };
    if (score === 2) return { score: 50, label: 'Fair', color: 'bg-amber-500' };
    if (score === 3) return { score: 75, label: 'Good', color: 'bg-indigo-500' };
    if (score === 4) return { score: 100, label: 'Strong', color: 'bg-emerald-500' };
    return { score: 10, label: 'Very Weak', color: 'bg-rose-600' };
});
</script>

<template>
    <Head title="Premium UI Components — Advanced Forms" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <FileText class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Advanced Form Elements</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Tag chips collections, search autocomplete inputs, and visual password strength bar meters.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-4xl mx-auto">
            <!-- Bento form widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tag chips collection -->
                <Card>
                    <template #title>Interactive Tag Chips</template>
                    <template #subtitle>Type values and press enter to queue keyword tags.</template>

                    <div class="flex flex-col gap-3.5 pt-3">
                        <div class="flex flex-wrap gap-2.5 p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl min-h-[50px] items-center">
                            <span 
                                v-for="tag in tags" 
                                :key="tag"
                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[10px] font-bold bg-accent/10 text-accent border border-accent/15"
                            >
                                <span>{{ tag }}</span>
                                <button @click="removeTag(tag)" class="hover:text-rose-500 focus:outline-none shrink-0">
                                    <X class="h-3 w-3 stroke-[2.5]" />
                                </button>
                            </span>
                            <span v-if="tags.length === 0" class="text-[10px] text-gray-400 font-semibold italic">No tags registered...</span>
                        </div>

                        <form @submit.prevent="addTag" class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <Tag class="h-4 w-4 text-gray-400" />
                            </span>
                            <input 
                                v-model="tagInput"
                                type="text"
                                placeholder="Add custom tag keyword..."
                                class="w-full pl-10 pr-4 py-2.5 text-xs bg-white dark:bg-gray-950 border border-gray-100 dark:border-gray-900 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                                :class="[configStore.accentDetails.ring]"
                            />
                        </form>
                    </div>
                </Card>

                <!-- Autocomplete Dropdown Search -->
                <Card>
                    <template #title>Search Autocomplete</template>
                    <template #subtitle>Type queries to view suggestions registry.</template>

                    <div class="relative pt-3">
                        <input
                            v-model="query"
                            @focus="isSearchOpen = true"
                            type="text"
                            placeholder="Find target data center... (e.g. London, Paris)"
                            class="w-full px-4 py-3 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-900 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                            :class="[configStore.accentDetails.ring]"
                        />

                        <!-- suggestions list -->
                        <div 
                            v-if="isSearchOpen && filteredSearch.length > 0"
                            class="absolute w-full mt-2 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50 max-h-48 overflow-y-auto"
                        >
                            <button
                                v-for="it in filteredSearch"
                                :key="it"
                                @click="selectSearch(it)"
                                class="w-full px-4 py-2.5 text-xs text-left text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-accent font-semibold transition"
                            >
                                {{ it }}
                            </button>
                        </div>
                    </div>
                </Card>
            </div>

            <!-- Password strength validator -->
            <Card>
                <template #title>Password Strength telemetry check</template>
                <template #subtitle>Dynamic meter grading credential configurations.</template>

                <div class="flex flex-col gap-4 pt-3 text-xs max-w-lg">
                    <FloatingInput 
                        id="pwd_adv" 
                        v-model="password" 
                        label="Password Key Input" 
                        type="password"
                        required 
                    />

                    <!-- Strength progress bar -->
                    <div class="flex flex-col gap-1.5 mt-2">
                        <div class="flex justify-between font-bold text-[10px] text-gray-450 uppercase tracking-wider">
                            <span>Key Strength Index</span>
                            <span :class="passwordStrength.score > 50 ? 'text-emerald-500' : 'text-rose-500'">{{ passwordStrength.label }}</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-300" :class="[passwordStrength.color]" :style="{ width: passwordStrength.score + '%' }"></div>
                        </div>
                    </div>

                    <!-- Checklist guidelines -->
                    <div class="grid grid-cols-2 gap-2 mt-2 text-[10px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                        <span class="flex items-center gap-1.5" :class="{ 'text-emerald-500': password.length >= 8 }">
                            <Check class="h-3.5 w-3.5" /> 8+ Characters
                        </span>
                        <span class="flex items-center gap-1.5" :class="{ 'text-emerald-500': /[A-Z]/.test(password) }">
                            <Check class="h-3.5 w-3.5" /> Uppercase Hues
                        </span>
                        <span class="flex items-center gap-1.5" :class="{ 'text-emerald-500': /[0-9]/.test(password) }">
                            <Check class="h-3.5 w-3.5" /> Numerical Digits
                        </span>
                        <span class="flex items-center gap-1.5" :class="{ 'text-emerald-500': /[^A-Za-z0-9]/.test(password) }">
                            <Check class="h-3.5 w-3.5" /> Specialty Marks
                        </span>
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
