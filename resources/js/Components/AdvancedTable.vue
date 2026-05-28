<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { useConfigStore } from '@/stores/config';
import { utils, write } from 'xlsx';
import { jsPDF } from 'jspdf';
import autoTable from 'jspdf-autotable';
import DangerButton from '@/Components/DangerButton.vue';
import { 
    Search, 
    ChevronUp, 
    ChevronDown, 
    ChevronsUpDown, 
    Trash2, 
    Trash,
    Download, 
    Archive, 
    Sliders,
    ChevronLeft,
    ChevronRight,
    Eye
} from 'lucide-vue-next';

const props = defineProps({
    columns: {
        type: Array,
        required: true,
        // Column schema: { key: String, label: String, sortable?: Boolean, align?: 'left'|'center'|'right', render?: Function }
    },
    rows: {
        type: Array,
        required: true
    },
    selectable: {
        type: Boolean,
        default: false
    },
    bulkActions: {
        type: Array,
        default: () => [
            { id: 'delete', label: 'Delete Selected', icon: Trash2, class: 'bg-rose-600 hover:bg-rose-700 text-white' },
            { id: 'export', label: 'Export Data', icon: Download, class: 'bg-emerald-600 hover:bg-emerald-700 text-white' }
        ]
    }
});

const emit = defineEmits(['selection-change', 'bulk-action', 'row-click']);

const configStore = useConfigStore();

// --- STATE ---
const searchFilter = ref('');
const density = ref('normal'); // 'compact' | 'normal' | 'relaxed'
const sortColumn = ref('');
const sortDirection = ref('none'); // 'asc' | 'desc' | 'none'
const currentPage = ref(1);
const pageSize = ref(10);
const selectedItems = ref([]);

// --- GETTERS & COMPUTED ---
// Localized classes based on density
const densityClasses = computed(() => {
    switch (density.value) {
        case 'compact':
            return {
                cell: 'py-2 px-3 text-xs',
                header: 'py-2 px-3 text-xs font-semibold'
            };
        case 'relaxed':
            return {
                cell: 'py-5 px-6 text-base',
                header: 'py-4 px-6 text-sm font-bold'
            };
        case 'normal':
        default:
            return {
                cell: 'py-3.5 px-4 text-sm',
                header: 'py-3 px-4 text-xs font-semibold'
            };
    }
});

// Row identifier (uses 'id' or index)
const getRowId = (row, index) => {
    return row.id !== undefined ? row.id : index;
};

// 1. Filtering Logic
const filteredRows = computed(() => {
    if (!searchFilter.value.trim()) return props.rows;
    
    const query = searchFilter.value.toLowerCase().trim();
    return props.rows.filter(row => {
        return props.columns.some(col => {
            const val = row[col.key];
            if (val === null || val === undefined) return false;
            return String(val).toLowerCase().includes(query);
        });
    });
});

// 2. Sorting Logic
const sortedRows = computed(() => {
    const rowsCopy = [...filteredRows.value];
    if (!sortColumn.value || sortDirection.value === 'none') {
        return rowsCopy;
    }

    const key = sortColumn.value;
    const dir = sortDirection.value === 'asc' ? 1 : -1;

    rowsCopy.sort((a, b) => {
        let valA = a[key];
        let valB = b[key];

        // Format to comparable values
        if (typeof valA === 'string') valA = valA.toLowerCase();
        if (typeof valB === 'string') valB = valB.toLowerCase();

        if (valA === null || valA === undefined) return 1 * dir;
        if (valB === null || valB === undefined) return -1 * dir;

        if (valA < valB) return -1 * dir;
        if (valA > valB) return 1 * dir;
        return 0;
    });

    return rowsCopy;
});

// 3. Pagination Logic
const paginatedRows = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    const end = start + pageSize.value;
    return sortedRows.value.slice(start, end);
});

const totalPages = computed(() => {
    return Math.ceil(sortedRows.value.length / pageSize.value) || 1;
});

// Reset page when filter changes
watch([searchFilter, pageSize], () => {
    currentPage.value = 1;
});

// --- BULK SELECTION ---
const isAllSelected = computed(() => {
    const pageRows = paginatedRows.value;
    if (pageRows.length === 0) return false;
    return pageRows.every(row => selectedItems.value.includes(getRowId(row)));
});

const isSomeSelected = computed(() => {
    const pageRows = paginatedRows.value;
    if (pageRows.length === 0) return false;
    const selectedInPage = pageRows.filter(row => selectedItems.value.includes(getRowId(row)));
    return selectedInPage.length > 0 && selectedInPage.length < pageRows.length;
});

const selectedRows = computed(() => {
    return props.rows.filter(row => selectedItems.value.includes(getRowId(row)));
});

const toggleAll = () => {
    const pageRows = paginatedRows.value;
    if (isAllSelected.value) {
        // Deselect all on current page
        const pageRowIds = pageRows.map(row => getRowId(row));
        selectedItems.value = selectedItems.value.filter(id => !pageRowIds.includes(id));
    } else {
        // Select all on current page
        const pageRowIds = pageRows.map(row => getRowId(row));
        const newSelection = [...selectedItems.value];
        pageRowIds.forEach(id => {
            if (!newSelection.includes(id)) {
                newSelection.push(id);
            }
        });
        selectedItems.value = newSelection;
    }
};

const toggleRow = (row, index) => {
    const id = getRowId(row, index);
    const pos = selectedItems.value.indexOf(id);
    if (pos > -1) {
        selectedItems.value.splice(pos, 1);
    } else {
        selectedItems.value.push(id);
    }
};

const clearSelection = () => {
    selectedItems.value = [];
};

// Watch selectedItems to auto-emit changes
watch(selectedItems, () => {
    emit('selection-change', selectedRows.value);
}, { deep: true });

// --- SORTING ACTION ---
const handleSort = (col) => {
    if (!col.sortable) return;

    if (sortColumn.value !== col.key) {
        sortColumn.value = col.key;
        sortDirection.value = 'asc';
    } else {
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc';
        } else if (sortDirection.value === 'desc') {
            sortDirection.value = 'none';
            sortColumn.value = '';
        } else {
            sortDirection.value = 'asc';
        }
    }
};

// --- PAGINATION NAVIGATION ---
const prevPage = () => {
    if (currentPage.value > 1) currentPage.value--;
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) currentPage.value++;
};

const setPage = (p) => {
    currentPage.value = p;
};

// --- BULK ACTION EMITTER ---
const handleBulkAction = (actionId) => {
    emit('bulk-action', { action: actionId, rows: selectedRows.value });
    clearSelection();
};

const handleBulkDelete = () => {
    emit('bulk-action', { action: 'delete', ids: [...selectedItems.value] });
    clearSelection();
};

// --- EXPORT FUNCTIONALITY ---
const showExportDropdown = ref(false);
const exportDropdownRef = ref(null);

const handleClickOutside = (event) => {
    if (exportDropdownRef.value && !exportDropdownRef.value.contains(event.target)) {
        showExportDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

const stripHtml = (html) => {
    if (typeof html !== 'string') return html;
    return html.replace(/<\/?[^>]+(>|$)/g, '').trim();
};

const cleanValue = (val) => {
    if (val === null || val === undefined) return '';
    if (typeof val === 'object') {
        if (val.__v_isVNode || typeof val.render === 'function' || val.setup || val.template) {
            return '';
        }
        return String(val);
    }
    if (typeof val === 'function') return '';
    if (typeof val === 'string') return stripHtml(val);
    return val;
};

const exportableData = computed(() => {
    return sortedRows.value.map(row => {
        const item = {};
        props.columns.forEach(col => {
            let val = row[col.key];
            if (col.render && typeof col.render === 'function') {
                try {
                    val = col.render(val, row);
                } catch (e) {
                    // Fallback to raw value
                }
            }
            const label = col.label || col.key;
            item[label] = cleanValue(val);
        });
        return item;
    });
});

const exportCSV = () => {
    const worksheet = utils.json_to_sheet(exportableData.value);
    const csvContent = utils.sheet_to_csv(worksheet);
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'export.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
};

const exportExcel = () => {
    const workbook = utils.book_new();
    const worksheet = utils.json_to_sheet(exportableData.value);
    utils.book_append_sheet(workbook, worksheet, 'Data Ledger');
    const excelBuffer = write(workbook, { bookType: 'xlsx', type: 'array' });
    const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'export.xlsx');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
};

const exportPDF = () => {
    const doc = new jsPDF();
    const headers = props.columns.map(col => col.label || col.key);
    const data = exportableData.value.map(row => 
        props.columns.map(col => row[col.label || col.key])
    );
    
    autoTable(doc, {
        head: [headers],
        body: data,
        styles: { fontSize: 9 },
        headStyles: { fillColor: [79, 70, 229] } // Elegant indigo theme accent
    });
    
    doc.save('export.pdf');
};

const getAlignmentClass = (align) => {
    if (align === 'center') return 'text-center justify-center';
    if (align === 'right') return 'text-right justify-end';
    return 'text-left justify-start';
};
</script>

<template>
    <div class="relative w-full flex flex-col gap-4">
        <!-- Controls Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 transition-all duration-300">
            <!-- Search Filter -->
            <div class="relative flex-1 max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <Search class="h-5 w-5 text-gray-400 dark:text-gray-500" />
                </span>
                <input
                    v-model="searchFilter"
                    type="text"
                    placeholder="Search across all columns..."
                    class="block w-full pl-10 pr-4 py-2 text-sm bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 focus:bg-white dark:focus:bg-gray-900"
                    :class="[configStore.accentDetails.border, configStore.accentDetails.ring]"
                />
            </div>

            <!-- Controls (Density & Page Size Selector) -->
            <div class="flex items-center gap-4 flex-wrap">
                <!-- Density Selector -->
                <div class="flex items-center bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-1">
                    <button
                        @click="density = 'compact'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200"
                        :class="density === 'compact' ? [configStore.accentDetails.bg, 'text-white shadow-sm'] : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100'"
                    >
                        Compact
                    </button>
                    <button
                        @click="density = 'normal'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200"
                        :class="density === 'normal' ? [configStore.accentDetails.bg, 'text-white shadow-sm'] : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100'"
                    >
                        Normal
                    </button>
                    <button
                        @click="density = 'relaxed'"
                        class="px-3 py-1.5 text-xs font-semibold rounded-md transition-all duration-200"
                        :class="density === 'relaxed' ? [configStore.accentDetails.bg, 'text-white shadow-sm'] : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100'"
                    >
                        Relaxed
                    </button>
                </div>

                <!-- Page Size Dropdown -->
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">Rows:</span>
                    <select
                        v-model="pageSize"
                        class="text-xs font-semibold bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg py-1.5 pl-2 pr-8 text-gray-700 dark:text-gray-300 transition-all focus:outline-none focus:ring-1 focus:ring-offset-0"
                        :class="[configStore.accentDetails.ring]"
                    >
                        <option :value="5">5</option>
                        <option :value="10">10</option>
                        <option :value="25">25</option>
                        <option :value="50">50</option>
                    </select>
                </div>

                <!-- Export Dropdown -->
                <div ref="exportDropdownRef" class="relative inline-block text-left">
                    <button
                        @click="showExportDropdown = !showExportDropdown"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 cursor-pointer shadow-sm"
                        :class="[configStore.accentDetails.border, configStore.accentDetails.ring]"
                    >
                        <Download class="h-3.5 w-3.5 text-gray-400 dark:text-gray-500" />
                        <span>Export</span>
                    </button>

                    <!-- Dropdown Options Panel -->
                    <Transition
                        enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95"
                        enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95"
                    >
                        <div
                            v-if="showExportDropdown"
                            class="absolute right-0 mt-1.5 w-40 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl shadow-xl py-1.5 z-50 text-xs flex flex-col font-medium divide-y divide-gray-100 dark:divide-gray-800"
                        >
                            <button
                                @click="exportCSV(); showExportDropdown = false"
                                class="px-4 py-2 text-left text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-gray-900 dark:hover:text-white transition cursor-pointer"
                            >
                                Export as CSV
                            </button>
                            <button
                                @click="exportExcel(); showExportDropdown = false"
                                class="px-4 py-2 text-left text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-gray-900 dark:hover:text-white transition cursor-pointer"
                            >
                                Export as Excel
                            </button>
                            <button
                                @click="exportPDF(); showExportDropdown = false"
                                class="px-4 py-2 text-left text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800/80 hover:text-gray-900 dark:hover:text-white transition cursor-pointer"
                            >
                                Export as PDF
                            </button>
                        </div>
                    </Transition>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="relative overflow-hidden bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl shadow-sm transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <!-- Selection Checkbox Header -->
                            <th v-if="selectable" scope="col" class="w-12 px-4 py-3 text-center">
                                <span class="sr-only">Select All</span>
                                <input
                                    type="checkbox"
                                    :checked="isAllSelected"
                                    :indeterminate="isSomeSelected"
                                    @change="toggleAll"
                                    class="h-4.5 w-4.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 transition cursor-pointer"
                                    :class="[configStore.accentDetails.text, configStore.accentDetails.ring]"
                                />
                            </th>

                            <!-- Dynamic Headers -->
                            <th
                                v-for="col in columns"
                                :key="col.key"
                                scope="col"
                                class="text-gray-500 dark:text-gray-400 tracking-wider transition-colors duration-150 select-none uppercase font-semibold"
                                :class="[
                                    densityClasses.header,
                                    col.sortable ? 'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800/80 hover:text-gray-700 dark:hover:text-gray-200' : '',
                                    getAlignmentClass(col.align)
                                ]"
                                @click="handleSort(col)"
                            >
                                <div class="flex items-center gap-1.5" :class="getAlignmentClass(col.align)">
                                    <span>{{ col.label }}</span>
                                    <span v-if="col.sortable">
                                        <ChevronUp v-if="sortColumn === col.key && sortDirection === 'asc'" class="h-3.5 w-3.5 text-indigo-600 dark:text-indigo-400" :class="configStore.accentDetails.text" />
                                        <ChevronDown v-else-if="sortColumn === col.key && sortDirection === 'desc'" class="h-3.5 w-3.5 text-indigo-600 dark:text-indigo-400" :class="configStore.accentDetails.text" />
                                        <ChevronsUpDown v-else class="h-3.5 w-3.5 text-gray-300 dark:text-gray-600" />
                                    </span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800 transition-all duration-300">
                        <tr
                            v-for="(row, idx) in paginatedRows"
                            :key="getRowId(row, idx)"
                            @click="$emit('row-click', row)"
                            class="hover:bg-gray-50/50 dark:hover:bg-gray-700/20 transition duration-150 cursor-pointer"
                            :class="{ 'selected-row-highlight': selectedItems.includes(getRowId(row, idx)) }"
                        >
                            <!-- Row Checkbox -->
                            <td v-if="selectable" class="w-12 px-4 py-3 text-center" @click.stop>
                                <input
                                    type="checkbox"
                                    v-model="selectedItems"
                                    :value="getRowId(row, idx)"
                                    class="h-4.5 w-4.5 rounded border-gray-300 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 transition cursor-pointer"
                                    :class="[configStore.accentDetails.text, configStore.accentDetails.ring]"
                                />
                            </td>

                            <!-- Dynamic Row Cells -->
                            <td
                                v-for="col in columns"
                                :key="col.key"
                                class="text-gray-900 dark:text-gray-300 whitespace-nowrap align-middle"
                                :class="[densityClasses.cell, getAlignmentClass(col.align)]"
                            >
                                <slot :name="`col-${col.key}`" :row="row" :val="row[col.key]">
                                    <template v-if="col.render">
                                        <span v-html="col.render(row[col.key], row)"></span>
                                    </template>
                                    <template v-else>
                                        {{ row[col.key] }}
                                    </template>
                                </slot>
                            </td>
                        </tr>

                        <!-- Empty State -->
                        <tr v-if="paginatedRows.length === 0">
                            <td :colspan="selectable ? columns.length + 1 : columns.length" class="text-center py-12">
                                <Sliders class="h-10 w-10 mx-auto text-gray-300 dark:text-gray-600 mb-3 stroke-[1.5]" />
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">No results found</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Try adjusting your search filters or check your spelling.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination Controls -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/10">
                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                    Showing <span class="font-bold text-gray-800 dark:text-gray-200">{{ Math.min((currentPage - 1) * pageSize + 1, sortedRows.length) }}</span> to
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ Math.min(currentPage * pageSize, sortedRows.length) }}</span> of
                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ sortedRows.length }}</span> items
                </div>

                <!-- Page Buttons -->
                <div class="flex items-center gap-1.5">
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition text-gray-600 dark:text-gray-400"
                    >
                        <ChevronLeft class="h-4 w-4" />
                    </button>

                    <template v-for="p in totalPages" :key="p">
                        <button
                            v-if="p === 1 || p === totalPages || Math.abs(p - currentPage) <= 1"
                            @click="setPage(p)"
                            class="min-w-[32px] h-8 px-2 text-xs font-semibold rounded-lg border transition-all duration-200"
                            :class="p === currentPage 
                                ? [configStore.accentDetails.bg, 'text-white border-transparent shadow-sm'] 
                                : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300'"
                        >
                            {{ p }}
                        </button>
                        <span 
                            v-else-if="p === 2 && Math.abs(1 - currentPage) > 2" 
                            class="text-gray-400 dark:text-gray-600 px-1 text-xs"
                        >
                            ...
                        </span>
                        <span 
                            v-else-if="p === totalPages - 1 && Math.abs(totalPages - currentPage) > 2" 
                            class="text-gray-400 dark:text-gray-600 px-1 text-xs"
                        >
                            ...
                        </span>
                    </template>

                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="p-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition text-gray-600 dark:text-gray-400"
                    >
                        <ChevronRight class="h-4 w-4" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Floating Bulk Action Bar -->
        <Transition
            enter-active-class="transform transition ease-out duration-300"
            enter-from-class="translate-y-10 opacity-0"
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transform transition ease-in duration-200"
            leave-from-class="translate-y-0 opacity-100"
            leave-to-class="translate-y-10 opacity-0"
        >
            <div
                v-if="selectedItems.length > 0"
                class="absolute bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center justify-between gap-6 px-6 py-3 bg-gray-900/90 dark:bg-gray-950/90 backdrop-blur-md rounded-full shadow-2xl border border-gray-800/50 text-white min-w-[320px] max-w-xl w-full"
            >
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-gray-200">
                        {{ selectedItems.length }} items selected
                    </span>
                    <button 
                        @click="clearSelection" 
                        class="text-xs font-semibold text-gray-400 hover:text-white underline underline-offset-2 hover:no-underline transition cursor-pointer"
                    >
                        Clear
                    </button>
                </div>

                <div class="flex items-center gap-2">
                    <DangerButton
                        @click="handleBulkDelete"
                        class="flex items-center gap-1.5 !rounded-full px-4 py-2 !text-xs font-bold shadow-sm transition duration-150 cursor-pointer"
                    >
                        <Trash class="h-3.5 w-3.5" />
                        <span>Bulk Delete</span>
                    </DangerButton>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.selected-row-highlight {
    background-color: var(--accent-color-light) !important;
}
</style>
