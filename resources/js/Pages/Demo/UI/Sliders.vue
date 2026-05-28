<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Sliders,
    Sparkles,
    Settings,
    TrendingUp
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Sliders states
const sliderVal1 = ref(45);
const sliderVal2 = ref(82);
</script>

<template>
    <Head title="Premium UI Components — Custom Sliders" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Sliders class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Interactive Value Sliders</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke range values with instant numerical counters and custom track colors.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-4xl mx-auto">
            <Card>
                <template #title>Standard Range & Value Tracks</template>
                <template #subtitle>Drag handles to adjust numerical telemetry in real-time.</template>

                <div class="flex flex-col gap-6 pt-3 text-xs">
                    <!-- Slider 1 -->
                    <div class="flex flex-col gap-2 p-4 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                        <div class="flex items-center justify-between font-bold">
                            <span class="text-gray-500 uppercase tracking-wider text-[10px]">Processor Load Threshold</span>
                            <span class="text-accent text-sm font-mono font-bold">{{ sliderVal1 }}%</span>
                        </div>
                        <input 
                            v-model="sliderVal1" 
                            type="range" 
                            min="0" 
                            max="100"
                            class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-accent"
                        />
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-normal">Defines the saturation barrier where cluster pods trigger horizontal scaling events.</p>
                    </div>

                    <!-- Slider 2 -->
                    <div class="flex flex-col gap-2 p-4 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl">
                        <div class="flex items-center justify-between font-bold">
                            <span class="text-gray-500 uppercase tracking-wider text-[10px]">Database Connection Timeouts</span>
                            <span class="text-emerald-500 text-sm font-mono font-bold">{{ sliderVal2 }} ms</span>
                        </div>
                        <input 
                            v-model="sliderVal2" 
                            type="range" 
                            min="10" 
                            max="300"
                            class="w-full h-1.5 bg-gray-200 dark:bg-gray-800 rounded-lg appearance-none cursor-pointer accent-emerald-500"
                        />
                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold leading-normal">Sets the duration threshold in milliseconds before dynamic database handshakes timeout.</p>
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
