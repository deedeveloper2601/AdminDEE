<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Table,
    Sparkles,
    CheckCircle2,
    Clock
} from 'lucide-vue-next';

const configStore = useConfigStore();

const projects = ref([
    { id: 1, name: 'Main API Core Compactions', progress: 85, status: 'In Progress', team: 'Backend Devs' },
    { id: 2, name: 'European Cluster Integrations', progress: 100, status: 'Completed', team: 'Infra DevOps' },
    { id: 3, name: 'SaaS Client Checkout Portal', progress: 42, status: 'In Progress', team: 'Frontend Core' },
    { id: 4, name: 'Structural Audit Telemetry', progress: 0, status: 'Pending', team: 'QA Automation' }
]);
</script>

<template>
    <Head title="Premium UI Components — Simple Tables" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Table class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Simple Grid Tables</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Striped grid listings displaying project milestones and process meters.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-4xl mx-auto">
            <Card>
                <template #title>Corporate Projects Milestones</template>
                <template #subtitle>Standard project trackers showing percentage indices.</template>

                <!-- Table wrapper -->
                <div class="overflow-x-auto w-full mt-4">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-150 dark:border-gray-800 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                                <th class="pb-3.5 pl-2">Project Name</th>
                                <th class="pb-3.5">Assigned Team</th>
                                <th class="pb-3.5 text-center">Status Flag</th>
                                <th class="pb-3.5 pr-2">Progress Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-850">
                            <tr v-for="proj in projects" :key="proj.id" class="hover:bg-gray-50/30 dark:hover:bg-gray-950/20 transition duration-150">
                                <td class="py-4 pl-2 font-extrabold text-gray-900 dark:text-white">{{ proj.name }}</td>
                                <td class="py-4 text-gray-650 dark:text-gray-400 font-semibold">{{ proj.team }}</td>
                                <td class="py-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold border"
                                        :class="{
                                            'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20': proj.status === 'Completed',
                                            'bg-indigo-500/10 text-indigo-700 dark:text-indigo-400 border-indigo-500/20': proj.status === 'In Progress',
                                            'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700': proj.status === 'Pending'
                                        }"
                                    >
                                        {{ proj.status }}
                                    </span>
                                </td>
                                <td class="py-4 pr-2">
                                    <div class="flex items-center gap-2.5 min-w-[120px]">
                                        <div class="w-20 bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500" 
                                                :class="proj.progress === 100 ? 'bg-emerald-500' : configStore.accentDetails.bg"
                                                :style="{ width: proj.progress + '%' }"
                                            ></div>
                                        </div>
                                        <span class="font-mono font-bold text-[10px] text-gray-700 dark:text-gray-300">{{ proj.progress }}%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
