<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import LineChart from '@/Components/LineChart.vue';
import AdvancedTable from '@/Components/AdvancedTable.vue';
import { 
    Sparkles, 
    TrendingUp, 
    TrendingDown, 
    Users, 
    DollarSign, 
    Activity, 
    Percent, 
    Clock, 
    ShieldAlert, 
    Database, 
    UserPlus, 
    MoreVertical, 
    ArrowUpRight, 
    Eye, 
    RefreshCw, 
    Trash2, 
    CheckCircle2 
} from 'lucide-vue-next';

const configStore = useConfigStore();

onMounted(() => {
    configStore.init();
});

// --- TOAST STATE ---
const toastMessage = ref('');
const showToast = ref(false);

const triggerToast = (msg) => {
    toastMessage.value = msg;
    showToast.value = true;
    setTimeout(() => {
        showToast.value = false;
    }, 4000);
};

// --- MOCK DATABASE TRANSACTIONS (10 Rows) ---
const transactionsRows = ref([
    { id: 'TXN-8491', customer: 'Sophia Sterling', email: 'sophia.sterling@example.com', date: 'May 25, 2026 17:34', amount: 1450.00, status: 'Completed' },
    { id: 'TXN-8492', customer: 'Alexander Vance', email: 'alexander.vance@example.com', date: 'May 25, 2026 16:12', amount: 890.50, status: 'Completed' },
    { id: 'TXN-8493', customer: 'Elena Rostova', email: 'elena.rostova@example.com', date: 'May 25, 2026 15:45', amount: 2450.00, status: 'Processing' },
    { id: 'TXN-8494', customer: 'Marcus Thorne', email: 'marcus.thorne@example.com', date: 'May 25, 2026 14:20', amount: 120.00, status: 'Failed' },
    { id: 'TXN-8495', customer: 'Leila Vasquez', email: 'leila.vasquez@example.com', date: 'May 24, 2026 19:10', amount: 3120.75, status: 'Completed' },
    { id: 'TXN-8496', customer: 'Julian Drake', email: 'julian.drake@example.com', date: 'May 24, 2026 18:05', amount: 450.00, status: 'Refunded' },
    { id: 'TXN-8497', customer: 'Zara Montgomery', email: 'zara.montgomery@example.com', date: 'May 24, 2026 15:30', amount: 1980.20, status: 'Completed' },
    { id: 'TXN-8498', customer: 'Oliver Sterling', email: 'oliver.sterling@example.com', date: 'May 24, 2026 11:15', amount: 620.00, status: 'Completed' },
    { id: 'TXN-8499', customer: 'Clara Oswald', email: 'clara.oswald@example.com', date: 'May 23, 2026 22:45', amount: 95.50, status: 'Failed' },
    { id: 'TXN-8500', customer: 'Nathaniel West', email: 'nathaniel.west@example.com', date: 'May 23, 2026 17:50', amount: 1350.00, status: 'Completed' },
]);

const transactionsColumns = [
    { key: 'id', label: 'Transaction ID', sortable: true, align: 'left' },
    { key: 'customer', label: 'Customer', sortable: true, align: 'left' },
    { key: 'date', label: 'Timestamp', sortable: true, align: 'left' },
    { key: 'amount', label: 'Amount', sortable: true, align: 'right' },
    { key: 'status', label: 'Status', sortable: true, align: 'center' },
    { key: 'actions', label: 'Actions', sortable: false, align: 'center' }
];

const activeDropdownRowId = ref(null);

const toggleActionsDropdown = (rowId) => {
    if (activeDropdownRowId.value === rowId) {
        activeDropdownRowId.value = null;
    } else {
        activeDropdownRowId.value = rowId;
    }
};

const triggerAction = (action, row) => {
    activeDropdownRowId.value = null;
    if (action === 'delete') {
        transactionsRows.value = transactionsRows.value.filter(r => r.id !== row.id);
        triggerToast(`Successfully deleted transaction ${row.id} for ${row.customer}.`);
    } else if (action === 'refund') {
        const tr = transactionsRows.value.find(r => r.id === row.id);
        if (tr) {
            tr.status = 'Refunded';
            triggerToast(`Refund process initiated for transaction ${row.id}.`);
        }
    } else {
        triggerToast(`Triggered "${action}" for transaction ${row.id} (${row.customer}).`);
    }
};

// Format currency helper
const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
};

// Selection Event Handlers for AdvancedTable
const handleSelectionChange = (selected) => {
    // Selection state matches rows
};

const handleBulkAction = (event) => {
    const { action, rows, ids } = event;
    const targetIds = ids || (rows ? rows.map(r => r.id) : []);
    const idsStr = targetIds.join(', ');
    
    if (action === 'delete') {
        const idsSet = new Set(targetIds);
        transactionsRows.value = transactionsRows.value.filter(row => !idsSet.has(row.id));
        triggerToast(`Successfully deleted bulk transactions: ${idsStr}`);
    } else if (action === 'export') {
        triggerToast(`Exporting data for ${targetIds.length} transactions (${idsStr}) to CSV.`);
    }
};

const handleRowClick = (row) => {
    triggerToast(`Inspecting transaction folder: ${row.id} (${row.customer})`);
};

// --- MOCK PERFORMANCE CHART DATA ---
const performanceData = ref({
    labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00', '24:00'],
    datasets: [
        {
            label: 'System Throughput (Requests/sec)',
            data: [1200, 950, 1850, 2400, 2900, 2100, 1500],
        }
    ]
});

// --- MOCK TIMELINE TRACKER DATA ---
const timelineActivities = ref([
    { id: 1, title: 'Database Backup Completed', desc: 'Automated snapshot stored securely', time: '10 mins ago', type: 'success', icon: Database },
    { id: 2, title: 'New Customer Registered', desc: 'Elena Rostova created a Subscriber account', time: '45 mins ago', type: 'info', icon: UserPlus },
    { id: 3, title: 'API Rate Limit warning', desc: 'Telemetry reports V3 key at 85% capacity', time: '2 hours ago', type: 'warning', icon: ShieldAlert },
    { id: 4, title: 'Threat Sweep Completed', desc: 'Full core scan found zero active threats', time: '5 hours ago', type: 'success', icon: Sparkles },
    { id: 5, title: 'System Deploy V2.4.1', desc: 'Kernel improvements pushed to staging', time: '1 day ago', type: 'system', icon: Clock },
]);

const getTimelineTypeClasses = (type) => {
    switch (type) {
        case 'success':
            return {
                bg: 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                dot: 'bg-emerald-500'
            };
        case 'warning':
            return {
                bg: 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                dot: 'bg-amber-500'
            };
        case 'info':
            return {
                bg: 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                dot: 'bg-blue-500'
            };
        case 'system':
        default:
            return {
                bg: 'bg-purple-500/10 text-purple-500 border-purple-500/20',
                dot: 'bg-purple-500'
            };
    }
};
</script>

<template>
    <Head title="AdminDEE Command Center" />

    <AdminLayout>
        <!-- Layout Sub-Header Slot -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent">
                        <Sparkles class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Command Center</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bento performance widgets and ledger listings synced in real-time.</span>
                    </div>
                </div>
                <button 
                    @click="triggerToast('Refreshing dashboard ledger data...')"
                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition shadow-sm"
                >
                    <RefreshCw class="h-3.5 w-3.5" />
                    <span>Refresh</span>
                </button>
            </div>
        </template>

        <!-- MAIN DASHBOARD CONTENT (Bento Box Grid) -->
        <div class="flex flex-col gap-6">
            
            <!-- TOP ROW: 4 Bento KPI Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- KPI Card 1: Active Customers -->
                <div class="animate-fade-in-up bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/20 dark:hover:shadow-black/20 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/0 to-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Active Customers</span>
                        <span class="p-2.5 rounded-2xl bg-emerald-500/10 text-emerald-500 dark:bg-emerald-500/20 border border-emerald-500/10 shrink-0">
                            <Users class="h-5 w-5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white font-sans tracking-tight">14,240</h3>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <TrendingUp class="h-3 w-3" />
                                <span>+12.4%</span>
                            </span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">from last month</span>
                        </div>
                    </div>
                </div>

                <!-- KPI Card 2: Gross Revenue -->
                <div class="animate-fade-in-up delay-100 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/20 dark:hover:shadow-black/20 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/0 to-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Gross Revenue</span>
                        <span class="p-2.5 rounded-2xl bg-amber-500/10 text-amber-500 dark:bg-amber-500/20 border border-amber-500/10 shrink-0">
                            <DollarSign class="h-5 w-5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white font-sans tracking-tight">$345,600</h3>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <TrendingUp class="h-3 w-3" />
                                <span>+18.2%</span>
                            </span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">vs target projection</span>
                        </div>
                    </div>
                </div>

                <!-- KPI Card 3: Server Latency -->
                <div class="animate-fade-in-up delay-200 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/20 dark:hover:shadow-black/20 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/0 to-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Average Latency</span>
                        <span class="p-2.5 rounded-2xl bg-blue-500/10 text-blue-500 dark:bg-blue-500/20 border border-blue-500/10 shrink-0">
                            <Activity class="h-5 w-5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white font-sans tracking-tight">14 ms</h3>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                <TrendingDown class="h-3 w-3" />
                                <span>-14.2%</span>
                            </span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">positive network drop</span>
                        </div>
                    </div>
                </div>

                <!-- KPI Card 4: Bounce Rate -->
                <div class="animate-fade-in-up delay-300 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-40 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-200/20 dark:hover:shadow-black/20 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/0 to-accent/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Bounce Rate</span>
                        <span class="p-2.5 rounded-2xl bg-rose-500/10 text-rose-500 dark:bg-rose-500/20 border border-rose-500/10 shrink-0">
                            <Percent class="h-5 w-5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white font-sans tracking-tight">2.41%</h3>
                        <div class="flex items-center gap-1.5 mt-2">
                            <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400">
                                <TrendingUp class="h-3 w-3" />
                                <span>+8.7%</span>
                            </span>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium">increase in bounces</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MIDDLE ROW: 70% Glassmorphic LineChart & 30% Vertical Timeline Tracker -->
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                
                <!-- 70% Chart Block -->
                <div class="animate-fade-in-up delay-400 lg:col-span-7 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:shadow-gray-200/10 dark:hover:shadow-black/10">
                    <div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-extrabold text-gray-800 dark:text-white leading-tight">System Throughput</h3>
                                <span class="text-xs text-gray-400 dark:text-gray-500 font-semibold">Continuous load balancing telemetry across standard server nodes.</span>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-xl bg-accent-glow text-accent border border-accent/10">Live</span>
                        </div>
                    </div>

                    <div class="flex-1 min-h-[300px] mt-6">
                        <LineChart :chart-data="performanceData" />
                    </div>
                </div>

                <!-- 30% Vertical Timeline Block -->
                <div class="animate-fade-in-up delay-500 lg:col-span-3 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col transition-all duration-300 hover:shadow-xl hover:shadow-gray-200/10 dark:hover:shadow-black/10">
                    <div class="mb-5">
                        <h3 class="text-base font-extrabold text-gray-800 dark:text-white leading-tight">System Audit Trail</h3>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-semibold block mt-0.5">Chronological system telemetry.</span>
                    </div>

                    <!-- Vertical Timeline Container -->
                    <div class="flex-1 relative pl-6 space-y-5 border-l border-gray-100 dark:border-gray-800/80 ml-3">
                        <div 
                            v-for="act in timelineActivities" 
                            :key="act.id"
                            class="relative flex items-start gap-3 text-xs"
                        >
                            <!-- Timeline Status Node -->
                            <span 
                                class="absolute -left-[30px] top-1 h-3 w-3 rounded-full border-2 border-white dark:border-gray-950 flex items-center justify-center shrink-0"
                                :class="getTimelineTypeClasses(act.type).dot"
                            >
                                <span class="h-1 w-1 rounded-full bg-white dark:bg-gray-950 animate-ping"></span>
                            </span>

                            <!-- Timeline Content Card -->
                            <div class="flex-1 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/50 rounded-2xl p-3 flex flex-col gap-1 transition duration-200 hover:bg-gray-50 dark:hover:bg-gray-950/40">
                                <div class="flex items-center justify-between">
                                    <span class="font-extrabold text-gray-800 dark:text-gray-200">{{ act.title }}</span>
                                    <span class="text-[10px] text-gray-400 dark:text-gray-500 font-medium whitespace-nowrap">{{ act.time }}</span>
                                </div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-snug">{{ act.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTTOM ROW: Massive AdvancedTable Loaded with Transactions Ledger -->
            <div class="animate-fade-in-up delay-500 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 shadow-sm rounded-3xl p-6 transition-all duration-300 flex flex-col gap-5 hover:shadow-xl hover:shadow-gray-200/10 dark:hover:shadow-black/10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-800 dark:text-white leading-tight">Transactions Ledger</h3>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-semibold">Listing standard user checkout values, processing statuses, and gateway files.</span>
                    </div>
                </div>

                <!-- AdvancedTable Implementation -->
                <AdvancedTable
                    :columns="transactionsColumns"
                    :rows="transactionsRows"
                    selectable
                    @selection-change="handleSelectionChange"
                    @bulk-action="handleBulkAction"
                    @row-click="handleRowClick"
                >
                    <!-- Custom Amount Column Slot -->
                    <template #col-amount="{ val }">
                        <span class="font-bold text-gray-900 dark:text-gray-100 font-mono text-xs">
                            {{ formatCurrency(val) }}
                        </span>
                    </template>

                    <!-- Custom Status Column Slot -->
                    <template #col-status="{ val }">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border transition-all"
                            :class="{
                                'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20': val === 'Completed',
                                'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500/20': val === 'Processing',
                                'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/20': val === 'Failed',
                                'bg-purple-500/10 text-purple-700 dark:text-purple-400 border-purple-500/20': val === 'Refunded'
                            }"
                        >
                            <span class="h-1.5 w-1.5 rounded-full mr-1.5" :class="{
                                'bg-emerald-500': val === 'Completed',
                                'bg-amber-500': val === 'Processing',
                                'bg-rose-500': val === 'Failed',
                                'bg-purple-500': val === 'Refunded'
                            }"></span>
                            {{ val }}
                        </span>
                    </template>

                    <!-- Custom Interactive Dropdown Actions Slot -->
                    <template #col-actions="{ row }">
                        <div class="relative inline-block text-left" @click.stop>
                            <button
                                @click="toggleActionsDropdown(row.id)"
                                class="p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                            >
                                <MoreVertical class="h-4 w-4" />
                            </button>

                            <!-- Dropdown Overlay Panel -->
                            <div
                                v-if="activeDropdownRowId === row.id"
                                class="absolute right-0 mt-1.5 w-40 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-1.5 z-40 text-xs flex flex-col"
                            >
                                <button
                                    @click="triggerAction('view', row)"
                                    class="flex items-center gap-2 px-4 py-2 text-left text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-gray-900 dark:hover:text-white transition font-medium"
                                >
                                    <Eye class="h-3.5 w-3.5" />
                                    <span>Inspect Folder</span>
                                </button>
                                <button
                                    v-if="row.status !== 'Refunded'"
                                    @click="triggerAction('refund', row)"
                                    class="flex items-center gap-2 px-4 py-2 text-left text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-gray-900 dark:hover:text-white transition font-medium"
                                >
                                    <ArrowUpRight class="h-3.5 w-3.5 text-purple-500" />
                                    <span>Issue Refund</span>
                                </button>
                                <button
                                    @click="triggerAction('delete', row)"
                                    class="flex items-center gap-2 px-4 py-2 text-left text-rose-600 dark:text-rose-400 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 transition font-medium"
                                >
                                    <Trash2 class="h-3.5 w-3.5" />
                                    <span>Archive Ledger</span>
                                </button>
                            </div>
                        </div>
                    </template>
                </AdvancedTable>
            </div>

        </div>

        <!-- Dynamic Success Toast Notifications -->
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
                <span class="text-xs font-bold">{{ toastMessage }}</span>
            </div>
        </Transition>
    </AdminLayout>
</template>

<style scoped>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    opacity: 0;
    animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
.delay-400 { animation-delay: 400ms; }
.delay-500 { animation-delay: 500ms; }
</style>
