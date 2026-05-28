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
    UserPlus,
    ArrowRight
} from 'lucide-vue-next';

const configStore = useConfigStore();

const name = ref('');
const email = ref('');
const password = ref('');
</script>

<template>
    <Head title="Premium Authentication — Register Entrance" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <UserPlus class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Authentication Register</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke dynamic signup credentials portal mockup.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="max-w-md mx-auto py-8">
            <Card>
                <!-- Title header -->
                <div class="flex flex-col items-center text-center gap-2 mb-6">
                    <span class="p-2.5 rounded-2xl bg-accent-glow text-accent border border-accent/15">
                        <Sparkles class="h-6 w-6" />
                    </span>
                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">Register Telemetry Account</h3>
                    <p class="text-xs text-gray-400 font-semibold leading-relaxed">Establish dynamic credential keys signed across sectors.</p>
                </div>

                <form @submit.prevent class="space-y-4 pt-1">
                    <FloatingInput 
                        id="reg_name" 
                        v-model="name" 
                        label="Client Administrator Name" 
                        required 
                    />

                    <FloatingInput 
                        id="reg_email" 
                        v-model="email" 
                        label="Corporate Email Address" 
                        type="email"
                        required 
                    />

                    <FloatingInput 
                        id="reg_pwd" 
                        v-model="password" 
                        label="Security Key Phrase" 
                        type="password"
                        required 
                    />

                    <PrimaryButton 
                        type="button" 
                        class="w-full py-3.5 mt-2 transition shadow-md shadow-accent/15 flex items-center justify-center gap-1.5"
                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                    >
                        <span>Establish Credentials Handshake</span>
                        <ArrowRight class="h-4 w-4" />
                    </PrimaryButton>

                    <div class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-4">
                        Already registered? <Link :href="route('auth.login.mock')" class="text-accent hover:underline">Sync Login</Link>
                    </div>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>
