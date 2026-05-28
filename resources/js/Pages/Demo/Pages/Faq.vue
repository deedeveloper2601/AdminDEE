<script setup>
import { ref, computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Card from '@/Components/Card.vue';
import { 
    HelpCircle,
    Search,
    ChevronDown
} from 'lucide-vue-next';

const configStore = useConfigStore();

const faqs = ref([
    { id: 1, q: 'How do I adjust database connection timeouts?', a: 'Navigate to the structural Layout Options or Advanced Forms panel to configure cluster settings. Active values range between 10ms and 300ms.', open: true },
    { id: 2, q: 'Are weekly telemetry logs enabled by default?', a: 'Yes. Standard Sandbox licensing plans include weekly telemetry audit dispatchers directly to registered client profiles.', open: false },
    { id: 3, q: 'How can I print client billing invoice files?', a: 'Open the printable Invoice detail screen and click the primary "Print Invoice" trigger button. Custom layouts omit the sidebar during print execution.', open: false }
]);

const searchQuery = ref('');

const filteredFaqs = computed(() => {
    if (!searchQuery.value.trim()) return faqs.value;
    const query = searchQuery.value.toLowerCase();
    return faqs.value.filter(f => f.q.toLowerCase().includes(query) || f.a.toLowerCase().includes(query));
});

const toggleFaq = (f) => {
    f.open = !f.open;
};
</script>

<template>
    <Head title="Premium FAQ Accordion Dashboard" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-pulse">
                        <HelpCircle class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Frequently Answered Queries</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke accordion list answering corporate platform inquiries.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-6 max-w-4xl mx-auto">
            <!-- Search field -->
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <Search class="h-5 w-5 text-gray-400" />
                </span>
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search FAQ catalog in real-time... (e.g. database, backup, print)"
                    class="w-full pl-11 pr-4 py-3 text-xs bg-white/70 dark:bg-gray-900/60 border border-gray-100 dark:border-gray-900 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                    :class="[configStore.accentDetails.ring]"
                />
            </div>

            <!-- Accordion cards -->
            <Card>
                <template #title>Interactive Answer Catalog</template>
                <template #subtitle>Expand dynamic slots to read corresponding platform answers.</template>

                <div class="flex flex-col gap-3.5 mt-4">
                    <div 
                        v-for="faq in filteredFaqs" 
                        :key="faq.id"
                        class="border border-gray-150 dark:border-gray-800 bg-gray-50/20 dark:bg-gray-950/10 rounded-2xl p-5 flex flex-col gap-2 transition hover:bg-gray-50 dark:hover:bg-gray-950/40"
                    >
                        <!-- Question header -->
                        <button 
                            @click="toggleFaq(faq)"
                            class="flex items-center justify-between gap-4 w-full text-left text-xs font-extrabold text-gray-900 dark:text-white focus:outline-none select-none"
                        >
                            <span>{{ faq.q }}</span>
                            <ChevronDown class="h-5 w-5 text-gray-400 transition-transform duration-200 shrink-0" :class="{ 'rotate-180 text-accent': faq.open }" />
                        </button>

                        <!-- Answer panel -->
                        <Transition
                            enter-active-class="transition duration-200 ease-out"
                            enter-from-class="max-h-0 opacity-0 overflow-hidden"
                            enter-to-class="max-h-40 opacity-100 overflow-hidden"
                            leave-active-class="transition duration-150 ease-in"
                            leave-from-class="max-h-40 opacity-100 overflow-hidden"
                            leave-to-class="max-h-0 opacity-0 overflow-hidden"
                        >
                            <div v-show="faq.open" class="text-xs text-gray-650 dark:text-gray-400 leading-relaxed pt-2.5 border-t border-gray-100 dark:border-gray-800 mt-1">
                                {{ faq.a }}
                            </div>
                        </Transition>
                    </div>

                    <div v-if="filteredFaqs.length === 0" class="text-center py-6 text-xs text-gray-400 font-semibold italic">
                        No matches found for "{{ searchQuery }}". Try searching standard keywords like "database" or "invoice".
                    </div>
                </div>
            </Card>
        </div>
    </AdminLayout>
</template>
