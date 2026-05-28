<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Lock, Loader2, Check, ShieldCheck } from 'lucide-vue-next';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <!-- Section Header -->
        <div class="flex items-start gap-3 mb-6 pb-5 border-b border-gray-100 dark:border-gray-800">
            <div class="p-2 rounded-xl bg-violet-50 dark:bg-violet-950/30 border border-violet-100 dark:border-violet-900/50 shrink-0">
                <ShieldCheck class="h-4 w-4 text-violet-500" />
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">Update Password</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Use a long, random password to keep your account secure.</p>
            </div>
        </div>

        <form @submit.prevent="updatePassword" class="space-y-5">

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Current password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="current_password"
                        ref="currentPasswordInput"
                        type="password"
                        v-model="form.current_password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.current_password }"
                        style="--tw-ring-color: var(--accent-color)"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.current_password" />
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">New password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password"
                        ref="passwordInput"
                        type="password"
                        v-model="form.password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password }"
                        style="--tw-ring-color: var(--accent-color)"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Confirm new password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                    </span>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password_confirmation }"
                        style="--tw-ring-color: var(--accent-color)"
                    />
                </div>
                <InputError class="mt-1.5" :message="form.errors.password_confirmation" />
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
                    {{ form.processing ? 'Updating...' : 'Update password' }}
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
                        <Check class="h-3.5 w-3.5" /> Password updated!
                    </span>
                </Transition>
            </div>
        </form>
    </section>
</template>
