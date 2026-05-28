<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { 
    Mail,
    Trash2,
    Inbox,
    Download,
    CornerUpLeft,
    Send
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Demo Mail contents
const mail = ref({
    sender: 'Sophia Sterling',
    email: 'sophia.sterling@example.com',
    subject: 'Inquiry: Marketing Performance Review V3',
    time: '10:45 AM (3 hours ago)',
    content: 'Hi Team,\n\nI reviewed the telemetry dashboards and marketing ledger checkout indices yesterday. We noticed active checkouts rose by +14.8% on standard cluster nodes.\n\nPlease verify connection timeouts are adjusted to 82ms before we execute production compaction cycles next week.\n\nWarm regards,\nSophia',
    attachment: 'marketing_review_ledger_2026.pdf',
    size: '2.4 MB'
});

const replyText = ref('');
const isReplying = ref(false);

const submitReply = () => {
    isReplying.value = true;
    setTimeout(() => {
        isReplying.value = false;
        replyText.value = '';
        router.visit(route('mailbox.inbox'));
    }, 2000);
};
</script>

<template>
    <Head title="Premium Dynamic Mailbox — View Message" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Mail class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Message Reader</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke email details inspector with downloadable attachments.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto">
            <!-- Sidebar folders (left) -->
            <div class="lg:col-span-3 flex flex-col gap-5">
                <Link 
                    :href="route('mailbox.inbox')"
                    class="w-full py-3.5 rounded-2xl text-xs font-extrabold text-white text-center transition-all shadow-md shadow-accent/15 block"
                    :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                >
                    Back to Inbox
                </Link>

                <Card class="!p-4">
                    <div class="flex flex-col gap-1 text-xs">
                        <Link 
                            :href="route('mailbox.inbox')"
                            class="flex items-center justify-between px-3 py-2.5 rounded-xl font-bold text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-950/45 text-left"
                        >
                            <span class="flex items-center gap-2"><Inbox class="h-5 w-5" /> Inbox</span>
                        </Link>
                    </div>
                </Card>
            </div>

            <!-- Mail Reader contents (right) -->
            <div class="lg:col-span-9 flex flex-col gap-6">
                <Card>
                    <template #title>Inspect Details</template>
                    <template #subtitle>Standard message read ledger.</template>

                    <!-- Mail details -->
                    <div class="flex flex-col gap-5 pt-3 text-xs">
                        <!-- Sender banner -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <span class="h-9 w-9 rounded-xl flex items-center justify-center font-bold text-white bg-indigo-600 shadow-sm shrink-0">SS</span>
                                <div class="flex flex-col">
                                    <span class="font-extrabold text-gray-900 dark:text-white">{{ mail.sender }}</span>
                                    <span class="text-[10px] text-gray-400 font-semibold">{{ mail.email }}</span>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-450 font-bold">{{ mail.time }}</span>
                        </div>

                        <!-- Subject -->
                        <h3 class="text-sm font-extrabold text-gray-900 dark:text-white">{{ mail.subject }}</h3>

                        <!-- Body text -->
                        <div class="whitespace-pre-wrap text-gray-650 dark:text-gray-400 leading-relaxed font-semibold bg-gray-50/40 dark:bg-gray-950/10 border border-gray-50 dark:border-gray-850/80 p-5 rounded-2xl">
                            {{ mail.content }}
                        </div>

                        <!-- Attachment card -->
                        <div class="flex flex-col gap-2">
                            <span class="text-[10px] font-extrabold text-gray-450 dark:text-gray-500 uppercase tracking-wider block mb-1">Attached Files (1)</span>
                            <div class="p-3.5 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100/50 dark:border-gray-900/40 rounded-2xl flex items-center justify-between gap-4 max-w-sm">
                                <div class="flex items-center gap-2.5">
                                    <span class="p-2 rounded-xl bg-accent-glow text-accent border border-accent/10">
                                        <Download class="h-4 w-4" />
                                    </span>
                                    <div class="flex flex-col gap-0.5 leading-none">
                                        <span class="font-bold text-gray-800 dark:text-gray-200 text-[11px] truncate max-w-[150px]">{{ mail.attachment }}</span>
                                        <span class="text-[9px] text-gray-400 font-semibold">{{ mail.size }}</span>
                                    </div>
                                </div>
                                <button class="p-1.5 text-gray-400 hover:text-accent rounded-lg transition focus:outline-none">
                                    <Download class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <!-- Quick reply box -->
                        <div class="border-t border-gray-100 dark:border-gray-800 pt-5 mt-4">
                            <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-2.5 flex items-center gap-1"><CornerUpLeft class="h-4 w-4 text-accent" /> Quick Instant Reply</span>
                            <form @submit.prevent="submitReply" class="flex flex-col gap-3">
                                <textarea 
                                    v-model="replyText"
                                    rows="4" 
                                    placeholder="Write quick message reply here..."
                                    class="w-full p-4 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-450 transition focus:outline-none focus:bg-white dark:focus:bg-gray-900 focus:ring-1 focus:ring-accent"
                                    required
                                ></textarea>
                                <div class="flex justify-end">
                                    <PrimaryButton 
                                        type="submit" 
                                        :disabled="isReplying"
                                        class="flex items-center gap-1.5 px-5 py-2.5 shadow-md shadow-accent/15"
                                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                                    >
                                        <Send class="h-4 w-4" />
                                        <span>{{ isReplying ? 'Delivering Reply...' : 'Send Quick Reply' }}</span>
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
