<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import LineChart from '@/Components/LineChart.vue';
import { 
    Cpu, 
    Database, 
    Globe, 
    Activity, 
    TrendingUp, 
    HardDrive,
    Server,
    Wifi,
    Terminal,
    ArrowUpRight,
    Play,
    Pause
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Live telemetry metrics
const cpuUsage = ref(42);
const memUsage = ref(68);
const socketCount = ref(1284);
const networkIO = ref(245.5);

// Animated line chart data
const telemetryLabels = ref(['10s ago', '8s ago', '6s ago', '4s ago', '2s ago', 'Now']);
const telemetryDataset = ref([45, 52, 49, 61, 55, 42]);

const liveChartData = ref({
    labels: telemetryLabels.value,
    datasets: [
        {
            label: 'Processor Core Temp (°C)',
            data: telemetryDataset.value,
        }
    ]
});

// Logs feed
const systemLogs = ref([
    { id: 1, type: 'info', service: 'AUTH-GATE', msg: 'JWT session handshake signed for user elena.rostova', time: '14:20:12' },
    { id: 2, type: 'success', service: 'DB-KEEPER', msg: 'Synchronous replication index pushed to Zone B storage', time: '14:20:05' },
    { id: 3, type: 'warning', service: 'GATEWAY-MAIN', msg: 'Slow query response detected in checkout payload API (2.4s)', time: '14:19:54' },
    { id: 4, type: 'info', service: 'SYS-MONITOR', msg: 'Garbage collector initialized memory compaction on node 4', time: '14:19:40' }
]);

let telemetryTimer = null;
const isLiveActive = ref(true);

const generateTelemetry = () => {
    if (!isLiveActive.value) return;

    // Shift data
    cpuUsage.value = Math.floor(Math.random() * 35) + 30;
    memUsage.value = Math.floor(Math.random() * 15) + 60;
    socketCount.value += Math.floor(Math.random() * 20) - 10;
    networkIO.value = +(networkIO.value + (Math.random() * 20 - 10)).toFixed(1);

    telemetryDataset.value.shift();
    telemetryDataset.value.push(cpuUsage.value + 15);
    
    liveChartData.value = {
        labels: telemetryLabels.value,
        datasets: [
            {
                label: 'Processor Core Temp (°C)',
                data: [...telemetryDataset.value]
            }
        ]
    };

    // Add random log
    const services = ['API-CORE', 'WORKER-SYS', 'CDN-EDGE', 'CACHE-REDIS'];
    const msgs = [
        'Heartbeat signal verified across regional edge nodes',
        'Redis cache eviction index executed successfully (12 keys)',
        'Incoming websocket request authorized: client ID 849',
        'Cloud storage blob persistence finished write operation'
    ];
    const types = ['info', 'success', 'warning'];

    const newLog = {
        id: Date.now(),
        type: types[Math.floor(Math.random() * types.length)],
        service: services[Math.floor(Math.random() * services.length)],
        msg: msgs[Math.floor(Math.random() * msgs.length)],
        time: new Date().toTimeString().split(' ')[0]
    };
    systemLogs.value.unshift(newLog);
    if (systemLogs.value.length > 8) systemLogs.value.pop();
};

onMounted(() => {
    configStore.init();
    telemetryTimer = setInterval(generateTelemetry, 2500);
});

onUnmounted(() => {
    if (telemetryTimer) clearInterval(telemetryTimer);
});

const toggleLive = () => {
    isLiveActive.value = !isLiveActive.value;
};
</script>

<template>
    <Head title="Premium SaaS Infrastructure v3 Dashboard" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-spin-slow">
                        <Cpu class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Infrastructure Command</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Real-time socket parameters and process load balances.</span>
                    </div>
                </div>
                <button 
                    @click="toggleLive"
                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition shadow-sm"
                >
                    <component :is="isLiveActive ? Pause : Play" class="h-3.5 w-3.5" />
                    <span>{{ isLiveActive ? 'Pause Telemetry' : 'Resume Telemetry' }}</span>
                </button>
            </div>
        </template>

        <div class="flex flex-col gap-6">
            <!-- Telemetry Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- CPU -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">CPU Core Capacity</span>
                        <Cpu class="h-5 w-5 text-indigo-500" />
                    </div>
                    <div class="mt-4">
                        <div class="flex items-baseline justify-between">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ cpuUsage }}%</h3>
                            <span class="text-[9px] font-bold text-emerald-500 flex items-center">Normal Load</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" :style="{ width: cpuUsage + '%' }"></div>
                        </div>
                    </div>
                </div>

                <!-- Memory -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">RAM Utilization</span>
                        <HardDrive class="h-5 w-5 text-emerald-500" />
                    </div>
                    <div class="mt-4">
                        <div class="flex items-baseline justify-between">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ memUsage }}%</h3>
                            <span class="text-[9px] font-bold text-emerald-500 flex items-center">Stable</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-emerald-600 h-full rounded-full transition-all duration-500" :style="{ width: memUsage + '%' }"></div>
                        </div>
                    </div>
                </div>

                <!-- Web Sockets -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Active Sockets</span>
                        <Wifi class="h-5 w-5 text-amber-500" />
                    </div>
                    <div class="mt-4">
                        <div class="flex items-baseline justify-between">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ socketCount }}</h3>
                            <span class="text-[9px] font-bold text-emerald-500 flex items-center">+42 new clients</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-amber-500 h-full rounded-full transition-all duration-500 animate-pulse" :style="{ width: '80%' }"></div>
                        </div>
                    </div>
                </div>

                <!-- Network IO -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Edge Network I/O</span>
                        <Globe class="h-5 w-5 text-cyan-500" />
                    </div>
                    <div class="mt-4">
                        <div class="flex items-baseline justify-between">
                            <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ networkIO }} MB/s</h3>
                            <span class="text-[9px] font-bold text-emerald-500 flex items-center">Unrestricted</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1.5 rounded-full mt-2 overflow-hidden">
                            <div class="bg-cyan-500 h-full rounded-full transition-all duration-500" :style="{ width: '60%' }"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graph and Server logs -->
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6">
                <!-- Processor Temperature Chart -->
                <div class="lg:col-span-6 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 shadow-sm">
                    <div class="mb-4">
                        <h4 class="font-extrabold text-sm text-gray-900 dark:text-white">Processor Temp Telemetry</h4>
                        <span class="text-xs text-gray-400 dark:text-gray-500">Live feed monitor highlighting socket sensor measurements.</span>
                    </div>
                    <div class="h-[260px]">
                        <LineChart :chart-data="liveChartData" />
                    </div>
                </div>

                <!-- Command shell logs -->
                <div class="lg:col-span-4 bg-white/70 dark:bg-gray-900/60 backdrop-blur-md rounded-3xl border border-gray-100 dark:border-gray-900 p-6 flex flex-col shadow-sm overflow-hidden">
                    <div class="mb-4 flex items-center justify-between">
                        <div>
                            <h4 class="font-extrabold text-sm text-gray-900 dark:text-white flex items-center gap-1.5"><Terminal class="h-4.5 w-4.5 text-indigo-500" /> Live Kernel Logs</h4>
                            <span class="text-xs text-gray-400 dark:text-gray-500">Continuous telemetry audit trail outputs.</span>
                        </div>
                        <span class="h-2 w-2 rounded-full bg-red-500 animate-ping"></span>
                    </div>
                    
                    <div class="flex-1 bg-gray-950 text-gray-250 font-mono text-[10px] p-4 rounded-2xl overflow-y-auto space-y-2.5 max-h-[260px] border border-gray-900 shadow-inner">
                        <div v-for="log in systemLogs" :key="log.id" class="flex flex-col gap-0.5 leading-snug">
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500">[{{ log.time }}]</span>
                                <span class="px-1 rounded font-bold"
                                    :class="{
                                        'bg-blue-500/20 text-blue-400': log.type === 'info',
                                        'bg-emerald-500/20 text-emerald-400': log.type === 'success',
                                        'bg-amber-500/20 text-amber-400': log.type === 'warning'
                                    }"
                                >
                                    {{ log.service }}
                                </span>
                            </div>
                            <span class="text-gray-300 ml-4">{{ log.msg }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
