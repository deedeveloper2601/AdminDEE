<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    FileText,
    Sparkles,
    Printer,
    Download,
    CreditCard
} from 'lucide-vue-next';

const configStore = useConfigStore();

// Invoice details
const invoice = ref({
    number: 'INV-2026-0849',
    date: 'May 25, 2026',
    due: 'June 08, 2026',
    client: 'Sterling Holdings Ltd.',
    address: '100 Pine Street, San Francisco, CA 94111',
    email: 'billing@sterling.com',
    items: [
        { id: 1, desc: 'SaaS Core Cluster License (Zone A Dedicated Nodes)', qty: 1, unit: 2450.00 },
        { id: 2, desc: 'Advanced API Integration Consultation Handshake Support', qty: 10, unit: 150.00 }
    ]
});

const subtotal = computed(() => {
    return invoice.value.items.reduce((acc, it) => acc + (it.qty * it.unit), 0);
});

const tax = computed(() => {
    return subtotal.value * 0.0825; // 8.25% CA Sales Tax
});

const total = computed(() => {
    return subtotal.value + tax.value;
});

const formatCurrency = (val) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
};

const triggerPrint = () => {
    window.print();
};
</script>

<template>
    <Head title="Premium Printable Billing Invoice" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full no-print">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <FileText class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Printable Client Invoice</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke printable billing transaction invoice. Click primary trigger to print document.</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button 
                        @click="triggerPrint"
                        class="flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white transition-all shadow-md"
                        :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                    >
                        <Printer class="h-3.5 w-3.5" />
                        <span>Print Invoice</span>
                    </button>
                </div>
            </div>
        </template>

        <div class="max-w-4xl mx-auto py-4 print:p-0">
            <Card class="print:border-none print:shadow-none print:bg-white print:text-black">
                <!-- Branding Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-100 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <span class="p-2 rounded-xl text-white font-bold bg-indigo-600">
                            <Sparkles class="h-5 w-5" />
                        </span>
                        <span class="font-extrabold text-xl tracking-tight text-gray-900 dark:text-white print:text-black">
                            AdminDEE Inc.
                        </span>
                    </div>
                    
                    <div class="flex flex-col sm:items-end text-left sm:text-right text-xs text-gray-400 dark:text-gray-500 print:text-gray-600">
                        <span class="font-bold">INVOICE: {{ invoice.number }}</span>
                        <span class="mt-0.5">Dispatched: {{ invoice.date }}</span>
                        <span>Due Term: {{ invoice.due }}</span>
                    </div>
                </div>

                <!-- Client Billing Address Info -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 py-6 text-xs text-gray-650 dark:text-gray-400 print:text-gray-800">
                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Billed From:</span>
                        <span class="font-extrabold text-gray-900 dark:text-white print:text-black">AdminDEE Corporate</span>
                        <span>100 Market Street, Suite 500</span>
                        <span>San Francisco, CA 94103</span>
                        <span>billing@admindee.io</span>
                    </div>

                    <div class="flex flex-col gap-1 sm:items-end sm:text-right">
                        <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Billed To:</span>
                        <span class="font-extrabold text-gray-900 dark:text-white print:text-black">{{ invoice.client }}</span>
                        <span>{{ invoice.address }}</span>
                        <span>{{ invoice.email }}</span>
                    </div>
                </div>

                <!-- Items breakdown table -->
                <div class="overflow-x-auto w-full py-4">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-150 dark:border-gray-800 print:border-gray-300 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider print:text-gray-600">
                                <th class="pb-3 pl-2">Line Description</th>
                                <th class="pb-3 text-right">Quantity</th>
                                <th class="pb-3 text-right">Unit Price</th>
                                <th class="pb-3 text-right pr-2">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-850 print:divide-gray-200">
                            <tr v-for="item in invoice.items" :key="item.id" class="print:text-black">
                                <td class="py-4 pl-2 font-extrabold text-gray-900 dark:text-white print:text-black">{{ item.desc }}</td>
                                <td class="py-4 text-right font-semibold text-gray-700 dark:text-gray-300 print:text-black">{{ item.qty }}</td>
                                <td class="py-4 text-right font-semibold text-gray-700 dark:text-gray-300 print:text-black font-mono">{{ formatCurrency(item.unit) }}</td>
                                <td class="py-4 text-right font-extrabold text-gray-900 dark:text-white print:text-black pr-2 font-mono">{{ formatCurrency(item.qty * item.unit) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Summary calculations block -->
                <div class="flex flex-col items-end gap-2 border-t border-gray-100 dark:border-gray-800 print:border-gray-300 pt-6 text-xs text-gray-650 dark:text-gray-400 print:text-gray-800">
                    <div class="flex gap-10">
                        <span>Subtotal:</span>
                        <span class="font-extrabold font-mono text-gray-900 dark:text-white print:text-black">{{ formatCurrency(subtotal) }}</span>
                    </div>
                    <div class="flex gap-10">
                        <span>CA Tax (8.25%):</span>
                        <span class="font-extrabold font-mono text-gray-900 dark:text-white print:text-black">{{ formatCurrency(tax) }}</span>
                    </div>
                    <div class="flex gap-10 text-sm border-t border-gray-50 dark:border-gray-850 print:border-gray-200 pt-2 font-extrabold">
                        <span class="text-gray-900 dark:text-white print:text-black">Grand Total:</span>
                        <span class="text-accent font-mono print:text-black">{{ formatCurrency(total) }}</span>
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>

<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
