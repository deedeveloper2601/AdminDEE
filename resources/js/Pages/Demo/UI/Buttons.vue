<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Fingerprint,
    Sparkles,
    ChevronRight,
    Github,
    Mail,
    Lock,
    Settings,
    RefreshCw
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Loading state
const isLoggingIn = ref(false);
const triggerLogin = () => {
    isLoggingIn.value = true;
    setTimeout(() => {
        isLoggingIn.value = false;
    }, 3000);
};
</script>

<template>
    <Head title="Premium UI Components — Button Library" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Fingerprint class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Custom Buttons & Loaders</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke button variants, load states with micro-animations, and social logins.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            <!-- Solid & Outline -->
            <Card>
                <template #title>Standard Outline & Solid Buttons</template>
                <template #subtitle>Standard responsive click models for layout control.</template>

                <div class="flex flex-col gap-4 pt-3">
                    <!-- Row 1 -->
                    <div class="flex flex-wrap items-center gap-3">
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-md shadow-accent/15" :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]">
                            Primary Accent
                        </button>
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 border border-gray-150 dark:border-gray-850 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            Secondary Flat
                        </button>
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold text-rose-600 bg-rose-500/10 border border-rose-500/10 hover:bg-rose-500/15 transition">
                            Danger Red
                        </button>
                    </div>

                    <!-- Row 2 -->
                    <div class="flex flex-wrap items-center gap-3">
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-transparent border border-accent text-accent hover:bg-accent/5 transition">
                            Accent Outline
                        </button>
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-transparent border border-emerald-500 text-emerald-500 hover:bg-emerald-500/5 transition">
                            Success Outline
                        </button>
                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-transparent border border-rose-500 text-rose-500 hover:bg-rose-500/5 transition">
                            Danger Outline
                        </button>
                    </div>
                </div>
            </Card>

            <!-- Loading & Animation -->
            <Card>
                <template #title>Micro-Animations & Loaders</template>
                <template #subtitle>Click to preview dynamic load indicators.</template>

                <div class="flex flex-col gap-4 pt-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <button 
                            @click="triggerLogin"
                            :disabled="isLoggingIn"
                            class="px-5 py-3 rounded-xl text-xs font-bold text-white transition-all shadow-md flex items-center gap-2"
                            :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                        >
                            <RefreshCw class="h-4 w-4 animate-spin" v-if="isLoggingIn" />
                            <span>{{ isLoggingIn ? 'Encrypting Tokens...' : 'Submit Checkout' }}</span>
                        </button>

                        <button class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 transition duration-300 shadow-md flex items-center gap-1.5 group">
                            <span>Gradient Flow</span>
                            <ChevronRight class="h-4 w-4 group-hover:translate-x-1 transition duration-200" />
                        </button>
                    </div>
                </div>
            </Card>

            <!-- Social integrations -->
            <Card class="md:col-span-2">
                <template #title>Social Authentication Integrations</template>
                <template #subtitle>Standard single-sign-on credentials entrance.</template>

                <div class="flex flex-wrap items-center gap-4 pt-3">
                    <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-gray-950 text-white hover:bg-black transition flex items-center gap-2 shadow">
                        <Github class="h-4.5 w-4.5" />
                        <span>Continue with GitHub</span>
                    </button>

                    <button class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white text-gray-800 border border-gray-150 hover:bg-gray-50 transition flex items-center gap-2 shadow-sm">
                        <Mail class="h-4.5 w-4.5 text-red-500" />
                        <span>Continue with Google Mail</span>
                    </button>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
