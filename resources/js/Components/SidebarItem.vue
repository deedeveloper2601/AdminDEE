<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import * as LucideIcons from 'lucide-vue-next';
import { ChevronDown, HelpCircle } from 'lucide-vue-next';

// Define recursive component name to allow self-reference
defineOptions({
    name: 'SidebarItem'
});

const props = defineProps({
    menu: {
        type: Object,
        required: true
    },
    isCollapsed: {
        type: Boolean,
        default: false
    },
    isMobile: {
        type: Boolean,
        default: false
    }
});

const configStore = useConfigStore();
const page = usePage();
const isOpen = ref(false);

// --- COMPUTED STATE ---
const isHeader = computed(() => {
    return props.menu.icon === 'section-header';
});

const hasChildren = computed(() => {
    return props.menu.children && props.menu.children.length > 0;
});

// Check if current item matches active route or URL
const isActive = computed(() => {
    if (props.menu.route) {
        return typeof route !== 'undefined' ? route().current(props.menu.route) : false;
    }
    if (props.menu.url) {
        return page.url === props.menu.url || page.url.startsWith(props.menu.url + '?');
    }
    return false;
});

// Check if any child item is active (for auto-expansion)
const isChildActive = computed(() => {
    if (!hasChildren.value) return false;
    return props.menu.children.some(child => {
        if (child.route) {
            return typeof route !== 'undefined' ? route().current(child.route) : false;
        }
        if (child.url) {
            return page.url === child.url || page.url.startsWith(child.url + '?');
        }
        return false;
    });
});

// Resolve icon dynamically from database string
const iconComponent = computed(() => {
    if (!props.menu.icon) return HelpCircle;
    
    // Convert kebab-case (e.g. 'layout-dashboard') to PascalCase (e.g. 'LayoutDashboard')
    const pascalName = props.menu.icon
        .split('-')
        .map(part => part.charAt(0).toUpperCase() + part.slice(1))
        .join('');
        
    return LucideIcons[pascalName] || HelpCircle;
});

// Auto expand submenu if child is active on boot
onMounted(() => {
    if (isChildActive.value) {
        isOpen.value = true;
    }
});

const toggleDropdown = () => {
    if (hasChildren.value) {
        isOpen.value = !isOpen.value;
    }
};
</script>

<template>
    <div class="w-full flex flex-col">
        
        <!-- SECTION HEADER (Dynamic Category Separator) -->
        <template v-if="isHeader">
            <div 
                v-if="!isCollapsed || isMobile" 
                class="px-4 pt-5 pb-1.5 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider select-none"
            >
                {{ menu.label }}
            </div>
            <div v-else class="h-px bg-gray-100 dark:bg-gray-800/80 my-2 mx-4"></div>
        </template>

        <!-- DROPDOWN PARENT TRIGGER BUTTON (When item has nested submenus) -->
        <template v-else-if="hasChildren">
            <button
                type="button"
                @click="toggleDropdown"
                class="w-full flex items-center rounded-xl text-sm font-semibold transition-all duration-200 focus:outline-none relative group"
                :class="[
                    isChildActive
                        ? (configStore.isSidebarLight 
                            ? 'text-gray-900 bg-gray-100/80' 
                            : 'text-gray-900 dark:text-gray-100 bg-gray-50/50 dark:bg-gray-800/20')
                        : (configStore.isSidebarLight 
                            ? 'text-gray-650 hover:bg-gray-100/80 hover:text-gray-900' 
                            : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50/50 dark:hover:bg-gray-850/20 hover:text-gray-900 dark:hover:text-gray-100'),
                    isCollapsed && !isMobile ? 'justify-center p-3' : [configStore.densityClasses.navPadding, 'justify-between']
                ]"
            >
                <div class="flex items-center" :class="[isCollapsed && !isMobile ? '' : configStore.densityClasses.navGap]">
                    <component :is="iconComponent" class="h-5 w-5 shrink-0" />
                    <span v-if="!isCollapsed || isMobile" class="transition-opacity duration-300">{{ menu.label }}</span>
                </div>

                <!-- Chevron indicator for expandability -->
                <ChevronDown 
                    v-if="(!isCollapsed || isMobile)"
                    class="h-4 w-4 shrink-0 transition-transform duration-300 ease-out text-gray-400 dark:text-gray-500"
                    :class="{ 'rotate-180 text-accent': isOpen }"
                />

                <!-- Collapsed tooltip description -->
                <div 
                    v-if="isCollapsed && !isMobile"
                    class="absolute left-full ml-4 px-2.5 py-1.5 bg-gray-900 text-white text-xs font-semibold rounded-lg opacity-0 translate-x-2 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200 shadow-md whitespace-nowrap z-50"
                >
                    {{ menu.label }} (Submenu)
                </div>
            </button>

            <!-- Dynamic height recursive children container -->
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="max-h-0 opacity-0 overflow-hidden"
                enter-to-class="max-h-[500px] opacity-100 overflow-hidden"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="max-h-[500px] opacity-100 overflow-hidden"
                leave-to-class="max-h-0 opacity-0 overflow-hidden"
            >
                <div 
                    v-show="isOpen && (!isCollapsed || isMobile)" 
                    class="pl-4 mt-1.5 space-y-1.5 border-l ml-4.5"
                    :class="configStore.isSidebarLight ? 'border-gray-250/70' : 'border-gray-100 dark:border-gray-800/80'"
                >
                    <SidebarItem
                        v-for="child in menu.children"
                        :key="child.id"
                        :menu="child"
                        :is-collapsed="isCollapsed"
                        :is-mobile="isMobile"
                    />
                </div>
            </Transition>
        </template>

        <!-- STANDARD LEAF NAV LINK (No submenus) -->
        <template v-else>
            <!-- Check if dynamic routing is provided -->
            <Link
                :href="menu.route ? route(menu.route) : (menu.url || '#')"
                class="flex items-center rounded-xl text-sm font-semibold transition-all duration-200 relative group border border-transparent"
                :class="[
                    isActive
                        ? (configStore.sidebarNodeStyle === 'solid-accent'
                            ? [configStore.accentDetails.bg, 'text-white shadow-md', configStore.sidebarHoverGlow ? 'shadow-[0_0_15px_var(--accent-color)]/40 ring-1 ring-white/10' : '']
                            : configStore.sidebarNodeStyle === 'tinted-glow'
                                ? ['text-accent border shadow-sm', configStore.sidebarHoverGlow ? 'shadow-[0_0_15px_var(--accent-color)]/20' : '']
                                : configStore.sidebarNodeStyle === 'border-indicator'
                                    ? ['bg-gray-100/80 dark:bg-gray-800/25 text-accent border-l-4 border-accent rounded-l-none rounded-r-xl']
                                    : ['text-white shadow-md', configStore.sidebarHoverGlow ? 'shadow-[0_0_15px_var(--accent-color)]/45' : ''])
                        : (configStore.isSidebarLight 
                            ? 'text-gray-650 hover:bg-gray-100/80 hover:text-gray-900' 
                            : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50/50 dark:hover:bg-gray-850/20 hover:text-gray-955 dark:hover:text-gray-100'),
                    isCollapsed && !isMobile ? 'justify-center p-3' : [configStore.densityClasses.navPadding, configStore.densityClasses.navGap]
                ]"
                :style="isActive
                    ? (configStore.sidebarNodeStyle === 'tinted-glow'
                        ? { backgroundColor: 'var(--accent-color-light)', borderColor: 'var(--accent-color)' }
                        : configStore.sidebarNodeStyle === 'gradient-mesh'
                            ? { backgroundImage: configStore.accentMeshGradient }
                            : {})
                    : {}"
            >
                <component :is="iconComponent" class="h-5 w-5 shrink-0" />
                <span v-if="!isCollapsed || isMobile" class="transition-opacity duration-300">{{ menu.label }}</span>

                <!-- Collapsed tooltip description -->
                <div 
                    v-if="isCollapsed && !isMobile"
                    class="absolute left-full ml-4 px-2.5 py-1.5 bg-gray-900 text-white text-xs font-semibold rounded-lg opacity-0 translate-x-2 pointer-events-none group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-200 shadow-md whitespace-nowrap z-50"
                >
                    {{ menu.label }}
                </div>
            </Link>
        </template>

    </div>
</template>
