<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { 
    Sparkles, 
    Key,
    ArrowLeft,
    CheckCircle2
} from 'lucide-vue-next';

const configStore = useConfigStore();

const email = ref('');
const isSent = ref(false);

const submitRecovery = () => {
    if (email.value.trim()) {
        isSent.value = true;
    }
};
</script>

<template>
    <Head title="Premium Authentication — Password Recovery" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Key class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Security Key Recovery</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke credentials reset recovery portal mockup.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="max-w-md mx-auto py-8">
            <Card>
                <!-- Title header -->
                <div class="flex flex-col items-center text-center gap-2 mb-6">
                    <span class="p-2.5 rounded-2xl bg-accent-glow text-accent border border-accent/15">
                        <Key class="h-6 w-6" />
                    </span>
                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">Recover Security Phrase</h3>
                    <p class="text-xs text-gray-400 font-semibold leading-relaxed">Request reset signature links for administrative emails.</p>
                </div>

                <div 
                    v-if="isSent"
                    class="p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-800 dark:text-emerald-400 rounded-2xl flex items-start gap-3 text-xs leading-relaxed font-semibold my-4 animate-fade-in"
                >
                    <CheckCircle2 class="h-5 w-5 text-emerald-500 shrink-0 mt-0.5" />
                    <div>
                        <span class="font-extrabold block">Signature Dispatch Finished!</span>
                        Recovery handshake link successfully issued. Please inspect your credentials email inbox folder.
                    </div>
                </div>

                <form @submit.prevent="submitRecovery" class="space-y-4 pt-1" v-else>
                    <FloatingInput 
                        id="rec_email" 
                        v-model="email" 
                        label="Registered Corporate Email" 
                        type="email"
                        required 
                    />

                    <PrimaryButton 
                        type="submit" 
                        class="w-full py-3.5 mt-2 transition shadow-md shadow-accent/15 flex items-center justify-center gap-1.5"
                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                    >
                        <span>Issue Recovery Signature</span>
                    </PrimaryButton>
                </form>

                <div class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-5 flex items-center justify-center">
                    <Link :href="route('auth.login.mock')" class="text-accent hover:underline flex items-center gap-1">
                        <ArrowLeft class="h-3.5 w-3.5 stroke-[2.5]" /> Back to credentials Sync
                    </Link>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
