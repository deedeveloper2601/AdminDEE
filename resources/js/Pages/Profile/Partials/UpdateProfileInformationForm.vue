<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { User, Mail, Loader2, Check, AlertCircle } from 'lucide-vue-next';

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <!-- Section Header -->
        <div class="flex items-start gap-3 mb-6 pb-5 border-b border-gray-100 dark:border-gray-800">
            <div class="p-2 rounded-xl bg-blue-50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/50 shrink-0">
                <User class="h-4 w-4 text-blue-500" />
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Profile Information</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update your display name and email address.</p>
            </div>
        </div>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-5">

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
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.name }"
                        style="--tw-ring-color: var(--accent-color)"
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
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.email }"
                        style="--tw-ring-color: var(--accent-color)"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.email" />
            </div>

            <!-- Unverified Email Warning -->
            <div v-if="mustVerifyEmail && user.email_verified_at === null"
                 class="flex items-start gap-2.5 rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-950/30 px-4 py-3">
                <AlertCircle class="h-4 w-4 text-amber-500 shrink-0 mt-0.5" />
                <div class="text-xs text-amber-700 dark:text-amber-400">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="font-semibold underline hover:no-underline ml-1"
                    >
                        Resend verification email
                    </Link>
                </div>
            </div>

            <div v-if="status === 'verification-link-sent'"
                 class="flex items-center gap-2 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/30 px-4 py-3 text-xs font-medium text-emerald-700 dark:text-emerald-400">
                <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
                Verification link sent to your email.
            </div>

            <!-- Save Row -->
            <div class="flex items-center gap-3 pt-1">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white shadow-sm transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed hover:opacity-90 active:scale-[.98]"
                    style="background: var(--accent-color)"
                >
                    <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                    <Check v-else class="h-4 w-4" />
                    {{ form.processing ? 'Saving...' : 'Save changes' }}
                </button>

                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 translate-x-2"
                    enter-to-class="opacity-100 translate-x-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <span v-if="form.recentlySuccessful"
                          class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                        <Check class="h-3.5 w-3.5" /> Saved!
                    </span>
                </Transition>
            </div>
        </form>
    </section>
</template>
