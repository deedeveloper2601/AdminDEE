<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import BarChart from '@/Components/BarChart.vue';
import DoughnutChart from '@/Components/DoughnutChart.vue';
import AdvancedTable from '@/Components/AdvancedTable.vue';
import { 
    Sparkles, 
    TrendingUp, 
    TrendingDown, 
    ShoppingBag, 
    CreditCard, 
    Users, 
    ChevronRight,
    ArrowUpRight, 
    Eye, 
    RefreshCw, 
    Zap,
    MapPin,
    Smartphone,
    Monitor,
    Tablet
} from 'lucide-vue-next';

const configStore = useConfigStore();

onMounted(() => {
    configStore.init();
});

// Mock metrics
const salesStats = ref({
    revenue: '$142,384.00',
    orders: '3,842',
    conversion: '3.42%',
    activeUsers: '1,842'
});

// Mock charts data
const monthlySalesData = ref({
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
        {
            label: 'Sales Revenue ($)',
            data: [18000, 24000, 32000, 29000, 42000, 48000, 54000],
        }
    ]
});

const deviceData = ref({
    labels: ['Desktop', 'Mobile', 'Tablet'],
    datasets: [
        {
            data: [55, 35, 10],
            backgroundColor: ['#6366f1', '#10b981', '#f59e0b']
        }
    ]
});

// Recent Products Sold
const productsRows = ref([
    { id: 1, name: 'Aether Wireless Earbuds', sales: 482, price: 129.99, status: 'In Stock' },
    { id: 2, name: 'Nova Smartwatch Series X', sales: 312, price: 249.50, status: 'In Stock' },
    { id: 3, name: 'Apex Mechanical Keyboard', sales: 198, price: 89.00, status: 'Low Stock' },
    { id: 4, name: 'Vortex VR Headset V2', sales: 145, price: 399.00, status: 'Out of Stock' },
    { id: 5, name: 'Lumix Ring Light Pro', sales: 94, price: 59.99, status: 'In Stock' }
]);

const productsColumns = [
    { key: 'name', label: 'Product Name', sortable: true, align: 'left' },
    { key: 'sales', label: 'Sales Count', sortable: true, align: 'right' },
    { key: 'price', label: 'Unit Price', sortable: true, align: 'right' },
    { key: 'status', label: 'Inventory Status', sortable: true, align: 'center' }
];

const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
};
</script>

<template>
    <Head title="Premium E-Commerce v2 Dashboard" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <ShoppingBag class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">E-Commerce Center</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke analytics layout highlighting business operations.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6">
            <!-- Summary Blocks -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Sales -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-36 hover:-translate-y-1 transition duration-300 relative group overflow-hidden shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/0 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Gross Revenue</span>
                        <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-500 border border-indigo-500/5">
                            <CreditCard class="h-4.5 w-4.5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ salesStats.revenue }}</h3>
                        <span class="text-[10px] text-emerald-500 font-bold inline-flex items-center gap-0.5 mt-1">
                            <TrendingUp class="h-3 w-3" /> +14.8% vs last month
                        </span>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-36 hover:-translate-y-1 transition duration-300 relative group overflow-hidden shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/0 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total Orders</span>
                        <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-500 border border-emerald-500/5">
                            <ShoppingBag class="h-4.5 w-4.5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ salesStats.orders }}</h3>
                        <span class="text-[10px] text-emerald-500 font-bold inline-flex items-center gap-0.5 mt-1">
                            <TrendingUp class="h-3 w-3" /> +8.2% from last week
                        </span>
                    </div>
                </div>

                <!-- Conversion -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-36 hover:-translate-y-1 transition duration-300 relative group overflow-hidden shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-tr from-amber-500/0 to-amber-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Conversion Rate</span>
                        <span class="p-2 rounded-xl bg-amber-500/10 text-amber-500 border border-amber-500/5">
                            <Zap class="h-4.5 w-4.5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ salesStats.conversion }}</h3>
                        <span class="text-[10px] text-rose-500 font-bold inline-flex items-center gap-0.5 mt-1">
                            <TrendingDown class="h-3 w-3" /> -1.2% versus targets
                        </span>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between h-36 hover:-translate-y-1 transition duration-300 relative group overflow-hidden shadow-sm">
                    <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/0 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Real-time Visitors</span>
                        <span class="p-2 rounded-xl bg-cyan-500/10 text-cyan-500 border border-cyan-500/5">
                            <Users class="h-4.5 w-4.5" />
                        </span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ salesStats.activeUsers }}</h3>
                        <span class="text-[10px] text-emerald-500 font-bold inline-flex items-center gap-0.5 mt-1">
                            <TrendingUp class="h-3 w-3" /> +24.5% in past hour
                        </span>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                <!-- Bar Chart (Revenue Over Time) -->
                <div class="lg:col-span-7 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between shadow-sm">
                    <div class="mb-4">
                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Revenue Inflow Timeline</h4>
                        <span class="text-xs text-gray-400 dark:text-gray-500">Comparing gross intake performance values monthly.</span>
                    </div>
                    <div class="h-[280px]">
                        <BarChart :chart-data="monthlySalesData" />
                    </div>
                </div>

                <!-- Doughnut Chart (Devices) -->
                <div class="lg:col-span-3 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col justify-between shadow-sm">
                    <div class="mb-4">
                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Traffic by Platform</h4>
                        <span class="text-xs text-gray-400 dark:text-gray-500">Breakdown of terminal access methods.</span>
                    </div>
                    <div class="h-[200px] flex items-center justify-center relative">
                        <DoughnutChart :chart-data="deviceData" />
                    </div>
                    <div class="flex justify-around text-xs mt-4">
                        <span class="flex items-center gap-1"><Monitor class="h-3.5 w-3.5 text-indigo-500" /> Desktop (55%)</span>
                        <span class="flex items-center gap-1"><Smartphone class="h-3.5 w-3.5 text-emerald-500" /> Mobile (35%)</span>
                        <span class="flex items-center gap-1"><Tablet class="h-3.5 w-3.5 text-amber-500" /> Tablet (10%)</span>
                    </div>
                </div>
            </div>

            <!-- Ledger Grid -->
            <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 flex flex-col gap-4 shadow-sm">
                <div>
                    <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Top Performing Products</h4>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Best-selling inventory listing ranked by checkout transactions.</span>
                </div>
                <AdvancedTable :columns="productsColumns" :rows="productsRows">
                    <template #col-price="{ val }">
                        <span class="font-bold text-gray-900 dark:text-gray-100 font-mono text-xs">{{ formatCurrency(val) }}</span>
                    </template>
                    <template #col-status="{ val }">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold border"
                            :class="{
                                'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20': val === 'In Stock',
                                'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500/20': val === 'Low Stock',
                                'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/20': val === 'Out of Stock'
                            }"
                        >
                            {{ val }}
                        </span>
                    </template>
                </AdvancedTable>
            </div>
        </div>
    </AdminLayout>
</template>
