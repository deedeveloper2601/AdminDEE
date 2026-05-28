<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FormWizard from '@/Components/FormWizard.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import SelectBox from '@/Components/SelectBox.vue';
import { 
    Sparkles, 
    User, 
    MapPin, 
    CheckCircle2, 
    UserCheck,
    ArrowRight,
    RefreshCw
} from 'lucide-vue-next';

const configStore = useConfigStore();

// --- STATE ---
const wizardSteps = ref(['Personal Profile', 'Billing Location', 'Final Ledger']);

const formData = ref({
    firstName: '',
    lastName: '',
    email: '',
    address: '',
    country: ''
});

const countriesList = ref([
    { value: 'US', label: 'United States' },
    { value: 'CA', label: 'Canada' },
    { value: 'GB', label: 'United Kingdom' },
    { value: 'DE', label: 'Germany' },
    { value: 'FR', label: 'France' },
    { value: 'AU', label: 'Australia' },
    { value: 'JP', label: 'Japan' }
]);

const showSuccessAlert = ref(false);
const wizardRef = ref(null);

// --- HANDLERS ---
const handleWizardSubmit = () => {
    // Show success alert
    showSuccessAlert.value = true;
};

const handleReset = () => {
    // Reset form state
    formData.value = {
        firstName: '',
        lastName: '',
        email: '',
        address: '',
        country: ''
    };
    showSuccessAlert.value = false;
    
    // Programmatically reset FormWizard to step 1
    if (wizardRef.value) {
        wizardRef.value.goToStep(1);
    }
};

const getCountryName = (code) => {
    const country = countriesList.value.find(c => c.value === code);
    return country ? country.label : code || 'Not Specified';
};
</script>

<template>
    <Head title="Form Wizard UI Demo" />

    <AdminLayout>
        <!-- Page Header Slot -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent">
                        <Sparkles class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Form Wizard Demo</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Dynamic, hardware-accelerated bento forms syncing in real-time.</span>
                    </div>
                </div>
            </div>
        </template>

        <!-- Page Content -->
        <div class="max-w-2xl mx-auto py-4">
            
            <!-- Success Alert Banner -->
            <Transition
                enter-active-class="transform transition ease-out duration-400"
                enter-from-class="-translate-y-4 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition ease-in duration-300"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div 
                    v-if="showSuccessAlert" 
                    class="mb-6 p-6 bg-emerald-500/10 dark:bg-emerald-500/5 border border-emerald-500/20 rounded-3xl flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left justify-between"
                >
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <span class="p-3 rounded-2xl bg-emerald-500/20 text-emerald-500 shrink-0">
                            <CheckCircle2 class="h-6 w-6 stroke-[2.5]" />
                        </span>
                        <div>
                            <h4 class="text-sm font-extrabold text-gray-900 dark:text-white">Profile Configured Successfully!</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mt-0.5">Database records updated. Ready for environment deployment.</p>
                        </div>
                    </div>
                    <button
                        @click="handleReset"
                        class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 hover:border-gray-200 rounded-xl text-gray-700 dark:text-gray-300 shadow-sm hover:shadow transition"
                    >
                        <RefreshCw class="h-3.5 w-3.5" />
                        <span>Reset Wizard</span>
                    </button>
                </div>
            </Transition>

            <!-- Centered Glassmorphic Wizard Card -->
            <div class="relative">
                <!-- Decorative accent glow behind card -->
                <div class="absolute -inset-1 rounded-[32px] bg-gradient-to-tr from-accent/15 via-accent/5 to-accent/20 blur-xl opacity-40 dark:opacity-20 pointer-events-none"></div>
                
                <Card class="relative">
                    <template #title>
                        <span class="flex items-center gap-2">
                            <UserCheck class="h-5 w-5 text-accent" />
                            <span>Provisioning Portal</span>
                        </span>
                    </template>
                    <template #subtitle>
                        Complete all modules to register a secure administrative checkout ledger.
                    </template>

                    <!-- Wizard instance -->
                    <FormWizard 
                        ref="wizardRef"
                        :steps="wizardSteps" 
                        @submit="handleWizardSubmit"
                        :class="{ 'opacity-50 pointer-events-none': showSuccessAlert }"
                    >
                        <template #default="{ currentStep }">
                            
                            <!-- STEP 1: Personal Profile -->
                            <div v-if="currentStep === 1" class="space-y-5 animate-fade-in">
                                <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-50 dark:border-gray-800/40">
                                    <span class="p-1 rounded bg-blue-500/10 text-blue-500">
                                        <User class="h-4 w-4" />
                                    </span>
                                    <span class="text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Account Credentials</span>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <FloatingInput 
                                        id="first_name" 
                                        v-model="formData.firstName" 
                                        label="First Name" 
                                        required 
                                    />
                                    <FloatingInput 
                                        id="last_name" 
                                        v-model="formData.lastName" 
                                        label="Last Name" 
                                        required 
                                    />
                                </div>
                                <FloatingInput 
                                    id="email" 
                                    v-model="formData.email" 
                                    type="email" 
                                    label="Email Address" 
                                    required 
                                />
                            </div>

                            <!-- STEP 2: Billing Location -->
                            <div v-else-if="currentStep === 2" class="space-y-5 animate-fade-in">
                                <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-50 dark:border-gray-800/40">
                                    <span class="p-1 rounded bg-amber-500/10 text-amber-500">
                                        <MapPin class="h-4 w-4" />
                                    </span>
                                    <span class="text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mailing Details</span>
                                </div>
                                <FloatingInput 
                                    id="address" 
                                    v-model="formData.address" 
                                    label="Street Address" 
                                    required 
                                />
                                <SelectBox 
                                    id="country" 
                                    v-model="formData.country" 
                                    label="Country of Residence" 
                                    :options="countriesList" 
                                    required 
                                />
                            </div>

                            <!-- STEP 3: Final Ledger Summary -->
                            <div v-else-if="currentStep === 3" class="space-y-5 animate-fade-in">
                                <div class="flex items-center gap-2 mb-2 pb-2 border-b border-gray-50 dark:border-gray-800/40">
                                    <span class="p-1 rounded bg-accent-glow text-accent">
                                        <CheckCircle2 class="h-4 w-4" />
                                    </span>
                                    <span class="text-xs font-extrabold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Telemetry Review</span>
                                </div>

                                <!-- Review Ledger Table -->
                                <div class="bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100 dark:border-gray-850 rounded-2xl p-4 md:p-5 flex flex-col gap-3.5 text-xs">
                                    <div class="flex items-center justify-between pb-2.5 border-b border-gray-100/60 dark:border-gray-900">
                                        <span class="font-semibold text-gray-400">Full Name</span>
                                        <span class="font-bold text-gray-900 dark:text-white">
                                            {{ formData.firstName || 'Not specified' }} {{ formData.lastName }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between pb-2.5 border-b border-gray-100/60 dark:border-gray-900">
                                        <span class="font-semibold text-gray-400">Email Address</span>
                                        <span class="font-bold text-gray-950 dark:text-white select-all font-mono">{{ formData.email || 'Not specified' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between pb-2.5 border-b border-gray-100/60 dark:border-gray-900">
                                        <span class="font-semibold text-gray-400">Street Address</span>
                                        <span class="font-bold text-gray-900 dark:text-white truncate max-w-[200px]">{{ formData.address || 'Not specified' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="font-semibold text-gray-400">Region</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ getCountryName(formData.country) }}</span>
                                    </div>
                                </div>

                                <div class="p-4 bg-accent-glow border border-accent/10 rounded-2xl text-[11px] text-accent font-semibold flex items-center gap-2">
                                    <span>Proceeding will commit all telemetry variables to local gateway storage.</span>
                                </div>
                            </div>

                        </template>
                    </FormWizard>
                </Card>
            </div>

        </div>
    </AdminLayout>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.98);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.animate-fade-in {
    animation: fadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>
