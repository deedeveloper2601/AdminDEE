<script setup>
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { 
    Mail,
    Send,
    Trash2,
    X,
    FileText,
    Inbox,
    AlertCircle
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Form state
const recipient = ref('');
const subject = ref('');
const draftContent = ref('');

const isSending = ref(false);

const sendEmail = () => {
    isSending.value = true;
    setTimeout(() => {
        isSending.value = false;
        router.visit(route('mailbox.inbox'));
    }, 2500);
};
</script>

<template>
    <Head title="Premium Dynamic Mailbox — Compose Draft" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <Mail class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Draft Composer</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke dynamic draft compose dashboard including file attachments.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto">
            <!-- Sidebar Navigation (left) -->
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
                            <span class="flex items-center gap-2"><Inbox class="h-4.5 w-4.5" /> Inbox</span>
                        </Link>
                    </div>
                </Card>
            </div>

            <!-- Composer form card (right) -->
            <div class="lg:col-span-9 flex flex-col gap-6">
                <Card>
                    <template #title>Write Mail Message</template>
                    <template #subtitle>Prepare draft details with clean structured inputs.</template>

                    <form @submit.prevent="sendEmail" class="space-y-4 pt-3">
                        <FloatingInput 
                            id="mail_to" 
                            v-model="recipient" 
                            label="Recipient Email Address (e.g. sophia.sterling@example.com)" 
                            type="email"
                            required 
                        />

                        <FloatingInput 
                            id="mail_sub" 
                            v-model="subject" 
                            label="Subject line" 
                            required 
                        />

                        <!-- Custom draft text area -->
                        <div class="flex flex-col gap-1">
                            <label class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-1">Message content</label>
                            <textarea 
                                v-model="draftContent"
                                rows="8"
                                placeholder="Start writing email body details..."
                                class="w-full p-4 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-150 dark:border-gray-850 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-450 transition focus:outline-none focus:bg-white dark:focus:bg-gray-900 focus:ring-1 focus:ring-accent"
                                required
                            ></textarea>
                        </div>

                        <!-- Actions panel -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                            <Link :href="route('mailbox.inbox')" class="flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-gray-650 hover:underline">
                                <Trash2 class="h-4 w-4" /> Discard
                            </Link>

                            <PrimaryButton 
                                type="submit" 
                                :disabled="isSending"
                                class="flex items-center gap-1.5 px-5 py-3 transition shadow-md shadow-accent/15"
                                :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                            >
                                <Send class="h-4 w-4" v-if="!isSending" />
                                <RefreshCw class="h-4 w-4 animate-spin" v-else />
                                <span>{{ isSending ? 'Delivering Draft...' : 'Send Message' }}</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
