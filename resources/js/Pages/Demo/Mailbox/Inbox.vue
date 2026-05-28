<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    Mail,
    Search,
    Star,
    Trash2,
    CheckSquare,
    Inbox,
    Send,
    AlertCircle,
    Archive
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Mail categories
const activeFolder = ref('inbox');

const mails = ref([
    { id: 1, sender: 'Sophia Sterling', subject: 'Inquiry: Marketing Performance Review V3', preview: 'Please confirm target metrics for checkout API parameters...', time: '10:45 AM', read: false, starred: true },
    { id: 2, sender: 'Alexander Vance', subject: 'System: Core Database Handshake Compaction', preview: 'Index sweeps completed successfully on European nodes...', time: 'Yesterday', read: true, starred: false },
    { id: 3, sender: 'Elena Rostova', subject: 'Partner: Workspace Admin Registration Invitation', preview: 'Signed request authorization dispatched for secure partners...', time: 'May 24', read: true, starred: false }
]);

const toggleStar = (mail) => {
    mail.starred = !mail.starred;
};

const deleteMail = (id) => {
    mails.value = mails.value.filter(m => m.id !== id);
};
</script>

<template>
    <Head title="Premium Dynamic Mailbox — Inbox" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Mail class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Dynamic Messaging Center</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke email inbox with folders, read trackers, and interactive starred categorizations.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto">
            <!-- Sidebar Folders (left) -->
            <div class="lg:col-span-3 flex flex-col gap-5">
                <Link 
                    :href="route('mailbox.compose')"
                    class="w-full py-3.5 rounded-2xl text-xs font-extrabold text-white text-center transition-all shadow-md shadow-accent/15 block"
                    :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                >
                    Compose Draft
                </Link>

                <Card class="!p-4">
                    <div class="flex flex-col gap-1 text-xs">
                        <button 
                            @click="activeFolder = 'inbox'"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl font-bold transition-all text-left"
                            :class="activeFolder === 'inbox' ? 'bg-accent/10 text-accent' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-950/45'"
                        >
                            <span class="flex items-center gap-2"><Inbox class="h-4.5 w-4.5" /> Inbox</span>
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-accent/25 text-accent font-bold">1</span>
                        </button>

                        <button 
                            @click="activeFolder = 'sent'"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl font-bold transition-all text-left"
                            :class="activeFolder === 'sent' ? 'bg-accent/10 text-accent' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-950/45'"
                        >
                            <span class="flex items-center gap-2"><Send class="h-4.5 w-4.5" /> Sent Drafts</span>
                        </button>

                        <button 
                            @click="activeFolder = 'spam'"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl font-bold transition-all text-left"
                            :class="activeFolder === 'spam' ? 'bg-accent/10 text-accent' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-950/45'"
                        >
                            <span class="flex items-center gap-2"><AlertCircle class="h-4.5 w-4.5" /> Spam</span>
                        </button>
                    </div>
                </Card>
            </div>

            <!-- Mail List Panel (right) -->
            <div class="lg:col-span-9 flex flex-col gap-6">
                <Card>
                    <template #title>Inbox Ledger ({{ mails.length }} items)</template>
                    <template #subtitle>Standard inbox ledger displaying transactional records.</template>

                    <!-- Search Mail -->
                    <div class="relative my-3 w-full">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <Search class="h-4 w-4 text-gray-400" />
                        </span>
                        <input 
                            type="text" 
                            placeholder="Fuzzy search messages subject or sender..."
                            class="w-full pl-10 pr-4 py-2 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                            :class="configStore.accentDetails.ring"
                        />
                    </div>

                    <!-- Inbox List -->
                    <div class="flex flex-col gap-2.5 mt-4">
                        <div 
                            v-for="mail in mails" 
                            :key="mail.id"
                            class="p-4 border border-gray-55/10 bg-gray-50/20 dark:bg-gray-950/10 rounded-2xl flex items-center justify-between gap-4 transition hover:bg-gray-50 dark:hover:bg-gray-950/40 hover:border-gray-200 dark:hover:border-gray-800"
                            :class="{ 'border-l-4 border-l-accent font-bold': !mail.read }"
                        >
                            <!-- Star, Sender and Subject -->
                            <div class="flex items-center gap-3.5 flex-1 min-w-0">
                                <!-- Star button -->
                                <button @click.stop="toggleStar(mail)" class="focus:outline-none">
                                    <Star class="h-4 w-4" :class="mail.starred ? 'fill-amber-400 text-amber-400' : 'text-gray-400'" />
                                </button>
                                
                                <div class="flex flex-col md:flex-row md:items-center gap-2.5 flex-1 min-w-0 text-xs">
                                    <Link :href="route('mailbox.read')" class="font-extrabold text-gray-900 dark:text-white shrink-0 hover:underline">
                                        {{ mail.sender }}
                                    </Link>
                                    <div class="min-w-0">
                                        <Link :href="route('mailbox.read')" class="text-gray-800 dark:text-gray-200 hover:text-accent font-semibold truncate block">
                                            {{ mail.subject }}
                                        </Link>
                                        <span class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold truncate block mt-0.5">{{ mail.preview }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions & Time -->
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-[10px] text-gray-400 font-bold whitespace-nowrap">{{ mail.time }}</span>
                                <button @click.stop="deleteMail(mail.id)" class="p-1 text-gray-400 hover:text-rose-600 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 rounded-lg transition focus:outline-none">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div v-if="mails.length === 0" class="text-center py-8 text-xs text-gray-400 font-semibold italic">
                            Your mail folder is completely empty. Keep up the clean inbox!
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
