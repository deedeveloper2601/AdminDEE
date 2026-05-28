<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Layout,
    Sparkles,
    CheckCircle2,
    ToggleLeft,
    ToggleRight,
    HelpCircle,
    Sliders,
    Monitor,
    Tv,
    FileText,
    Database
} from 'lucide-vue-next';

const configStore = useConfigStore();

// 7 Layout state settings mapped to Pinia global store
const topNav = computed(() => configStore.topNav);
const boxedLayout = computed(() => configStore.boxedLayout);
const fixedSidebar = computed(() => configStore.fixedSidebar);
const fixedNavbar = computed(() => configStore.fixedNavbar);
const fixedFooter = computed(() => configStore.fixedFooter);
const collapsedSidebar = computed(() => configStore.collapsedSidebar);
const lightSidebar = computed(() => configStore.lightSidebar);

const toggleSetting = (setting) => {
    configStore.toggleLayoutSetting(setting);
};
</script>

<template>
    <Head title="Premium Layout Customization Hub" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Layout class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Layout Workspace Hub</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Interactive controls for structural properties and responsive boxes.</span>
                    </div>
                </div>
                <span class="px-2.5 py-1 text-[10px] font-extrabold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 rounded-xl animate-pulse">
                    7 Active Properties
                </span>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto">
            <!-- Sidebar Controls list -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                <Card>
                    <template #title>
                        <span class="flex items-center gap-2 font-extrabold text-sm"><Sliders class="h-5 w-5 text-accent" /> Structural Settings</span>
                    </template>
                    <template #subtitle>Configure real-time container states below.</template>

                    <div class="flex flex-col gap-5 pt-3">
                        <!-- 1. Top Navigation -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">1. Top Navigation Only</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Disables vertical sidebar for horizontal routes.</p>
                            </div>
                            <button @click="toggleSetting('topNav')" class="text-accent focus:outline-none">
                                <component :is="topNav ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 2. Boxed Layout -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">2. Boxed Layout Mode</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Wraps main screen inside narrow container cards.</p>
                            </div>
                            <button @click="toggleSetting('boxedLayout')" class="text-accent focus:outline-none">
                                <component :is="boxedLayout ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 3. Fixed Sidebar -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">3. Fixed Sidebar Positioning</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Keeps vertical lists visible during viewport scrolling.</p>
                            </div>
                            <button @click="toggleSetting('fixedSidebar')" class="text-accent focus:outline-none">
                                <component :is="fixedSidebar ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 4. Fixed Navbar -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">4. Sticky Header Navbar</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Locks top action bar securely to screen boundary.</p>
                            </div>
                            <button @click="toggleSetting('fixedNavbar')" class="text-accent focus:outline-none">
                                <component :is="fixedNavbar ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 5. Fixed Footer -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">5. Fixed Base Footer</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Anchors dynamic copy indicators to bottom views.</p>
                            </div>
                            <button @click="toggleSetting('fixedFooter')" class="text-accent focus:outline-none">
                                <component :is="fixedFooter ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 6. Collapsed Sidebar -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">6. Collapsed Sidebar State</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Shrinks navigation items to dynamic icon badges.</p>
                            </div>
                            <button @click="toggleSetting('collapsedSidebar')" class="text-accent focus:outline-none">
                                <component :is="collapsedSidebar ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>

                        <!-- 7. Light Sidebar theme -->
                        <div class="flex items-center justify-between p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-gray-800 dark:text-gray-200">7. Light Sidebar Contrast</span>
                                <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-snug">Forces high-contrast light styling on sidebars.</p>
                            </div>
                            <button @click="toggleSetting('lightSidebar')" class="text-accent focus:outline-none">
                                <component :is="lightSidebar ? ToggleRight : ToggleLeft" class="h-8 w-8 stroke-[1.5]" />
                            </button>
                        </div>
                    </div>
                </Card>
            </div>

            <!-- Virtual Interactive Preview Mockup -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                <Card class="flex-1">
                    <template #title>
                        <span class="flex items-center gap-2 font-extrabold text-sm"><Monitor class="h-5 w-5 text-accent animate-pulse" /> Virtual Layout Render Mockup</span>
                    </template>
                    <template #subtitle>Real-time blueprint model reflecting your selections.</template>

                    <!-- Blueprint Wrapper -->
                    <div class="flex flex-col bg-gray-100 dark:bg-gray-950 rounded-2xl p-4 border border-gray-250/20 mt-4 min-h-[360px] relative transition-all duration-300"
                        :class="{ 'max-w-[420px] mx-auto': boxedLayout }"
                    >
                        <!-- Top Navbar mockup -->
                        <div 
                            class="h-10 border flex items-center justify-between px-4 transition duration-300"
                            :class="[
                                fixedNavbar ? 'sticky top-0 z-10' : '',
                                'bg-white dark:bg-gray-900 border-gray-200/50 dark:border-gray-800/80 rounded-xl shadow-sm'
                            ]"
                        >
                            <span class="text-[9px] font-extrabold" :class="configStore.accentDetails.text">Navbar Header</span>
                            <span class="text-[8px] font-bold text-gray-400">Search...</span>
                        </div>

                        <!-- Main Middle segment -->
                        <div class="flex-1 flex gap-3 mt-3 relative min-h-[220px]">
                            <!-- Sidebar mockup -->
                            <div 
                                v-if="!topNav"
                                class="border transition-all duration-300 rounded-xl p-3 flex flex-col gap-2 shadow-sm"
                                :class="[
                                    collapsedSidebar ? 'w-12' : 'w-28',
                                    lightSidebar ? 'bg-white text-gray-950 border-gray-150' : 'bg-gray-900 dark:bg-gray-900/60 text-white border-transparent'
                                ]"
                            >
                                <span class="text-[7px] font-extrabold text-gray-400">SIDEBAR</span>
                                <div class="h-5 flex items-center gap-1.5 rounded bg-white/10 dark:bg-white/5 border border-white/5"></div>
                                <div class="h-5 flex items-center gap-1.5 rounded bg-white/10 dark:bg-white/5 border border-white/5"></div>
                            </div>

                            <!-- Inside Main Content mockup -->
                            <div class="flex-1 flex flex-col gap-3">
                                <!-- Card 1 -->
                                <div class="bg-white dark:bg-gray-900 border border-gray-200/50 dark:border-gray-800/80 p-3 rounded-xl flex-1 flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[7px] font-bold text-gray-400">Ledger Metrics</span>
                                        <CheckCircle2 class="h-3 w-3 text-emerald-500" />
                                    </div>
                                    <h4 class="text-xs font-extrabold text-gray-900 dark:text-white leading-none">$42,392</h4>
                                </div>

                                <!-- Card 2 -->
                                <div class="bg-white dark:bg-gray-900 border border-gray-200/50 dark:border-gray-800/80 p-3 rounded-xl flex-1 flex flex-col justify-between shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[7px] font-bold text-gray-400">Telemetry Feed</span>
                                        <Database class="h-3 w-3 text-indigo-500" />
                                    </div>
                                    <h4 class="text-xs font-extrabold text-gray-900 dark:text-white leading-none">Online</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Footer mockup -->
                        <div 
                            class="h-8 border-t border-gray-200/50 dark:border-gray-800/80 flex items-center justify-between px-3 mt-3 text-[8px] text-gray-400"
                            :class="[ fixedFooter ? 'sticky bottom-0 bg-white dark:bg-gray-900 rounded-xl shadow-inner' : '' ]"
                        >
                            <span>© 2026 AdminDEE</span>
                            <span>v2.4.1</span>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
