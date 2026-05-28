<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import { 
    AlertCircle,
    Home,
    Search
} from 'lucide-vue-next';

const configStore = useConfigStore();
</script>

<template>
    <Head title="404 Error — Node Not Registered" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent">
                        <AlertCircle class="h-5 w-5 animate-bounce" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Error Terminal</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Resource not resolved in target sectors.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col items-center justify-center min-h-[420px] text-center gap-6 max-w-lg mx-auto py-8">
            <h1 class="text-8xl font-extrabold font-mono tracking-tighter text-accent animate-pulse">404</h1>
            
            <div class="flex flex-col gap-2">
                <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">Workspace Node Not Registered</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-semibold">
                    The requested directory routing did not resolve to any active database components. It might have been relocated during node compaction.
                </p>
            </div>

            <!-- Custom search field -->
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <Search class="h-4 w-4 text-gray-400" />
                </span>
                <input 
                    type="text" 
                    placeholder="Search active core sectors..."
                    class="w-full pl-10 pr-4 py-2.5 text-xs bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                    :class="configStore.accentDetails.ring"
                />
            </div>

            <Link 
                :href="route('dashboard')"
                class="flex items-center justify-center gap-2 px-5 py-3 rounded-2xl text-xs font-bold text-white transition-all shadow-md shadow-accent/15"
                :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
            >
                <Home class="h-4 w-4" />
                <span>Return to Command Center</span>
            </Link>
        </div>
    </AdminLayout>
</template>
