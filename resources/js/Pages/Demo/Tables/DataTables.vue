<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import AdvancedTable from '@/Components/AdvancedTable.vue';
import { 
    Table,
    Search,
    Download,
    CheckCircle2
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Advanced client datasets
const clients = ref([
    { id: 'CLI-8490', name: 'Sophia Sterling', email: 'sophia@sterling.com', plan: 'Enterprise', status: 'Active' },
    { id: 'CLI-8491', name: 'Alexander Vance', email: 'alexander@vance.com', plan: 'SaaS License', status: 'Active' },
    { id: 'CLI-8492', name: 'Elena Rostova', email: 'elena@rostova.com', plan: 'Consulting', status: 'Inactive' },
    { id: 'CLI-8493', name: 'Marcus Thorne', email: 'marcus@thorne.com', plan: 'SaaS License', status: 'Suspended' },
    { id: 'CLI-8494', name: 'Leila Vasquez', email: 'leila@vasquez.com', plan: 'Enterprise', status: 'Active' }
]);

const columns = [
    { key: 'id', label: 'Client ID', sortable: true, align: 'left' },
    { key: 'name', label: 'Name', sortable: true, align: 'left' },
    { key: 'email', label: 'Email Address', sortable: true, align: 'left' },
    { key: 'plan', label: 'License Plan', sortable: true, align: 'left' },
    { key: 'status', label: 'Status Node', sortable: true, align: 'center' }
];

// Toast notification for copy export
const showToast = ref(false);
const triggerExport = () => {
    showToast.value = true;
    setTimeout(() => {
        showToast.value = false;
    }, 3500);
};
</script>

<template>
    <Head title="Premium UI Components — Advanced DataTables" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Table class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Interactive DataTables</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Interactive registry with live sorting indicators, fuzzy searches, and single-click CSV ledger exports.</span>
                    </div>
                </div>
                <button 
                    @click="triggerExport"
                    class="flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-gray-950 dark:hover:text-white transition shadow-sm"
                >
                    <Download class="h-3.5 w-3.5" />
                    <span>Export CSV</span>
                </button>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-5xl mx-auto">
            <Card>
                <template #title>Corporate Client Directory</template>
                <template #subtitle>Sort parameters, toggle checkboxes, and filter fields dynamically.</template>

                <!-- AdvancedTable component -->
                <div class="mt-4">
                    <AdvancedTable 
                        :columns="columns" 
                        :rows="clients"
                        selectable
                    >
                        <template #col-status="{ val }">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border"
                                :class="{
                                    'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20': val === 'Active',
                                    'bg-gray-150 text-gray-650 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700': val === 'Inactive',
                                    'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/20': val === 'Suspended'
                                }"
                            >
                                {{ val }}
                            </span>
                        </template>
                    </AdvancedTable>
                </div>
            </Card>
        </div>

        <!-- Success Toast -->
        <Transition
            enter-active-class="transform transition ease-out duration-300"
            enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showToast"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl shadow-black/5"
            >
                <CheckCircle2 class="h-5 w-5 text-emerald-500 shrink-0" />
                <span class="text-xs font-bold">Ledger exported successfully! Client file catalog saved.</span>
            </div>
        </Transition>
    </AdminLayout>
</template>
