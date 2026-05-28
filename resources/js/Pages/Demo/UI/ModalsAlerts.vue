<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import { 
    AlertCircle,
    Sparkles,
    CheckCircle2,
    XCircle,
    ShieldAlert,
    Layout,
    Eye
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Modal States
const isStandardOpen = ref(false);
const isSuccessOpen = ref(false);
const isDangerOpen = ref(false);
const isFormOpen = ref(false);

// Toast state
const showToast = ref(false);
const toastMessage = ref('');
const triggerToast = (msg) => {
    toastMessage.value = msg;
    showToast.value = true;
    setTimeout(() => {
        showToast.value = false;
    }, 4500);
};

// Form state
const mockEmail = ref('');
const submitMockForm = () => {
    isFormOpen.value = false;
    triggerToast(`Newsletter invitation successfully dispatched to: ${mockEmail.value}`);
    mockEmail.value = '';
};
</script>

<template>
    <Head title="Premium UI Components — Modals & Alerts overlay" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <AlertCircle class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Modals & Popups Registry</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke dynamic modal cards and animated system toast notifications.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-5xl mx-auto">
            <Card>
                <template #title>Modal Overlays Catalog</template>
                <template #subtitle>Click buttons below to launch interactive viewport overlays.</template>

                <div class="flex flex-wrap items-center gap-5 pt-3">
                    <!-- Standard modal launcher -->
                    <button 
                        @click="isStandardOpen = true"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 hover:bg-gray-50 dark:hover:bg-gray-800 transition flex items-center gap-1.5 shadow-sm"
                    >
                        <Eye class="h-4 w-4" />
                        <span>Launch Standard Modal</span>
                    </button>

                    <!-- Success modal launcher -->
                    <button 
                        @click="isSuccessOpen = true"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-emerald-600 bg-emerald-500/10 border border-emerald-500/15 hover:bg-emerald-500/20 transition flex items-center gap-1.5"
                    >
                        <CheckCircle2 class="h-4 w-4" />
                        <span>Launch Success Modal</span>
                    </button>

                    <!-- Danger modal launcher -->
                    <button 
                        @click="isDangerOpen = true"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-rose-600 bg-rose-500/10 border border-rose-500/15 hover:bg-rose-500/20 transition flex items-center gap-1.5"
                    >
                        <ShieldAlert class="h-4 w-4" />
                        <span>Launch Danger Warning</span>
                    </button>

                    <!-- Form modal launcher -->
                    <button 
                        @click="isFormOpen = true"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-md shadow-accent/15 flex items-center gap-1.5"
                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                    >
                        <Layout class="h-4 w-4" />
                        <span>Launch Setup Form</span>
                    </button>
                </div>
            </Card>

            <Card>
                <template #title>Toast Notification Dispatchers</template>
                <template #subtitle>Push-style alert cards rendering dynamically near window boundary.</template>

                <div class="flex items-center gap-5 pt-3">
                    <button 
                        @click="triggerToast('System security audit completed: 0 threat metrics reported.')"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    >
                        Trigger Standard Audit Toast
                    </button>

                    <button 
                        @click="triggerToast('Database indices compaction completed. Refreshed cached data lists.')"
                        class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white dark:bg-gray-900 border border-gray-150 dark:border-gray-850 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    >
                        Trigger Index Refresh Toast
                    </button>
                </div>
            </Card>
        </div>

        <!-- 1. STANDARD MODAL OVERLAY -->
        <Modal :show="isStandardOpen" @close="isStandardOpen = false">
            <div class="p-6 md:p-8 flex flex-col gap-4">
                <div>
                    <h3 class="text-base md:text-lg font-extrabold text-gray-900 dark:text-white leading-none">Handshake telemetry index normal</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 font-semibold mt-1">Status report signed across cluster nodes.</p>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                    Regional server sectors indicate normal load parameters. Dynamic data packet flows align with performance thresholds.
                </p>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <SecondaryButton @click="isStandardOpen = false">Close Dashboard</SecondaryButton>
                    <PrimaryButton :class="[configStore.accentDetails.bg]" @click="isStandardOpen = false">Acknowledge</PrimaryButton>
                </div>
            </div>
        </Modal>

        <!-- 2. SUCCESS CONFIRMATION MODAL -->
        <Modal :show="isSuccessOpen" @close="isSuccessOpen = false" maxWidth="sm">
            <div class="p-6 md:p-8 flex flex-col items-center text-center gap-5">
                <span class="p-3.5 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/10 animate-bounce">
                    <CheckCircle2 class="h-8 w-8 stroke-[2.5]" />
                </span>
                <div>
                    <h3 class="text-base font-extrabold text-gray-900 dark:text-white leading-none">Database Backup Executed</h3>
                    <p class="text-xs text-gray-450 dark:text-gray-500 mt-1">Snapshot ledger saved to regional block vault.</p>
                </div>
                <button 
                    @click="isSuccessOpen = false"
                    class="w-full py-2.5 rounded-xl text-xs font-bold text-white transition-all shadow-md shadow-accent/15"
                    :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                >
                    Dismiss Notification
                </button>
            </div>
        </Modal>

        <!-- 3. DANGER WARNING MODAL -->
        <Modal :show="isDangerOpen" @close="isDangerOpen = false" maxWidth="sm">
            <div class="p-6 md:p-8 flex flex-col items-center text-center gap-5">
                <span class="p-3.5 rounded-full bg-rose-500/10 text-rose-500 border border-rose-500/10 animate-pulse">
                    <ShieldAlert class="h-8 w-8 stroke-[2.5]" />
                </span>
                <div>
                    <h3 class="text-base font-extrabold text-gray-900 dark:text-white leading-none">Decommission Cluster Sectors?</h3>
                    <p class="text-xs text-gray-450 dark:text-gray-500 mt-1">This operation cannot be undone. Target database node data will be permanently wiped.</p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <button 
                        @click="isDangerOpen = false; triggerToast('Cluster decommissioning operation aborted safely.')"
                        class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition shadow"
                    >
                        Confirm Wiping Operation
                    </button>
                    <SecondaryButton @click="isDangerOpen = false">Abort Session</SecondaryButton>
                </div>
            </div>
        </Modal>

        <!-- 4. FORM SETUP MODAL -->
        <Modal :show="isFormOpen" @close="isFormOpen = false">
            <form @submit.prevent="submitMockForm" class="p-6 md:p-8 flex flex-col gap-6">
                <div>
                    <h3 class="text-base md:text-lg font-extrabold text-gray-900 dark:text-white leading-none">Register Newsletter Invitation</h3>
                    <p class="text-xs text-gray-450 dark:text-gray-500 mt-1">Register client email for structural news releases.</p>
                </div>
                
                <FloatingInput 
                    id="mock_email" 
                    v-model="mockEmail" 
                    label="Client Email (e.g. alexander@example.com)" 
                    type="email"
                    required 
                />

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-150 dark:border-gray-800">
                    <SecondaryButton @click="isFormOpen = false">Cancel</SecondaryButton>
                    <PrimaryButton type="submit" :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]">Dispatch Invite</PrimaryButton>
                </div>
            </form>
        </Modal>

        <!-- Floating toast panel -->
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
