<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import SelectBox from '@/Components/SelectBox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { 
    FileText,
    Sparkles,
    CheckCircle2
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Form variables
const clientName = ref('');
const clientService = ref('saas');
const notificationsActive = ref(true);

const serviceOptions = [
    { value: 'saas', label: 'SaaS Cluster License' },
    { value: 'enterprise', label: 'Enterprise Dedicated Nodes' },
    { value: 'consulting', label: 'Structural Architecture Consultation' }
];

const showSuccess = ref(false);
const submitForm = () => {
    showSuccess.value = true;
    setTimeout(() => {
        showSuccess.value = false;
        clientName.value = '';
    }, 4000);
};
</script>

<template>
    <Head title="Premium UI Components — General Forms" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <FileText class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">General Form Inputs</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke inputs, custom selectors, standard checkmarks, and visual forms.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-4xl mx-auto">
            <Card>
                <template #title>Standard Onboarding Details</template>
                <template #subtitle>Standard input modules displaying floating outlines.</template>

                <form @submit.prevent="submitForm" class="space-y-5 pt-3">
                    <!-- Text field -->
                    <FloatingInput 
                        id="client_name" 
                        v-model="clientName" 
                        label="Client Corporate Name (e.g. Sterling Holdings)" 
                        required 
                    />

                    <!-- Select field -->
                    <SelectBox 
                        id="client_srv" 
                        v-model="clientService" 
                        label="Licensing Tier Plan" 
                        :options="serviceOptions" 
                    />

                    <!-- Checkbox state -->
                    <div class="flex items-center gap-2 pt-2 px-1">
                        <input
                            type="checkbox"
                            id="notif_check"
                            v-model="notificationsActive"
                            class="h-4.5 w-4.5 rounded border-gray-300 focus:ring-accent text-accent"
                        />
                        <label for="notif_check" class="text-xs font-bold text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                            Enable email telemetry reports dispatched weekly
                        </label>
                    </div>

                    <!-- Actions panel -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                        <span class="text-[10px] text-gray-400 font-bold">All inputs encrypted safely</span>
                        
                        <PrimaryButton 
                            type="submit" 
                            class="px-5 py-3 transition shadow-md shadow-accent/15"
                            :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                        >
                            Submit Onboarding
                        </PrimaryButton>
                    </div>
                </form>
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
                v-if="showSuccess"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl shadow-black/5"
            >
                <CheckCircle2 class="h-5 w-5 text-emerald-500 shrink-0" />
                <span class="text-xs font-bold">Client onboarding files recorded successfully!</span>
            </div>
        </Transition>
    </AdminLayout>
</template>
