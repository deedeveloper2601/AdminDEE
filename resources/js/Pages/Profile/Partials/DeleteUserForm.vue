<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { Trash2, Lock, AlertTriangle, X, Loader2 } from 'lucide-vue-next';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({ password: '' });

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value?.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section>
        <!-- Section Header -->
        <div class="flex items-start gap-3 mb-5 pb-5 border-b border-red-100 dark:border-red-900/40">
            <div class="p-2 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-100 dark:border-red-900/50 shrink-0">
                <AlertTriangle class="h-4 w-4 text-red-500" />
            </div>
            <div>
                <h3 class="text-sm font-extrabold text-red-700 dark:text-red-400">Danger Zone — Delete Account</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Once deleted, all data is permanently removed. This cannot be undone.
                </p>
            </div>
        </div>

        <button
            @click="confirmUserDeletion"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all duration-200 active:scale-[.98] focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
        >
            <Trash2 class="h-4 w-4" />
            Delete my account
        </button>

        <!-- Confirmation Modal Overlay -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="confirmingUserDeletion"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-950/60 backdrop-blur-sm"
                @click.self="closeModal"
            >
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-2"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                    appear
                >
                    <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden">

                        <!-- Modal Header -->
                        <div class="flex items-start justify-between p-6 border-b border-gray-100 dark:border-gray-800">
                            <div class="flex items-start gap-3">
                                <div class="p-2 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-100 dark:border-red-900/50 shrink-0">
                                    <Trash2 class="h-4 w-4 text-red-500" />
                                </div>
                                <div>
                                    <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Delete your account?</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed">
                                        This will permanently erase all your data. Enter your password to confirm.
                                    </p>
                                </div>
                            </div>
                            <button
                                @click="closeModal"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition shrink-0"
                            >
                                <X class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="modal_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    Your password
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <Lock class="h-4 w-4 text-gray-400 dark:text-gray-500" />
                                    </span>
                                    <input
                                        id="modal_password"
                                        ref="passwordInput"
                                        type="password"
                                        v-model="form.password"
                                        placeholder="••••••••"
                                        @keyup.enter="deleteUser"
                                        class="block w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-0 focus:border-transparent focus:bg-white dark:focus:bg-gray-900"
                                        :class="{ 'border-red-400 dark:border-red-700': form.errors.password }"
                                    />
                                </div>
                                <InputError class="mt-1.5" :message="form.errors.password" />
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 px-6 pb-6">
                            <button
                                type="button"
                                @click="closeModal"
                                class="px-4 py-2.5 rounded-xl text-sm font-bold text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-200 active:scale-[.98]"
                            >
                                Cancel
                            </button>
                            <button
                                type="button"
                                @click="deleteUser"
                                :disabled="form.processing"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed active:scale-[.98]"
                            >
                                <Loader2 v-if="form.processing" class="h-4 w-4 animate-spin" />
                                <Trash2 v-else class="h-4 w-4" />
                                {{ form.processing ? 'Deleting...' : 'Yes, delete account' }}
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </section>
</template>
