<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Layout,
    ChevronDown,
    X,
    Eye,
    TrendingUp,
    ShieldCheck,
    Cpu
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Interactive states
const isCard1Open = ref(true);
const isCard2Open = ref(true);
const isCard3Dismissed = ref(false);
</script>

<template>
    <Head title="Premium UI Components — Custom Bento Cards" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Layout class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Custom Bento & Glass Cards</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Visual blocks showing glassmorphism, responsive grids, and interactive collapsible panels.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6 max-w-5xl mx-auto">
            <!-- Row 1: Interactive collapsing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Collapsible card -->
                <div v-show="isCard1Open" class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-150 dark:border-gray-900 shadow-sm p-6 flex flex-col gap-3 transition-all duration-300">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-55/10">
                        <div class="flex flex-col">
                            <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Collapsible Content Block</h4>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Click arrow handle to hide body fields.</span>
                        </div>
                        <button 
                            @click="isCard2Open = !isCard2Open"
                            class="p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-850 transition focus:outline-none"
                        >
                            <ChevronDown class="h-4.5 w-4.5 transition-transform duration-300" :class="{ 'rotate-180 text-accent': isCard2Open }" />
                        </button>
                    </div>
                    <Transition
                        enter-active-class="transition duration-300 ease-out"
                        enter-from-class="max-h-0 opacity-0 overflow-hidden"
                        enter-to-class="max-h-40 opacity-100 overflow-hidden"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="max-h-40 opacity-100 overflow-hidden"
                        leave-to-class="max-h-0 opacity-0 overflow-hidden"
                    >
                        <div v-show="isCard2Open" class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed pt-2">
                            Structural card properties support dynamic toggling. You can collapse, restore, or dismiss these component boards instantly using custom reactive bindings.
                        </div>
                    </Transition>
                </div>

                <!-- Dismissible Card -->
                <div v-show="!isCard3Dismissed" class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-150 dark:border-gray-900 shadow-sm p-6 flex flex-col gap-3 transition-all duration-300">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-55/10">
                        <div class="flex flex-col">
                            <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Dismissible Dashboard Box</h4>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Tap close indicator to permanently hide.</span>
                        </div>
                        <button 
                            @click="isCard3Dismissed = true"
                            class="p-1 rounded-lg text-gray-400 hover:text-rose-600 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 transition focus:outline-none"
                        >
                            <X class="h-4.5 w-4.5" />
                        </button>
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed pt-2">
                        Clustering status reports indicates normal performance metrics across our server networks. No issues found.
                    </div>
                </div>
            </div>

            <!-- Row 2: Premium Glassmorphic Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-gradient-to-tr from-indigo-500/10 to-purple-500/15 border border-indigo-500/20 backdrop-blur-lg rounded-3xl p-6 flex flex-col justify-between h-44 shadow-sm group">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-indigo-500 uppercase tracking-wider">Secured Network</span>
                        <ShieldCheck class="h-5 w-5 text-indigo-500 animate-pulse" />
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900 dark:text-white">Aether Protocol Active</h4>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-normal">Data encryptions locked under dynamic JWT keys.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-gradient-to-tr from-emerald-500/10 to-teal-500/15 border border-emerald-500/20 backdrop-blur-lg rounded-3xl p-6 flex flex-col justify-between h-44 shadow-sm group">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-wider">System Yield</span>
                        <TrendingUp class="h-5 w-5 text-emerald-500" />
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900 dark:text-white">Optimal Processing Log</h4>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-normal">Telemetry metrics indicate zero package drop ratios.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-gradient-to-tr from-amber-500/10 to-yellow-500/15 border border-amber-500/20 backdrop-blur-lg rounded-3xl p-6 flex flex-col justify-between h-44 shadow-sm group">
                    <div class="flex items-center justify-between">
                        <span class="text-[9px] font-bold text-amber-500 uppercase tracking-wider">Process Nodes</span>
                        <Cpu class="h-5 w-5 text-amber-500" />
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900 dark:text-white">Active Virtual Cores</h4>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-normal">Cores 1-8 balancing client request handshakes.</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
