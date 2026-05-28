<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AdvancedTable from '@/Components/AdvancedTable.vue';
import { useConfirmDelete } from '@/Composables/useSweetAlert';
import { Users } from 'lucide-vue-next';

// --- MOCK USER DATA ---
const users = ref([
    { id: 1, name: 'Sophia Sterling',   email: 'sophia.sterling@example.com',   role: 'Admin',      status: 'Active',   joined: 'Jan 12, 2025' },
    { id: 2, name: 'Alexander Vance',   email: 'alexander.vance@example.com',   role: 'Editor',     status: 'Active',   joined: 'Feb 03, 2025' },
    { id: 3, name: 'Elena Rostova',     email: 'elena.rostova@example.com',     role: 'Subscriber', status: 'Inactive', joined: 'Mar 21, 2025' },
    { id: 4, name: 'Marcus Thorne',     email: 'marcus.thorne@example.com',     role: 'Editor',     status: 'Active',   joined: 'Apr 07, 2025' },
    { id: 5, name: 'Leila Vasquez',     email: 'leila.vasquez@example.com',     role: 'Subscriber', status: 'Suspended', joined: 'Apr 19, 2025' },
    { id: 6, name: 'Julian Drake',      email: 'julian.drake@example.com',      role: 'Admin',      status: 'Active',   joined: 'May 01, 2025' },
    { id: 7, name: 'Zara Montgomery',   email: 'zara.montgomery@example.com',   role: 'Editor',     status: 'Active',   joined: 'May 08, 2025' },
    { id: 8, name: 'Oliver Sterling',   email: 'oliver.sterling@example.com',   role: 'Subscriber', status: 'Inactive', joined: 'May 14, 2025' },
    { id: 9, name: 'Clara Oswald',      email: 'clara.oswald@example.com',      role: 'Editor',     status: 'Active',   joined: 'May 19, 2025' },
    { id: 10, name: 'Nathaniel West',   email: 'nathaniel.west@example.com',    role: 'Subscriber', status: 'Active',   joined: 'May 22, 2025' },
]);

const columns = [
    { key: 'name',   label: 'Name',       sortable: true,  align: 'left'   },
    { key: 'email',  label: 'Email',      sortable: true,  align: 'left'   },
    { key: 'role',   label: 'Role',       sortable: true,  align: 'center' },
    { key: 'status', label: 'Status',     sortable: true,  align: 'center' },
    { key: 'joined', label: 'Joined',     sortable: true,  align: 'left'   },
];

// --- BULK ACTION HANDLER ---
const handleBulkAction = async (payload) => {
    const { action, ids } = payload;

    if (action === 'delete') {
        const result = await useConfirmDelete({
            title: `Delete ${ids.length} user${ids.length > 1 ? 's' : ''}?`,
            text: 'These users will be permanently removed. This action cannot be undone.',
        });

        if (result.isConfirmed) {
            // In a real app, send to Inertia:
            // router.delete('/users/bulk', { data: { ids }, preserveScroll: true });

            // For demo: filter locally
            const idsSet = new Set(ids);
            users.value = users.value.filter(u => !idsSet.has(u.id));
        }
    }
};

// --- STATUS BADGE HELPER ---
const statusConfig = {
    Active:    { dot: 'bg-emerald-500', badge: 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20' },
    Inactive:  { dot: 'bg-gray-400',    badge: 'bg-gray-100 text-gray-600 dark:text-gray-400 border-gray-300/30 dark:border-gray-700' },
    Suspended: { dot: 'bg-rose-500',    badge: 'bg-rose-500/10 text-rose-700 dark:text-rose-400 border-rose-500/20' },
};

const roleConfig = {
    Admin:      'bg-violet-500/10 text-violet-700 dark:text-violet-400 border-violet-500/20',
    Editor:     'bg-blue-500/10 text-blue-700 dark:text-blue-400 border-blue-500/20',
    Subscriber: 'bg-gray-100 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700',
};
</script>

<template>
    <Head title="Users — Demo" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent">
                        <Users class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Users</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Manage user accounts and access levels.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6">
            <!-- Page Title Block -->
            <div class="bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 shadow-sm rounded-3xl p-6 flex flex-col gap-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-800 dark:text-white leading-tight">User Directory</h3>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-semibold">Select multiple users and bulk delete with a SweetAlert confirmation.</span>
                    </div>
                </div>

                <AdvancedTable
                    :columns="columns"
                    :rows="users"
                    selectable
                    @bulk-action="handleBulkAction"
                >
                    <!-- Role Column -->
                    <template #col-role="{ val }">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border"
                            :class="roleConfig[val] || roleConfig.Subscriber"
                        >
                            {{ val }}
                        </span>
                    </template>

                    <!-- Status Column -->
                    <template #col-status="{ val }">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border"
                            :class="statusConfig[val]?.badge || statusConfig.Inactive.badge"
                        >
                            <span
                                class="h-1.5 w-1.5 rounded-full mr-1.5"
                                :class="statusConfig[val]?.dot || 'bg-gray-400'"
                            ></span>
                            {{ val }}
                        </span>
                    </template>
                </AdvancedTable>
            </div>
        </div>
    </AdminLayout>
</template>
