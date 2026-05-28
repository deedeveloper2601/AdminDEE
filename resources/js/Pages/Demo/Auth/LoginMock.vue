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
    Lock,
    Mail,
    ArrowRight
} from 'lucide-vue-next';

const configStore = useConfigStore();

const email = ref('admin@admindee.io');
const password = ref('password');
</script>

<template>
    <Head title="Premium Authentication — Login Entrance" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Lock class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Authentication Entry</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke credentials login portal mockup.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="max-w-md mx-auto py-8">
            <Card>
                <!-- Form title -->
                <div class="flex flex-col items-center text-center gap-2 mb-6">
                    <span class="p-2.5 rounded-2xl bg-accent-glow text-accent border border-accent/15">
                        <Sparkles class="h-6 w-6" />
                    </span>
                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white">Command Center Portal</h3>
                    <p class="text-xs text-gray-400 font-semibold leading-relaxed">Sign in to sync cluster telemetry nodes.</p>
                </div>

                <form @submit.prevent class="space-y-4 pt-1">
                    <FloatingInput 
                        id="login_email" 
                        v-model="email" 
                        label="Registered Email Address" 
                        type="email"
                        required 
                    />

                    <FloatingInput 
                        id="login_pwd" 
                        v-model="password" 
                        label="Security Key Phrase" 
                        type="password"
                        required 
                    />

                    <div class="flex items-center justify-between text-[11px] font-bold">
                        <label class="flex items-center gap-1.5 text-gray-550 select-none cursor-pointer">
                            <input type="checkbox" class="h-4 w-4 rounded border-gray-300 text-accent focus:ring-accent" checked />
                            <span>Remember token</span>
                        </label>
                        <Link :href="route('auth.forgot-password.mock')" class="text-accent hover:underline">Forgot Key Phrase?</Link>
                    </div>

                    <PrimaryButton 
                        type="button" 
                        class="w-full py-3.5 mt-2 transition shadow-md shadow-accent/15 flex items-center justify-center gap-1.5"
                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                    >
                        <span>Sync Credentials Handshake</span>
                        <ArrowRight class="h-4 w-4" />
                    </PrimaryButton>

                    <div class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-4">
                        Don't have a security key? <Link :href="route('auth.register.mock')" class="text-accent hover:underline">Create Register</Link>
                    </div>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>
