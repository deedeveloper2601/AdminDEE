<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { MailCheck, Loader2, Send, LogOut } from 'lucide-vue-next';

const props = defineProps({
    status: { type: String },
});

const form = useForm({});
const submit = () => form.post(route('verification.send'));
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="Verify Email — AdminDEE" />

        <!-- Header -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl mb-4 border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/30">
                <MailCheck class="h-7 w-7 text-amber-500" />
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Verify your email</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you.
            </p>
        </div>

        <!-- Success Status -->
        <div v-if="verificationLinkSent" class="mb-5 flex items-center gap-2 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/30 px-4 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-400">
            <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
            A new verification link has been sent to your email address.
        </div>

        <form @submit.prevent="submit">
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90 active:scale-[.98]"
                style="background: var(--accent-color); --tw-ring-color: var(--accent-color)"
            >
                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                <Send v-else class="h-4 w-4" />
                {{ form.processing ? 'Sending...' : 'Resend verification email' }}
            </button>
        </form>

        <div class="mt-5 text-center">
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 transition-colors"
            >
                <LogOut class="h-3.5 w-3.5" />
                Log out
            </Link>
        </div>
    </GuestLayout>
</template>
