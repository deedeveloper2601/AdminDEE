<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import * as LucideIcons from 'lucide-vue-next';
import { 
    Grid,
    Search,
    CheckCircle2,
    Sparkles
} from 'lucide-vue-next';

const configStore = useConfigStore();

// List of popular Lucide icons to display
const iconNamesList = [
    'LayoutDashboard', 'Palette', 'ToyBrick', 'Layout', 'Component', 'Mail', 'FileText', 'Table',
    'Files', 'ShieldLock', 'Users', 'WandSparkles', 'FolderTree', 'Circle', 'Search', 'Cpu',
    'Activity', 'TrendingUp', 'TrendingDown', 'ShoppingBag', 'CreditCard', 'Zap', 'MapPin', 'Smartphone',
    'Monitor', 'Tablet', 'Wifi', 'Terminal', 'CloudSun', 'Calendar', 'MessageSquare', 'Plus',
    'Check', 'User', 'Clock', 'Settings', 'Download', 'Phone', 'AlertCircle', 'CheckCircle2',
    'Info', 'XCircle', 'Play', 'Pause', 'Eye', 'Lock', 'Unlock', 'Key',
    'Heart', 'Star', 'Bell', 'Trash2', 'Edit', 'GripVertical', 'ChevronRight', 'ChevronDown'
];

const searchQuery = ref('');
const showCopyToast = ref(false);
const copiedIcon = ref('');

const filteredIcons = computed(() => {
    if (!searchQuery.value.trim()) return iconNamesList;
    const query = searchQuery.value.toLowerCase();
    return iconNamesList.filter(name => name.toLowerCase().includes(query));
});

const copyIconCode = (iconName) => {
    const code = `<component :is="${iconName}" class="h-5 w-5" />`;
    navigator.clipboard.writeText(code).then(() => {
        copiedIcon.value = iconName;
        showCopyToast.value = true;
        setTimeout(() => {
            showCopyToast.value = false;
        }, 3000);
    });
};
</script>

<template>
    <Head title="Premium UI Components — Searchable Icon Registry" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Grid class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Lucide Icon Registry</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Searchable registry of popular UI icons. Click to copy integration codes instantly.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6 max-w-5xl mx-auto">
            <!-- Search bar -->
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <Search class="h-4.5 w-4.5 text-gray-400" />
                </span>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search icons in real-time... (e.g. check, user, layout)"
                    class="w-full pl-11 pr-4 py-3 text-sm bg-white/70 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-900 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                    :class="[configStore.accentDetails.ring]"
                />
            </div>

            <!-- Icons Grid -->
            <Card>
                <template #title>Icon Catalogue ({{ filteredIcons.length }} registered)</template>
                <template #subtitle>Standard Lucide icon instances. Hover and click for code snippet copied to clipboard.</template>

                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4 pt-4">
                    <button
                        v-for="iconName in filteredIcons"
                        :key="iconName"
                        @click="copyIconCode(iconName)"
                        class="p-4 border border-gray-50 dark:border-gray-950 bg-gray-50/20 dark:bg-gray-950/10 hover:bg-accent/5 dark:hover:bg-accent/10 hover:border-accent/15 rounded-2xl flex flex-col items-center justify-center gap-3 transition-all group focus:outline-none"
                    >
                        <component 
                            :is="LucideIcons[iconName]" 
                            class="h-6 w-6 text-gray-500 dark:text-gray-400 group-hover:text-accent group-hover:scale-115 transition-all duration-200" 
                        />
                        <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500 group-hover:text-accent truncate w-full text-center">
                            {{ iconName }}
                        </span>
                    </button>
                </div>
            </Card>
        </div>

        <!-- Copy feedback toast -->
        <Transition
            enter-active-class="transform transition ease-out duration-300"
            enter-from-class="translate-y-4 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showCopyToast"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl shadow-black/5"
            >
                <CheckCircle2 class="h-5 w-5 text-emerald-500 shrink-0" />
                <span class="text-xs font-bold font-mono">Copied component code for: {{ copiedIcon }}</span>
            </div>
        </Transition>
    </AdminLayout>
</template>
