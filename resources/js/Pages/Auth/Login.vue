<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Mail, Lock, Loader2, LogIn } from 'lucide-vue-next';

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Sign In — AdminDEE" />

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Welcome back</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Sign in to your AdminDEE account</p>
        </div>

        <!-- Status Message -->
        <div v-if="status" class="mb-5 flex items-center gap-2 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/30 px-4 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-400">
            <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-5">

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Email address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Mail class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="you@example.com"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        style="--tw-ring-color: var(--accent-color)"
                        :class="{ 'border-red-400 dark:border-red-700 bg-red-50 dark:bg-red-950/20': form.errors.email }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-xs font-semibold transition-colors hover:underline"
                        style="color: var(--accent-color)"
                    >
                        Forgot password?
                    </Link>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        style="--tw-ring-color: var(--accent-color)"
                        :class="{ 'border-red-400 dark:border-red-700 bg-red-50 dark:bg-red-950/20': form.errors.password }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2.5">
                <Checkbox id="remember" name="remember" v-model:checked="form.remember"
                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 transition" />
                <label for="remember" class="text-sm text-gray-600 dark:text-gray-400 cursor-pointer select-none">Remember me</label>
            </div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90 active:scale-[.98]"
                style="background: var(--accent-color); --tw-ring-color: var(--accent-color)"
            >
                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                <LogIn v-else class="h-4 w-4" />
                {{ form.processing ? 'Signing in...' : 'Sign in' }}
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Don't have an account?
            <Link :href="route('register')" class="font-semibold hover:underline transition-colors" style="color: var(--accent-color)">
                Create one
            </Link>
        </p>
    </GuestLayout>
</template>
