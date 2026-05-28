<script setup>
import { ref, computed, watch } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Card from '@/Components/Card.vue';
import Modal from '@/Components/Modal.vue';
import FloatingInput from '@/Components/FloatingInput.vue';
import SelectBox from '@/Components/SelectBox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import draggable from 'vuedraggable';
import * as LucideIcons from 'lucide-vue-next';
import { 
    Sparkles, 
    GripVertical, 
    Edit, 
    Trash2, 
    Plus, 
    Check, 
    Folder, 
    ChevronRight,
    HelpCircle,
    CheckCircle2
} from 'lucide-vue-next';
import { useConfigStore } from '@/stores/config';

const props = defineProps({
    menusList: {
        type: Array,
        required: true
    }
});

const configStore = useConfigStore();

// --- DRAG STATE ---
// Local copy of menus list to drive vuedraggable reactivity
const localMenus = ref(JSON.parse(JSON.stringify(props.menusList)));

// Keep local menus in sync when backend updates/props change
watch(() => props.menusList, (newVal) => {
    localMenus.value = JSON.parse(JSON.stringify(newVal));
}, { deep: true });

// --- TOAST NOTIFICATIONS ---
const showToast = ref(false);
const toastMessage = ref('');

const triggerToast = (msg) => {
    toastMessage.value = msg;
    showToast.value = true;
    setTimeout(() => {
        showToast.value = false;
    }, 4000);
};

// --- CRUD MODAL FORM STATE ---
const isModalOpen = ref(false);
const isEditMode = ref(false);
const editingItemId = ref(null);

const form = useForm({
    label: '',
    icon: '',
    route: '',
    url: '',
    parent_id: '',
    is_active: true
});

// Parent options for SelectBox (filters out editing item to avoid self-referencing loops)
const parentOptions = computed(() => {
    const list = [{ value: '', label: '-- None (Root Level) --' }];
    
    localMenus.value.forEach(item => {
        if (!isEditMode.value || item.id !== editingItemId.value) {
            list.push({ value: item.id, label: item.label });
        }
    });
    
    return list;
});

// Helper to convert DB kebab-case to PascalCase for icon rendering
const resolveIcon = (iconName) => {
    if (!iconName) return HelpCircle;
    const pascalName = iconName
        .split('-')
        .map(part => part.charAt(0).toUpperCase() + part.slice(1))
        .join('');
    return LucideIcons[pascalName] || HelpCircle;
};

// --- DRAG HANDLER ---
const onDragChange = () => {
    const flattened = [];
    localMenus.value.forEach((root, rootIndex) => {
        flattened.push({
            id: root.id,
            parent_id: null,
            sort_order: rootIndex
        });
        
        if (root.children) {
            root.children.forEach((child, childIndex) => {
                flattened.push({
                    id: child.id,
                    parent_id: root.id,
                    sort_order: childIndex
                });
            });
        }
    });

    router.post(route('admin.menus.reorder'), {
        items: flattened
    }, {
        preserveScroll: true,
        onSuccess: () => {
            triggerToast('Menu positions updated successfully.');
        }
    });
};

// --- FORM HANDLERS ---
const openAddModal = () => {
    isEditMode.value = false;
    editingItemId.value = null;
    form.reset();
    form.clearErrors();
    form.parent_id = '';
    form.is_active = true;
    isModalOpen.value = true;
};

const openEditModal = (item) => {
    isEditMode.value = true;
    editingItemId.value = item.id;
    form.clearErrors();
    form.label = item.label;
    form.icon = item.icon || '';
    form.route = item.route || '';
    form.url = item.url || '';
    form.parent_id = item.parent_id || '';
    form.is_active = item.is_active ?? true;
    isModalOpen.value = true;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('admin.menus.update', editingItemId.value), {
            preserveScroll: true,
            onSuccess: () => {
                isModalOpen.value = false;
                triggerToast('Menu item updated successfully.');
            }
        });
    } else {
        form.post(route('admin.menus.store'), {
            preserveScroll: true,
            onSuccess: () => {
                isModalOpen.value = false;
                triggerToast('Menu item created successfully.');
            }
        });
    }
};

const deleteItem = (item) => {
    if (confirm(`Are you sure you want to delete "${item.label}"? This will recursively delete all nested submenus.`)) {
        router.delete(route('admin.menus.destroy', item.id), {
            preserveScroll: true,
            onSuccess: () => {
                triggerToast('Menu item deleted successfully.');
            }
        });
    }
};
</script>

<template>
    <Head title="Menu Architect Builder" />

    <AdminLayout>
        <!-- Page Action Subheader -->
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent">
                        <Sparkles class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Menu Architect</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Reorder, structure, and create custom database-backed navigations.</span>
                    </div>
                </div>

                <PrimaryButton
                    type="button"
                    @click="openAddModal"
                    class="flex items-center gap-1.5 px-4 py-2 transition duration-150 rounded-xl text-white font-bold"
                    :class="[configStore.accentDetails.bg, configStore.accentDetails.hover, 'shadow-md']"
                >
                    <Plus class="h-4 w-4 stroke-[3]" />
                    <span>Add Item</span>
                </PrimaryButton>
            </div>
        </template>

        <!-- Main Workspace Area -->
        <div class="max-w-4xl mx-auto py-4">
            
            <Card class="relative">
                <template #title>
                    <span class="flex items-center gap-2">
                        <Folder class="h-5 w-5 text-accent" />
                        <span>Interactive Menu Tree</span>
                    </span>
                </template>
                <template #subtitle>
                    Drag grab handles up, down, or nest inside lists. Updates synchronize in real-time.
                </template>

                <!-- Root vuedraggable list -->
                <draggable
                    v-model="localMenus"
                    group="menus"
                    item-key="id"
                    handle=".drag-handle"
                    animation="220"
                    @change="onDragChange"
                    class="space-y-4 min-h-[150px]"
                    ghost-class="ghost-card"
                >
                    <template #item="{ element }">
                        <div class="border border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-gray-950/20 rounded-2xl p-4 flex flex-col gap-3 transition-all duration-300">
                            
                            <!-- Parent menu row -->
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <!-- Drag Handle -->
                                    <button class="drag-handle p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-grab active:cursor-grabbing rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                        <GripVertical class="h-4 w-4" />
                                    </button>

                                    <!-- Icon Component -->
                                    <span class="p-2 rounded-xl bg-accent-glow text-accent border border-accent/10 shrink-0">
                                        <component :is="resolveIcon(element.icon)" class="h-5 w-5" />
                                    </span>

                                    <!-- Description details -->
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <h4 class="font-extrabold text-sm text-gray-900 dark:text-white truncate">{{ element.label }}</h4>
                                            <span 
                                                class="text-[9px] font-bold px-1.5 py-0.5 rounded border"
                                                :class="element.is_active 
                                                    ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20' 
                                                    : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700'"
                                            >
                                                {{ element.is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 font-semibold truncate mt-0.5">
                                            <span v-if="element.route" class="font-mono">route('{{ element.route }}')</span>
                                            <span v-else-if="element.url" class="font-mono">{{ element.url }}</span>
                                            <span v-else class="italic">Parent container / Dropdown trigger</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <button 
                                        @click="openEditModal(element)"
                                        class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 rounded-xl transition"
                                        title="Edit Item"
                                    >
                                        <Edit class="h-4 w-4" />
                                    </button>
                                    <button 
                                        @click="deleteItem(element)"
                                        class="p-2 text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 rounded-xl transition"
                                        title="Delete Item"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>

                            <!-- Nested vuedraggable child container -->
                            <div class="pl-8 border-l-2 border-dashed border-gray-100 dark:border-gray-800 ml-4 flex flex-col gap-2.5">
                                <div class="flex items-center gap-1 text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider select-none mb-1">
                                    <span>Submenu Items</span>
                                    <ChevronRight class="h-3 w-3" />
                                </div>

                                <draggable
                                    v-model="element.children"
                                    group="submenus"
                                    item-key="id"
                                    handle=".sub-drag-handle"
                                    animation="220"
                                    @change="onDragChange"
                                    class="space-y-2.5 min-h-[50px]"
                                    ghost-class="ghost-card"
                                >
                                    <template #item="{ element: child }">
                                        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-850 rounded-xl p-3 flex items-center justify-between gap-4 transition duration-200 hover:border-gray-200 dark:hover:border-gray-800">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <button class="sub-drag-handle p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-grab active:cursor-grabbing rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                                    <GripVertical class="h-3.5 w-3.5" />
                                                </button>

                                                <span class="p-1.5 rounded-lg bg-gray-50 dark:bg-gray-950 text-gray-500 dark:text-gray-400 shrink-0">
                                                    <component :is="resolveIcon(child.icon)" class="h-4 w-4" />
                                                </span>

                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <h5 class="font-extrabold text-xs text-gray-800 dark:text-gray-200 truncate">{{ child.label }}</h5>
                                                        <span 
                                                            class="text-[8px] font-bold px-1 py-0.2 rounded border"
                                                            :class="child.is_active 
                                                                ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20' 
                                                                : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 border-gray-200 dark:border-gray-700'"
                                                        >
                                                            {{ child.is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>
                                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-semibold truncate mt-0.5 font-mono">
                                                        {{ child.route ? `route('${child.route}')` : (child.url || 'No Path') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1 shrink-0">
                                                <button 
                                                    @click="openEditModal(child)"
                                                    class="p-1.5 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 rounded-lg transition"
                                                >
                                                    <Edit class="h-3.5 w-3.5" />
                                                </button>
                                                <button 
                                                    @click="deleteItem(child)"
                                                    class="p-1.5 text-gray-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 rounded-lg transition"
                                                >
                                                    <Trash2 class="h-3.5 w-3.5" />
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </draggable>
                                
                                <div v-if="!element.children || element.children.length === 0" class="text-center py-4 bg-gray-50/20 dark:bg-gray-950/10 border border-dashed border-gray-100 dark:border-gray-850 rounded-xl text-[10px] text-gray-400 font-medium">
                                    No submenus active. Drag items here to nest under {{ element.label }}.
                                </div>
                            </div>
                        </div>
                    </template>
                </draggable>
            </Card>

        </div>

        <!-- CRUD MODAL POPUP -->
        <Modal :show="isModalOpen" maxWidth="lg" @close="isModalOpen = false">
            <div class="p-6 md:p-8 flex flex-col gap-6">
                <!-- Modal Title -->
                <div>
                    <h3 class="text-base md:text-lg font-extrabold text-gray-900 dark:text-white leading-none">
                        {{ isEditMode ? 'Modify Navigation Node' : 'Register Navigation Node' }}
                    </h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 font-semibold mt-1">
                        Configure dynamic sidebar database values.
                    </p>
                </div>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <!-- Label field -->
                    <FloatingInput 
                        id="form_label" 
                        v-model="form.label" 
                        label="Label Text (e.g. Analytics)" 
                        required 
                    />

                    <!-- Icon field -->
                    <FloatingInput 
                        id="form_icon" 
                        v-model="form.icon" 
                        label="Lucide Icon Name (e.g. bar-chart-3)" 
                    />

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Route field -->
                        <FloatingInput 
                            id="form_route" 
                            v-model="form.route" 
                            label="Route Name (e.g. dashboard)" 
                        />
                        <!-- URL field -->
                        <FloatingInput 
                            id="form_url" 
                            v-model="form.url" 
                            label="Direct URL Path (e.g. /profile)" 
                        />
                    </div>

                    <!-- Parent selector -->
                    <SelectBox 
                        id="form_parent" 
                        v-model="form.parent_id" 
                        label="Parent Dropdown Menu" 
                        :options="parentOptions" 
                    />

                    <!-- Active state checkbox -->
                    <div class="flex items-center gap-2 pt-2 px-1">
                        <input
                            type="checkbox"
                            id="form_active"
                            v-model="form.is_active"
                            class="h-4.5 w-4.5 rounded border-gray-300 focus:ring-accent text-accent"
                        />
                        <label for="form_active" class="text-xs font-bold text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                            Make item active and visible in sidebar
                        </label>
                    </div>

                    <!-- Error warnings -->
                    <div v-if="form.hasErrors" class="p-3 bg-rose-500/10 border border-rose-500/20 rounded-xl text-rose-500 text-xs font-semibold">
                        Please fill in all required fields and verify your inputs.
                    </div>

                    <!-- Actions panel -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-750">
                        <SecondaryButton type="button" @click="isModalOpen = false">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 text-white font-bold"
                            :class="[configStore.accentDetails.bg, configStore.accentDetails.hover]"
                        >
                            {{ isEditMode ? 'Update' : 'Create' }}
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>

        <!-- Dynamic Success Toast Notifications -->
        <Transition
            enter-active-class="transform transition ease-out duration-300"
            enter-from-class="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="showToast"
                class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-gray-800 dark:text-gray-200 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl shadow-black/5"
            >
                <CheckCircle2 class="h-5 w-5 text-emerald-500 shrink-0" />
                <span class="text-xs font-bold">{{ toastMessage }}</span>
            </div>
        </Transition>

    </AdminLayout>
</template>

<style scoped>
.ghost-card {
    opacity: 0.4;
    border-style: dashed !important;
    border-color: var(--accent-color) !important;
    background-color: var(--accent-color-glow) !important;
}
</style>
