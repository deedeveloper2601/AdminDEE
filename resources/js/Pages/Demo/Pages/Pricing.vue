<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Sparkles, 
    Check, 
    Zap,
    TrendingUp,
    ShieldCheck
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Billing state
const isYearly = ref(false);
</script>

<template>
    <Head title="Premium Subscription Pricing Tiers" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Zap class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Subscription Packages</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke subscription packages. Choose the billing frequency plan below.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-5xl mx-auto items-center">
            <!-- Billing frequency toggle switcher -->
            <div class="flex items-center gap-3 bg-white/70 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-900 p-1.5 rounded-2xl shadow-sm">
                <button 
                    @click="isYearly = false"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200"
                    :class="!isYearly ? 'bg-accent text-white shadow' : 'text-gray-400 hover:text-gray-700'"
                >
                    Monthly Billing
                </button>
                <button 
                    @click="isYearly = true"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition duration-200"
                    :class="isYearly ? 'bg-accent text-white shadow' : 'text-gray-400 hover:text-gray-700'"
                >
                    Annual Billing (Save 20%)
                </button>
            </div>

            <!-- Tiers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                <!-- Tier 1: Hobby -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 flex flex-col justify-between shadow-sm hover:-translate-y-1 transition duration-300">
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block">Hobby Sandbox</span>
                        <div class="flex items-baseline">
                            <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white font-mono leading-none">{{ isYearly ? '$79' : '$99' }}</h3>
                            <span class="text-xs text-gray-400 font-semibold ml-1">/ year</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed font-semibold">Perfect for development sandbox testing nodes and basic API checks.</p>
                        
                        <div class="border-t border-gray-55/10 my-1"></div>

                        <div class="flex flex-col gap-2.5 text-xs text-gray-750 dark:text-gray-400">
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> 2 virtual load Cores</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> 5 GB storage limits</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> Weekly telemetry logs</span>
                        </div>
                    </div>
                    <button class="w-full py-3 rounded-2xl bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 hover:bg-gray-100/50 hover:text-gray-950 text-xs font-bold text-gray-650 transition mt-6">
                        Deploy Sandbox Node
                    </button>
                </div>

                <!-- Tier 2: Professional (Featured Accent) -->
                <div class="bg-white dark:bg-gray-900 border-2 border-accent rounded-3xl p-6 flex flex-col justify-between shadow-lg hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                    <span class="absolute right-0 top-0 px-3 py-1 bg-accent text-white font-extrabold text-[8px] uppercase tracking-wider rounded-bl-2xl">
                        Featured Tier
                    </span>
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-extrabold text-accent uppercase tracking-wider block">Professional Server</span>
                        <div class="flex items-baseline">
                            <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white font-mono leading-none">{{ isYearly ? '$199' : '$249' }}</h3>
                            <span class="text-xs text-gray-400 font-semibold ml-1">/ month</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed font-semibold">Perfect for active SaaS applications balancing production transactional checkout nodes.</p>
                        
                        <div class="border-t border-gray-55/10 my-1"></div>

                        <div class="flex flex-col gap-2.5 text-xs text-gray-750 dark:text-gray-400">
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> 8 virtual load Cores</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> 50 GB storage limits</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> Real-time active logs</span>
                        </div>
                    </div>
                    <button class="w-full py-3 rounded-2xl text-xs font-bold text-white transition-all shadow shadow-accent/15 mt-6" :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]">
                        Deploy Pro Cluster
                    </button>
                </div>

                <!-- Tier 3: Enterprise -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 flex flex-col justify-between shadow-sm hover:-translate-y-1 transition duration-300">
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider block">Enterprise Cloud</span>
                        <div class="flex items-baseline">
                            <h3 class="text-4xl font-extrabold text-gray-900 dark:text-white font-mono leading-none">{{ isYearly ? '$799' : '$999' }}</h3>
                            <span class="text-xs text-gray-400 font-semibold ml-1">/ month</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed font-semibold">Bespoke scaling plans. Dedicated instances handling unlimited database checkouts.</p>
                        
                        <div class="border-t border-gray-55/10 my-1"></div>

                        <div class="flex flex-col gap-2.5 text-xs text-gray-750 dark:text-gray-400">
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> Unlimited virtual Cores</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> 1 TB storage limits</span>
                            <span class="flex items-center gap-2"><Check class="h-4 w-4 text-emerald-500 stroke-[2.5]" /> SLA performance keys signed</span>
                        </div>
                    </div>
                    <button class="w-full py-3 rounded-2xl bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 hover:bg-gray-100/50 hover:text-gray-950 text-xs font-bold text-gray-650 transition mt-6">
                        Deploy Enterprise Cloud
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
