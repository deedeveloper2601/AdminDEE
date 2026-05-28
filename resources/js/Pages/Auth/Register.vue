<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { User, Mail, Lock, Loader2, UserPlus } from 'lucide-vue-next';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Create Account — AdminDEE" />

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Create your account</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Join AdminDEE and start managing smarter</p>
        </div>

        <form @submit.prevent="submit" class="space-y-5">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Full name</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <User class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="John Doe"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.name }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.name" />
            </div>

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
                        autocomplete="username"
                        placeholder="you@example.com"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.email }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.email" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Confirm password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-600 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password_confirmation }"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password_confirmation" />
            </div>

            <!-- Submit -->
            <button
                type="submit"
                :disabled="form.processing"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90 active:scale-[.98]"
                style="background: var(--accent-color); --tw-ring-color: var(--accent-color)"
            >
                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                <UserPlus v-else class="h-4 w-4" />
                {{ form.processing ? 'Creating account...' : 'Create account' }}
            </button>
        </form>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Already have an account?
            <Link :href="route('login')" class="font-semibold hover:underline transition-colors" style="color: var(--accent-color)">
                Sign in
            </Link>
        </p>
    </GuestLayout>
</template>
