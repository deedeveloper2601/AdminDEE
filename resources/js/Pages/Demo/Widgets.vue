<script setup>
import { ref, onMounted } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    ToyBrick, 
    Sparkles, 
    CloudSun, 
    Calendar, 
    MessageSquare, 
    Plus, 
    Check, 
    User, 
    Clock, 
    Settings,
    FileText,
    Download,
    Mail,
    Phone
} from 'lucide-vue-next';

const configStore = useConfigStore();

onMounted(() => {
    configStore.init();
});

// Weather
const weather = ref({
    temp: '72°F',
    desc: 'Partly Sunny',
    loc: 'San Francisco, CA'
});

// Quick Chat
const messages = ref([
    { id: 1, sender: 'Sophia Sterling', avatar: 'SS', msg: 'Hey! Did you review the marketing report?', mine: false },
    { id: 2, sender: 'You', avatar: 'U', msg: 'Yes, looking great. I will approve it shortly.', mine: true },
    { id: 3, sender: 'Sophia Sterling', avatar: 'SS', msg: 'Awesome! Talk to you later.', mine: false }
]);

const chatInput = ref('');
const sendMessage = () => {
    if (!chatInput.value.trim()) return;
    messages.value.push({
        id: Date.now(),
        sender: 'You',
        avatar: 'U',
        msg: chatInput.value,
        mine: true
    });
    chatInput.value = '';
};

// Quick Tasks
const tasks = ref([
    { id: 1, label: 'Release deployment to production nodes', done: true },
    { id: 2, label: 'Review security log warnings in checkout API', done: false },
    { id: 3, label: 'Optimize index performance of client ledgers', done: false }
]);

const toggleTask = (t) => {
    t.done = !t.done;
};
</script>

<template>
    <Head title="Premium UI Components & Bento Widgets" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <ToyBrick class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Bento Components Library</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Stat cards, weather boards, mini todo list and interactive containers.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8">
            <!-- Row 1: 4 Statistics Info-boxes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1 -->
                <div class="bg-gradient-to-tr from-indigo-600 to-indigo-500 text-white rounded-3xl p-6 flex items-center justify-between shadow-md">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-100">Weekly Sales</span>
                        <h3 class="text-2xl font-extrabold font-mono">$18,240</h3>
                        <span class="text-[9px] text-indigo-150 mt-1">+14.2% gain vs projection</span>
                    </div>
                    <span class="p-3 rounded-2xl bg-white/10 border border-white/10 shrink-0">
                        <FileText class="h-6 w-6 text-white" />
                    </span>
                </div>

                <!-- Stat 2 -->
                <div class="bg-gradient-to-tr from-emerald-600 to-emerald-500 text-white rounded-3xl p-6 flex items-center justify-between shadow-md">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-100">Files Saved</span>
                        <h3 class="text-2xl font-extrabold font-mono">4,892</h3>
                        <span class="text-[9px] text-emerald-150 mt-1">98% server drive load capacity</span>
                    </div>
                    <span class="p-3 rounded-2xl bg-white/10 border border-white/10 shrink-0">
                        <Download class="h-6 w-6 text-white" />
                    </span>
                </div>

                <!-- Stat 3 -->
                <div class="bg-gradient-to-tr from-amber-600 to-amber-500 text-white rounded-3xl p-6 flex items-center justify-between shadow-md">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-100">Active Contacts</span>
                        <h3 class="text-2xl font-extrabold font-mono">1,280</h3>
                        <span class="text-[9px] text-amber-150 mt-1">New subscriber node register</span>
                    </div>
                    <span class="p-3 rounded-2xl bg-white/10 border border-white/10 shrink-0">
                        <User class="h-6 w-6 text-white" />
                    </span>
                </div>

                <!-- Stat 4 -->
                <div class="bg-gradient-to-tr from-rose-600 to-rose-500 text-white rounded-3xl p-6 flex items-center justify-between shadow-md">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-100">System Telemetry</span>
                        <h3 class="text-2xl font-extrabold font-mono">100%</h3>
                        <span class="text-[9px] text-rose-150 mt-1">All cluster sectors operational</span>
                    </div>
                    <span class="p-3 rounded-2xl bg-white/10 border border-white/10 shrink-0">
                        <Clock class="h-6 w-6 text-white" />
                    </span>
                </div>
            </div>

            <!-- Row 2: Weather, Chat, Tasks bento layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Weather Widget -->
                <div class="bg-gradient-to-b from-sky-400 to-blue-500 text-white rounded-3xl p-6 flex flex-col justify-between min-h-[300px] shadow-sm relative overflow-hidden group">
                    <!-- Dynamic absolute clouds graphics -->
                    <div class="absolute -right-10 -top-10 opacity-10 group-hover:scale-110 transition duration-500">
                        <CloudSun class="h-48 w-48" />
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold tracking-wide text-sky-100">Weather Forecast</span>
                            <span class="text-sm font-extrabold mt-0.5">{{ weather.loc }}</span>
                        </div>
                        <CloudSun class="h-10 w-10 text-amber-300 drop-shadow-md animate-bounce" />
                    </div>
                    <div class="mt-8">
                        <h2 class="text-6xl font-extrabold font-mono leading-none tracking-tight">{{ weather.temp }}</h2>
                        <p class="text-xs font-bold text-sky-150 mt-1.5">{{ weather.desc }} — Light gentle breeze from NW</p>
                    </div>
                    <div class="flex justify-between border-t border-white/10 pt-4 mt-4 text-[10px] text-sky-100 font-semibold">
                        <span>HUMIDITY: 45%</span>
                        <span>WIND: 8 mph</span>
                        <span>PRECIP: 5%</span>
                    </div>
                </div>

                <!-- Chat Widget -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 flex flex-col justify-between min-h-[300px] shadow-sm">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-55/10">
                        <span class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-1.5"><MessageSquare class="h-4 w-4 text-accent" /> Team Chat Room</span>
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </div>
                    <div class="flex-1 overflow-y-auto space-y-3.5 my-4 pr-1 max-h-[160px]">
                        <div v-for="msg in messages" :key="msg.id" class="flex items-start gap-2.5 text-[11px]" :class="{ 'flex-row-reverse': msg.mine }">
                            <span class="h-7.5 w-7.5 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0"
                                :class="msg.mine ? configStore.accentDetails.bg : 'bg-gray-400 dark:bg-gray-700'"
                            >
                                {{ msg.avatar }}
                            </span>
                            <div class="p-2.5 rounded-2xl max-w-[70%]"
                                :class="msg.mine 
                                    ? 'bg-accent/10 border border-accent/15 text-gray-800 dark:text-gray-200' 
                                    : 'bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-800 text-gray-700 dark:text-gray-400'"
                            >
                                <span class="font-bold block text-[9px] mb-0.5 text-gray-400" v-if="!msg.mine">{{ msg.sender }}</span>
                                <p class="leading-normal">{{ msg.msg }}</p>
                            </div>
                        </div>
                    </div>
                    <form @submit.prevent="sendMessage" class="flex gap-2">
                        <input 
                            v-model="chatInput"
                            type="text" 
                            placeholder="Write instant reply..."
                            class="flex-1 px-3.5 py-2 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                            :class="configStore.accentDetails.ring"
                        />
                        <button type="submit" class="p-2 text-white rounded-xl transition font-bold text-xs" :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]">
                            Send
                        </button>
                    </form>
                </div>

                <!-- Todo Checklist -->
                <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 flex flex-col justify-between min-h-[300px] shadow-sm">
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-55/10 mb-4">
                            <span class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-1.5"><Calendar class="h-4 w-4 text-accent" /> Tasks Checklist</span>
                            <span class="text-[9px] font-bold text-gray-400 dark:text-gray-500">3 TOTAL</span>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div 
                                v-for="t in tasks" 
                                :key="t.id"
                                @click="toggleTask(t)"
                                class="flex items-center gap-2.5 p-3 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl cursor-pointer transition select-none hover:bg-gray-50 dark:hover:bg-gray-950/40"
                            >
                                <span class="h-5 w-5 rounded-lg border flex items-center justify-center transition shrink-0"
                                    :class="t.done ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-gray-300 dark:border-gray-700'"
                                >
                                    <Check class="h-3.5 w-3.5 stroke-[3]" v-if="t.done" />
                                </span>
                                <span class="text-[11px] font-semibold transition" :class="t.done ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-700 dark:text-gray-300'">
                                    {{ t.label }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-55/10 flex items-center justify-between">
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold">Autosaved to cache</span>
                        <button class="flex items-center gap-1 text-[10px] font-extrabold text-accent hover:underline">
                            <Plus class="h-3.5 w-3.5 stroke-[3]" /> Add Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
