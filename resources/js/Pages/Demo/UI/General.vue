<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Component,
    Sparkles,
    AlertCircle,
    CheckCircle2,
    Info,
    XCircle,
    TrendingUp
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Tab state
const activeTab = ref('analytics');
</script>

<template>
    <Head title="Premium UI Components — General Elements" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Component class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">General UI Elements</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Standard alerts, badge structures, progress bars, and dynamic tab cards.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-5xl mx-auto">
            <!-- Grid 1: Alerts & Badges -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Alerts Block -->
                <Card>
                    <template #title>Premium Dynamic Alerts</template>
                    <template #subtitle>Standard responsive info bars displaying context alerts.</template>

                    <div class="flex flex-col gap-3.5 pt-3">
                        <!-- Success Alert -->
                        <div class="flex items-start gap-3 p-3.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-800 dark:text-emerald-400 rounded-2xl">
                            <CheckCircle2 class="h-5 w-5 shrink-0 mt-0.5" />
                            <div class="flex flex-col gap-0.5 text-xs">
                                <span class="font-bold">Transaction Confirmed</span>
                                <p class="leading-normal">Your payment has been cleared by the checkout vendor successfully.</p>
                            </div>
                        </div>

                        <!-- Warning Alert -->
                        <div class="flex items-start gap-3 p-3.5 bg-amber-500/10 border border-amber-500/20 text-amber-800 dark:text-amber-400 rounded-2xl">
                            <AlertCircle class="h-5 w-5 shrink-0 mt-0.5" />
                            <div class="flex flex-col gap-0.5 text-xs">
                                <span class="font-bold">Storage Drive Warning</span>
                                <p class="leading-normal">Server cluster disk limit at 92% capacity threshold limit.</p>
                            </div>
                        </div>

                        <!-- Danger Alert -->
                        <div class="flex items-start gap-3 p-3.5 bg-rose-500/10 border border-rose-500/20 text-rose-800 dark:text-rose-400 rounded-2xl">
                            <XCircle class="h-5 w-5 shrink-0 mt-0.5" />
                            <div class="flex flex-col gap-0.5 text-xs">
                                <span class="font-bold">Handshake Protocol Failure</span>
                                <p class="leading-normal">SSL handshake validation refused for regional database cluster A.</p>
                            </div>
                        </div>
                    </div>
                </Card>

                <!-- Badges Block -->
                <Card>
                    <template #title>Badge & Chip Registry</template>
                    <template #subtitle>Status tags and metrics indicators.</template>

                    <div class="flex flex-wrap gap-3 pt-4">
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/10">Indigo Primary</span>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/10">Emerald Success</span>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/10">Amber Warning</span>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/10">Rose Danger</span>
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-bold bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/10">Cyan Telemetry</span>
                        
                        <div class="w-full border-t border-gray-55/10 my-2"></div>
                        
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-extrabold bg-gray-900 text-white dark:bg-white dark:text-gray-950 shadow-sm">Solid Badge</span>
                        <span class="px-2.5 py-1 rounded-full text-[9px] font-extrabold bg-accent text-white shadow-sm flex items-center gap-1">
                            <Sparkles class="h-3 w-3" /> Featured Icon
                        </span>
                    </div>
                </Card>
            </div>

            <!-- Grid 2: Progress bars and Tabs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Progress Indicators -->
                <Card>
                    <template #title>Telemetry Load Indicators</template>
                    <template #subtitle>Progress meters showing process scales.</template>

                    <div class="flex flex-col gap-4 pt-3 text-xs">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between font-bold text-[10px] text-gray-500 uppercase tracking-wider">
                                <span>Main CPU Utilization</span>
                                <span>65%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: 65%"></div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between font-bold text-[10px] text-gray-500 uppercase tracking-wider">
                                <span>Database Disk Sectors</span>
                                <span>82%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: 82%"></div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between font-bold text-[10px] text-gray-500 uppercase tracking-wider">
                                <span>Bandwidth Throughput</span>
                                <span>45%</span>
                            </div>
                            <div class="w-full bg-gray-100 dark:bg-gray-800 h-2 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500 animate-pulse" style="width: 45%"></div>
                            </div>
                        </div>
                    </div>
                </Card>

                <!-- Dynamic tab components -->
                <Card>
                    <template #title>Interactive Tab Cards</template>
                    <template #subtitle>Dynamic view selections displaying nested contents.</template>

                    <!-- Tab Buttons row -->
                    <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-950 border border-gray-200/60 dark:border-gray-850 p-1 rounded-2xl w-full my-3">
                        <button 
                            @click="activeTab = 'analytics'"
                            class="flex-1 py-2 rounded-xl text-[10px] font-extrabold transition-all"
                            :class="activeTab === 'analytics' ? 'bg-white dark:bg-gray-900 text-gray-950 dark:text-white shadow-sm' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                        >
                            Business Data
                        </button>
                        <button 
                            @click="activeTab = 'security'"
                            class="flex-1 py-2 rounded-xl text-[10px] font-extrabold transition-all"
                            :class="activeTab === 'security' ? 'bg-white dark:bg-gray-900 text-gray-950 dark:text-white shadow-sm' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300'"
                        >
                            Firewall Logs
                        </button>
                    </div>

                    <!-- Dynamic panels content -->
                    <div class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed pt-2">
                        <div v-show="activeTab === 'analytics'" class="flex flex-col gap-2.5 animate-fade-in">
                            <span class="font-bold text-gray-900 dark:text-white flex items-center gap-1.5"><TrendingUp class="h-4.5 w-4.5 text-emerald-500" /> Revenue ledger statistics normal</span>
                            <p>Daily aggregates indicate positive transaction cycles. Growth parameters align with quarterly performance projections.</p>
                        </div>
                        <div v-show="activeTab === 'security'" class="flex flex-col gap-2.5 animate-fade-in">
                            <span class="font-bold text-gray-900 dark:text-white flex items-center gap-1.5"><AlertCircle class="h-4.5 w-4.5 text-indigo-500" /> Ports sweep trace normal</span>
                            <p>Regional firewall modules successfully processed 14,240 socket requests. Zero intrusions reported by active telemetry nodes.</p>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
