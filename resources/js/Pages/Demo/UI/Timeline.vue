<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Clock,
    Sparkles,
    Database,
    ShieldCheck,
    Cpu,
    UserPlus,
    Calendar,
    Filter
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Dynamic Filter
const selectedCategory = ref('all');

const timelineEvents = ref([
    { id: 1, type: 'success', category: 'system', title: 'Telemetry Node Handshake', desc: 'Secure connection established with European cluster node B.', time: '10:45 AM', date: 'May 25, 2026', icon: Database },
    { id: 2, type: 'info', category: 'security', title: 'SSL Cert Renewal', desc: 'Certificates successfully renewed for api.admindee.io domain.', time: '09:15 AM', date: 'May 25, 2026', icon: ShieldCheck },
    { id: 3, type: 'success', category: 'users', title: 'New Admin Partner', desc: 'Alexander Vance was approved as structural workspace administrator.', time: '05:34 PM', date: 'May 24, 2026', icon: UserPlus },
    { id: 4, type: 'warning', category: 'system', title: 'Cluster Load Compaction', desc: 'Garbage collector initialized active compaction of database sector 2.', time: '11:20 AM', date: 'May 24, 2026', icon: Cpu }
]);

const filteredEvents = computed(() => {
    if (selectedCategory.value === 'all') return timelineEvents.value;
    return timelineEvents.value.filter(ev => ev.category === selectedCategory.value);
});
</script>

<template>
    <Head title="Premium UI Components — System Timeline" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Clock class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">System Audit Timeline</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke dynamic list tracking chronological system parameters and user registers.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6 max-w-4xl mx-auto">
            <!-- Filter Row -->
            <div class="flex items-center justify-between bg-white/70 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-900 p-4 rounded-2xl shadow-sm">
                <span class="text-xs font-bold text-gray-700 dark:text-gray-300 flex items-center gap-1.5"><Filter class="h-5 w-5 text-accent animate-pulse" /> Filter Events Category:</span>
                <div class="flex gap-1.5">
                    <button 
                        v-for="cat in ['all', 'system', 'security', 'users']" 
                        :key="cat"
                        @click="selectedCategory = cat"
                        class="px-3.5 py-1.5 rounded-xl text-[10px] font-bold transition duration-200 capitalize border"
                        :class="selectedCategory === cat ? 'bg-accent text-white border-accent' : 'border-gray-100 dark:border-gray-800 text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-950/45 hover:text-gray-900'"
                    >
                        {{ cat }}
                    </button>
                </div>
            </div>

            <!-- Timeline Box -->
            <Card>
                <template #title>Interactive Telemetry Trails</template>
                <template #subtitle>Chronological cluster events filtered dynamically.</template>

                <!-- Vertical line container -->
                <div class="relative pl-8 space-y-6 border-l border-gray-150 dark:border-gray-800/80 ml-4 pt-4 pb-2 mt-4">
                    <div 
                        v-for="ev in filteredEvents" 
                        :key="ev.id"
                        class="relative flex items-start gap-4 text-xs animate-fade-in"
                    >
                        <!-- Timeline circle node -->
                        <span 
                            class="absolute -left-[38px] top-1.5 h-5 w-5 rounded-full border-2 border-white dark:border-gray-950 flex items-center justify-center shrink-0 shadow-sm"
                            :class="{
                                'bg-emerald-500 text-white': ev.type === 'success',
                                'bg-blue-500 text-white': ev.type === 'info',
                                'bg-amber-500 text-white': ev.type === 'warning'
                            }"
                        >
                            <component :is="ev.icon" class="h-3 w-3 stroke-[2.5]" />
                        </span>

                        <!-- Event card -->
                        <div class="flex-1 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/50 rounded-2xl p-4 flex flex-col gap-2 transition hover:bg-gray-50 dark:hover:bg-gray-950/40 hover:border-gray-200 dark:hover:border-gray-800 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-sm text-gray-900 dark:text-white">{{ ev.title }}</span>
                                    <span class="px-2 py-0.2 rounded border text-[8px] font-bold uppercase"
                                        :class="{
                                            'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20': ev.category === 'system',
                                            'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20': ev.category === 'security',
                                            'bg-purple-500/10 text-purple-600 dark:text-purple-400 border-purple-500/20': ev.category === 'users'
                                        }"
                                    >
                                        {{ ev.category }}
                                    </span>
                                </div>
                                <span class="text-[10px] text-gray-400 font-semibold flex items-center gap-1"><Calendar class="h-3.5 w-3.5" /> {{ ev.date }} @ {{ ev.time }}</span>
                            </div>
                            <p class="text-xs text-gray-650 dark:text-gray-400 leading-relaxed">{{ ev.desc }}</p>
                        </div>
                    </div>

                    <div v-if="filteredEvents.length === 0" class="text-center py-6 text-xs text-gray-400 font-semibold italic">
                        No telemetry events registered under the "{{ selectedCategory }}" category.
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
