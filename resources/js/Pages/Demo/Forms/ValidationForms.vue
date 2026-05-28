<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { 
    FileText,
    Sparkles,
    CheckCircle2,
    XCircle,
    AlertCircle
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Form validation variables
const email = ref('');
const password = ref('');
const password_confirmation = ref('');

// Live validation states
const isEmailValid = computed(() => {
    if (!email.value) return null;
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value);
});

const isPasswordLengthValid = computed(() => {
    if (!password.value) return null;
    return password.value.length >= 8;
});

const isPasswordMatching = computed(() => {
    if (!password_confirmation.value) return null;
    return password.value === password_confirmation.value;
});

const showSuccess = ref(false);
const submitForm = () => {
    if (isEmailValid.value && isPasswordLengthValid.value && isPasswordMatching.value) {
        showSuccess.value = true;
        setTimeout(() => {
            showSuccess.value = false;
            email.value = '';
            password.value = '';
            password_confirmation.value = '';
        }, 4000);
    }
};
</script>

<template>
    <Head title="Premium UI Components — Form Validation" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <FileText class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Form Validation Feeds</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke credentials register highlighting real-time frontend compliance indicators.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-8 max-w-4xl mx-auto">
            <Card>
                <template #title>Real-time Validator Registry</template>
                <template #subtitle>Fill form details to see visual confirmation parameters.</template>

                <form @submit.prevent="submitForm" class="space-y-5 pt-3 max-w-lg">
                    <!-- Email input -->
                    <div class="flex flex-col gap-1">
                        <FloatingInput 
                            id="val_email" 
                            v-model="email" 
                            label="Client Credentials Email" 
                            type="email"
                            required 
                        />
                        <span 
                            v-if="isEmailValid !== null" 
                            class="text-[9px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1.5 self-start uppercase mt-1.5"
                            :class="isEmailValid ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400'"
                        >
                            <component :is="isEmailValid ? CheckCircle2 : XCircle" class="h-3 w-3" />
                            {{ isEmailValid ? 'Email formatting valid' : 'Email syntax invalid' }}
                        </span>
                    </div>

                    <!-- Password input -->
                    <div class="flex flex-col gap-1">
                        <FloatingInput 
                            id="val_pwd" 
                            v-model="password" 
                            label="Security Key Phrase" 
                            type="password"
                            required 
                        />
                        <span 
                            v-if="isPasswordLengthValid !== null" 
                            class="text-[9px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1.5 self-start uppercase mt-1.5"
                            :class="isPasswordLengthValid ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400'"
                        >
                            <component :is="isPasswordLengthValid ? CheckCircle2 : XCircle" class="h-3 w-3" />
                            {{ isPasswordLengthValid ? 'Length threshold met' : 'Min 8 characters required' }}
                        </span>
                    </div>

                    <!-- Password confirmation input -->
                    <div class="flex flex-col gap-1">
                        <FloatingInput 
                            id="val_pwd_conf" 
                            v-model="password_confirmation" 
                            label="Confirm Security Key Phrase" 
                            type="password"
                            required 
                        />
                        <span 
                            v-if="isPasswordMatching !== null" 
                            class="text-[9px] font-bold px-1.5 py-0.5 rounded flex items-center gap-1.5 self-start uppercase mt-1.5"
                            :class="isPasswordMatching ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400'"
                        >
                            <component :is="isPasswordMatching ? CheckCircle2 : XCircle" class="h-3 w-3" />
                            {{ isPasswordMatching ? 'Password keys match' : 'Password keys do not match' }}
                        </span>
                    </div>

                    <!-- Actions panel -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                        <span class="text-[10px] text-gray-450 font-bold">Encrypted via secure tunnels</span>
                        
                        <PrimaryButton 
                            type="submit" 
                            :disabled="!isEmailValid || !isPasswordLengthValid || !isPasswordMatching"
                            class="px-5 py-3 transition shadow-md shadow-accent/15"
                            :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                        >
                            Submit Credentials
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
                <span class="text-xs font-bold">Credential record validations finalized successfully!</span>
            </div>
        </Transition>
    </AdminLayout>
</template>
