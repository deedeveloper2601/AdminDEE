<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import { computed } from 'vue';
import { User, Settings } from 'lucide-vue-next';

const configStore = useConfigStore();

defineProps({
    mustVerifyEmail: { type: Boolean },
    status: { type: String },
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const userInitials = computed(() => {
    if (!user.value?.name) return 'AD';
    const names = user.value.name.split(' ');
    return names.length >= 2
        ? `${names[0][0]}${names[1][0]}`.toUpperCase()
        : names[0].substring(0, 2).toUpperCase();
});
</script>

<template>
    <Head title="Profile — AdminDEE" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl border text-white" :class="configStore.accentDetails.bg" style="border-color: rgba(255,255,255,0.15)">
                        <Settings class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Settings</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Manage your profile and account security</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6 max-w-4xl">

            <!-- Profile Hero Card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <!-- Banner -->
                <div class="h-24 w-full" :style="`background: linear-gradient(135deg, var(--accent-color) 0%, color-mix(in srgb, var(--accent-color) 55%, #000) 100%)`">
                    <div class="h-full w-full opacity-10" style="background-image: linear-gradient(rgba(255,255,255,.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.8) 1px, transparent 1px); background-size: 30px 30px;"></div>
                </div>

                <!-- Avatar + Name -->
                <div class="px-6 pb-5 -mt-10 flex items-end gap-4">
                    <div
                        class="h-20 w-20 rounded-2xl border-4 border-white dark:border-gray-900 flex items-center justify-center text-2xl font-extrabold text-white shadow-lg shrink-0 bg-gradient-to-tr"
                        :class="[
                            configStore.accentColor === 'indigo'  ? 'from-indigo-600 to-violet-500' :
                            configStore.accentColor === 'violet'  ? 'from-violet-600 to-fuchsia-500' :
                            configStore.accentColor === 'emerald' ? 'from-emerald-600 to-teal-500' :
                            configStore.accentColor === 'amber'   ? 'from-amber-600 to-yellow-500' :
                            configStore.accentColor === 'rose'    ? 'from-rose-600 to-pink-500' :
                            'from-cyan-600 to-sky-500'
                        ]"
                    >
                        {{ userInitials }}
                    </div>
                    <div class="pb-1 min-w-0">
                        <p class="text-lg font-extrabold text-gray-900 dark:text-white truncate">{{ user?.name }}</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 truncate">{{ user?.email }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />
            </div>

            <!-- Update Password Card -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <UpdatePasswordForm />
            </div>

            <!-- Danger Zone — Delete Account -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-red-200 dark:border-red-900/60 shadow-sm p-6">
                <DeleteUserForm />
            </div>

        </div>
    </AdminLayout>
</template>
