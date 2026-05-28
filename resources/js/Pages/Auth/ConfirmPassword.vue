<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Lock, Loader2, ShieldCheck } from 'lucide-vue-next';

const form = useForm({ password: '' });

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password — AdminDEE" />

        <!-- Header -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-2xl mb-4 border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/30">
                <ShieldCheck class="h-7 w-7 text-blue-500" />
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Secure area</h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                This is a protected area. Please confirm your password to continue.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Your password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autofocus
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90 active:scale-[.98]"
                style="background: var(--accent-color); --tw-ring-color: var(--accent-color)"
            >
                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                <ShieldCheck v-else class="h-4 w-4" />
                {{ form.processing ? 'Confirming...' : 'Confirm password' }}
            </button>
        </form>
    </GuestLayout>
</template>
