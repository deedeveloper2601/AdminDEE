<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useConfigStore } from '@/stores/config';
import Sidebar from '@/Layouts/Sidebar.vue';
import { 
    Menu, 
    X, 
    User, 
    LogOut, 
    Sun, 
    Moon, 
    Bell, 
    Search,
    ChevronDown,
    Sparkles
} from 'lucide-vue-next';

const configStore = useConfigStore();
const page = usePage();

const isSidebarOpen = ref(true);
const isMobileMenuOpen = ref(false);
const isProfileDropdownOpen = ref(false);
const isNotificationsOpen = ref(false);

const user = computed(() => page.props.auth.user);

const userInitials = computed(() => {
    if (!user.value || !user.value.name) return 'AD';
    const names = user.value.name.split(' ');
    if (names.length >= 2) {
        return `${names[0][0]}${names[1][0]}`.toUpperCase();
    }
    return names[0].substring(0, 2).toUpperCase();
});

// Resolve active page label from the shared menus list
const currentPageLabel = computed(() => {
    const menus = page.props.menus || [];
    const currentUrl = page.url;

    const findActive = (items) => {
        for (const item of items) {
            // Check route name match
            if (item.route) {
                try {
                    if (typeof route !== 'undefined' && route().current(item.route)) {
                        return item.label;
                    }
                } catch (_) {}
            }
            // Check url match
            if (item.url && (currentUrl === item.url || currentUrl.startsWith(item.url + '?'))) {
                return item.label;
            }
            // Recurse into children
            if (item.children?.length) {
                const found = findActive(item.children);
                if (found) return found;
            }
        }
        return null;
    };

    return findActive(menus) || 'Workspace';
});

onMounted(() => {
    configStore.init();
});

const toggleSidebar = () => {
    configStore.toggleLayoutSetting('collapsedSidebar');
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};
</script>

<template>
    <div 
        class="min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-300"
        :class="[configStore.fontFamily, configStore.darkModeBgClass.bg]"
    >
        
        <!-- Boxed Layout Outer Frame Wrapper -->
        <div 
            class="min-h-screen flex flex-col mx-auto transition-all relative"
            :class="[
                configStore.animationSpeed,
                configStore.boxedLayout ? 'max-w-[1440px] shadow-2xl border-x border-gray-200/50 dark:border-gray-900' : 'w-full',
                configStore.accentBg 
                    ? (configStore.theme === 'dark'
                        ? (configStore.darkModeStyle === 'obsidian'
                            ? 'bg-gradient-to-tr from-accent/5 via-black to-black'
                            : configStore.darkModeStyle === 'navy'
                                ? 'bg-gradient-to-tr from-accent/5 via-slate-950 to-slate-950'
                                : 'bg-gradient-to-tr from-accent/5 via-gray-950 to-gray-950')
                        : 'bg-gradient-to-tr from-accent/5 via-gray-150 to-gray-150')
                    : configStore.darkModeBgClass.bg
            ]"
        >

            <!-- MOBILE SIDEBAR OVERLAY DRAWER -->
            <Transition
                enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div 
                    v-if="isMobileMenuOpen" 
                    class="fixed inset-0 z-40 bg-gray-950/40 backdrop-blur-sm lg:hidden"
                    @click="isMobileMenuOpen = false"
                ></div>
            </Transition>

            <Transition
                enter-active-class="transition duration-300 ease-out transform"
                enter-from-class="-translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transition duration-200 ease-in transform"
                leave-from-class="translate-x-0"
                leave-to-class="-translate-x-full"
            >
                <aside 
                    v-if="isMobileMenuOpen"
                    class="fixed inset-y-0 left-0 z-50 w-64 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-r border-gray-100 dark:border-gray-800 flex flex-col transition-all duration-300 lg:hidden shadow-2xl"
                >
                    <!-- Mobile Sidebar Header -->
                    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 dark:border-gray-800">
                        <Link :href="route('dashboard')" class="flex items-center gap-2">
                            <span class="p-2 rounded-xl text-white font-bold" :class="configStore.accentDetails.bg">
                                <Sparkles class="h-5 w-5" />
                            </span>
                            <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 dark:from-white dark:via-gray-100 dark:to-gray-200 bg-clip-text text-transparent">
                                AdminDEE
                            </span>
                        </Link>
                        <button 
                            @click="isMobileMenuOpen = false"
                            class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <!-- Mobile Nav Links -->
                    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto" @click="isMobileMenuOpen = false">
                        <Sidebar :is-mobile="true" />
                    </nav>

                    <!-- Mobile Accent and Theme Switcher -->
                    <div class="p-6 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-900/30 flex flex-col gap-4">
                        <!-- Accent Swatcher -->
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-2">Accent Color</span>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button
                                    v-for="color in configStore.accentList"
                                    :key="color.key"
                                    @click="configStore.setAccentColor(color.key)"
                                    class="h-5 w-5 rounded-full border transition-all flex items-center justify-center focus:outline-none"
                                    :class="configStore.accentColor === color.key ? 'border-gray-900 dark:border-white scale-110' : 'border-transparent hover:scale-105'"
                                    :style="{ backgroundColor: color.primary }"
                                    :title="color.name"
                                >
                                    <span v-if="configStore.accentColor === color.key" class="h-1.5 w-1.5 rounded-full bg-white"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Theme Toggler -->
                        <div class="flex items-center justify-between mt-1 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 rounded-xl p-1 w-full">
                            <button
                                @click="configStore.setTheme('light')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                                :class="!configStore.isDark ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 dark:text-gray-500 hover:text-gray-300'"
                            >
                                <Sun class="h-3.5 w-3.5 text-amber-500" />
                                <span>Light</span>
                            </button>
                            <button
                                @click="configStore.setTheme('dark')"
                                class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                                :class="configStore.isDark ? 'bg-gray-950 text-white shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                            >
                                <Moon class="h-3.5 w-3.5 text-indigo-400" />
                                <span>Dark</span>
                            </button>
                        </div>
                    </div>
                </aside>
            </Transition>

            <!-- DESKTOP SIDEBAR -->
            <aside 
                v-if="!configStore.topNav"
                class="inset-y-0 left-0 z-30 hidden lg:flex flex-col transition-all ease-in-out"
                :class="[
                    configStore.fixedSidebar && !configStore.boxedLayout ? 'fixed' : 'absolute h-full',
                    configStore.collapsedSidebar ? 'w-20' : 'w-64',
                    configStore.animationSpeed,
                    configStore.isSidebarLight 
                        ? (configStore.sidebarAesthetic === 'glass'
                            ? 'bg-white/80 dark:bg-gray-900/60 backdrop-blur-md text-gray-955 border-r border-gray-150 dark:border-gray-800/80'
                            : 'bg-white dark:bg-gray-900 text-gray-955 border-r border-gray-150 dark:border-gray-850')
                        : (configStore.sidebarAesthetic === 'glass'
                            ? (configStore.darkModeStyle === 'obsidian'
                                ? 'bg-black/60 text-white border-r border-zinc-900/50 backdrop-blur-md'
                                : configStore.darkModeStyle === 'navy'
                                    ? 'bg-slate-950/60 text-white border-r border-slate-800/50 backdrop-blur-md'
                                    : 'bg-gray-950/60 text-white border-r border-gray-900/50 backdrop-blur-md')
                            : (configStore.darkModeStyle === 'obsidian'
                                ? 'bg-black text-white border-r border-zinc-900/80'
                                : configStore.darkModeStyle === 'navy'
                                    ? 'bg-slate-900 text-white border-r border-slate-800/80'
                                    : 'bg-gray-900 text-white border-r border-gray-800'))
                ]"
            >
                <!-- Logo Header -->
                <div 
                    class="flex items-center px-6 border-b overflow-hidden shrink-0 transition-all duration-300"
                    :class="[
                        configStore.densityClasses.headerHeight,
                        configStore.isSidebarLight 
                            ? 'border-gray-150 dark:border-gray-850' 
                            : (configStore.darkModeStyle === 'obsidian' 
                                ? 'border-zinc-900' 
                                : configStore.darkModeStyle === 'navy' 
                                    ? 'border-slate-800' 
                                    : 'border-gray-805')
                    ]"
                >
                    <Link :href="route('dashboard')" class="flex items-center gap-3">
                        <span class="p-2 rounded-xl text-white font-bold shrink-0 transition-transform duration-300" :class="[configStore.accentDetails.bg, configStore.collapsedSidebar ? 'scale-90' : '']">
                            <Sparkles class="h-5 w-5" />
                        </span>
                        <span 
                            v-if="!configStore.collapsedSidebar"
                            class="font-extrabold text-xl tracking-tight bg-gradient-to-r bg-clip-text text-transparent whitespace-nowrap animate-fade-in"
                            :class="configStore.isSidebarLight 
                                ? 'from-gray-900 via-gray-800 to-gray-700 dark:from-white dark:via-gray-100 dark:to-gray-200' 
                                : 'from-white via-gray-100 to-gray-200'"
                        >
                            AdminDEE
                        </span>
                    </Link>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <Sidebar :is-collapsed="configStore.collapsedSidebar" />
                </nav>

                <!-- Desktop Sidebar Footer Controls -->
                <div 
                    class="p-4 border-t flex flex-col gap-4 overflow-hidden shrink-0 transition-all duration-300"
                    :class="[
                        !configStore.collapsedSidebar ? 'opacity-100 max-h-52' : 'opacity-0 max-h-0 py-0 overflow-hidden pointer-events-none',
                        configStore.isSidebarLight 
                            ? 'bg-gray-50/60 dark:bg-gray-950/20 border-gray-150 dark:border-gray-800' 
                            : 'bg-gray-950/30 border-gray-950/60'
                    ]"
                >
                    <!-- Color Accent Selection -->
                    <div>
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider block mb-2">Accent Theme</span>
                        <div class="flex items-center gap-2">
                            <button
                                v-for="color in configStore.accentList"
                                :key="color.key"
                                @click="configStore.setAccentColor(color.key)"
                                class="h-5 w-5 rounded-full border transition-all flex items-center justify-center focus:outline-none"
                                :class="configStore.accentColor === color.key ? 'border-gray-900 dark:border-white scale-110 shadow-sm' : 'border-transparent hover:scale-105'"
                                :style="{ backgroundColor: color.primary }"
                                :title="color.name"
                            >
                                <span v-if="configStore.accentColor === color.key" class="h-1 w-1 rounded-full bg-white"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Theme Toggle Button -->
                    <div class="flex items-center justify-between bg-gray-100 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl p-1 w-full">
                        <button
                            @click="configStore.setTheme('light')"
                            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                            :class="!configStore.isDark ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-400 dark:text-gray-500 hover:text-gray-300'"
                        >
                            <Sun class="h-3.5 w-3.5 text-amber-500" />
                            <span>Light</span>
                        </button>
                        <button
                            @click="configStore.setTheme('dark')"
                            class="flex-1 flex items-center justify-center gap-1.5 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                            :class="configStore.isDark ? 'bg-gray-900 text-white shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                        >
                            <Moon class="h-3.5 w-3.5 text-indigo-400" />
                            <span>Dark</span>
                        </button>
                    </div>
                </div>
            </aside>

            <!-- MAIN LAYOUT AREA -->
            <div 
                class="flex flex-col min-h-screen transition-all"
                :class="[
                    configStore.animationSpeed,
                    configStore.topNav 
                        ? 'pl-0 lg:pl-0' 
                        : (configStore.collapsedSidebar ? 'lg:pl-20' : 'lg:pl-64')
                ]"
            >
                <!-- HEADER BAR -->
                <header 
                    class="flex items-center justify-between px-6 backdrop-blur-md border-b transition-all duration-300"
                    :class="[
                        configStore.densityClasses.headerHeight,
                        configStore.theme === 'dark'
                            ? (configStore.darkModeStyle === 'obsidian'
                                ? 'bg-black/70 border-zinc-900/50'
                                : configStore.darkModeStyle === 'navy'
                                    ? 'bg-slate-900/60 border-slate-800/50'
                                    : 'bg-gray-900/60 border-gray-900/60')
                            : 'bg-white/70 border-gray-100/80',
                        configStore.fixedNavbar ? 'sticky top-0 z-20 shadow-sm' : 'relative z-10'
                    ]"
                >
                    <div class="flex items-center gap-4">
                        <!-- Brand logo in header when topNav is true (desktop view) -->
                        <Link v-if="configStore.topNav" :href="route('dashboard')" class="hidden lg:flex items-center gap-2.5 mr-4 shrink-0">
                            <span class="p-2 rounded-xl text-white font-bold shrink-0" :class="configStore.accentDetails.bg">
                                <Sparkles class="h-5 w-5" />
                            </span>
                            <span class="font-extrabold text-xl tracking-tight bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 dark:from-white dark:via-gray-100 dark:to-gray-200 bg-clip-text text-transparent whitespace-nowrap">
                                AdminDEE
                            </span>
                        </Link>

                        <!-- Horizontal Nav Menu (desktop view when topNav is true) -->
                        <div v-if="configStore.topNav" class="hidden lg:flex items-center gap-6 mr-4">
                            <div v-for="menuItem in page.props.menus || []" :key="menuItem.id" class="relative group">
                                <template v-if="menuItem.icon !== 'section-header'">
                                    <template v-if="menuItem.children && menuItem.children.length > 0">
                                        <button class="flex items-center gap-1.5 py-1.5 text-xs font-bold text-gray-500 hover:text-gray-950 dark:text-gray-400 dark:hover:text-white transition focus:outline-none select-none">
                                            <span>{{ menuItem.label }}</span>
                                            <ChevronDown class="h-3.5 w-3.5 text-gray-450 transition-transform duration-200 group-hover:rotate-180" />
                                        </button>
                                        <!-- Hover Dropdown Menu -->
                                        <div class="absolute left-0 mt-0.5 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl shadow-xl py-2 opacity-0 translate-y-2 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0 group-hover:pointer-events-auto transition-all duration-200 z-50">
                                            <Link 
                                                v-for="child in menuItem.children" 
                                                :key="child.id"
                                                :href="child.route ? route(child.route) : (child.url || '#')"
                                                class="block px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-950 dark:hover:text-white transition"
                                            >
                                                {{ child.label }}
                                            </Link>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <Link 
                                            :href="menuItem.route ? route(menuItem.route) : (menuItem.url || '#')"
                                            class="block py-1.5 text-xs font-bold text-gray-500 hover:text-gray-950 dark:text-gray-400 dark:hover:text-white transition"
                                        >
                                            {{ menuItem.label }}
                                        </Link>
                                    </template>
                                </template>
                            </div>
                        </div>

                        <!-- Collapse Toggle Sidebar -->
                        <button 
                            v-if="!configStore.topNav"
                            @click="toggleSidebar"
                            class="hidden lg:flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <!-- Hamburger Mobile -->
                        <button 
                            @click="toggleMobileMenu"
                            class="lg:hidden flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                        >
                            <Menu class="h-5 w-5" />
                        </button>

                        <!-- Breadcrumbs/Command Header Info (dynamic) -->
                        <div v-if="!configStore.topNav" class="hidden sm:flex items-center gap-2 text-xs font-semibold text-gray-400 dark:text-gray-500 select-none">
                            <span>Workspace</span>
                            <span>/</span>
                            <span :class="configStore.accentDetails.text">{{ currentPageLabel }}</span>
                        </div>
                    </div>

                    <!-- Navigation Controls Right Panel -->
                    <div class="flex items-center gap-4">
                        
                        <!-- Quick Search Panel -->
                        <div class="relative hidden md:block w-48 lg:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Search class="h-4 w-4 text-gray-400" />
                            </span>
                            <input
                                type="text"
                                placeholder="Quick search..."
                                class="w-full pl-9 pr-4 py-1.5 text-xs bg-gray-50 dark:bg-gray-950 border border-gray-100 dark:border-gray-800 rounded-xl text-gray-900 dark:text-gray-100 placeholder-gray-400 transition-all focus:outline-none focus:bg-white dark:focus:bg-gray-900"
                                :class="[configStore.accentDetails.ring]"
                            />
                        </div>

                        <!-- Theme Toggle (Header Small Mode Toggle for when Sidebar is Collapsed or Top Navigation is active) -->
                        <button 
                            v-if="configStore.collapsedSidebar || configStore.topNav"
                            @click="configStore.toggleTheme"
                            class="hidden lg:flex items-center justify-center h-9 w-9 rounded-xl border border-gray-100 dark:border-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                        >
                            <Sun v-if="configStore.isDark" class="h-4 w-4 text-amber-500" />
                            <Moon v-else class="h-4 w-4 text-indigo-400" />
                        </button>

                        <!-- Bell Notifications -->
                        <div class="relative">
                            <button 
                                @click="isNotificationsOpen = !isNotificationsOpen"
                                class="relative flex items-center justify-center h-9 w-9 rounded-xl border border-gray-100 dark:border-gray-800 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                            >
                                <Bell class="h-4 w-4" />
                                <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full" :class="configStore.accentDetails.bg"></span>
                            </button>

                            <!-- Notifications Dropdown Overlay -->
                            <div 
                                v-if="isNotificationsOpen" 
                                class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-3 px-4 z-50 text-xs flex flex-col gap-2"
                            >
                                <div class="flex items-center justify-between pb-2 border-b border-gray-100 dark:border-gray-800">
                                    <span class="font-bold text-gray-900 dark:text-white">Notifications</span>
                                    <button class="text-xs hover:underline" :class="configStore.accentDetails.text">Clear All</button>
                                </div>
                                <div class="py-2 flex flex-col gap-3 max-h-60 overflow-y-auto">
                                    <div class="flex items-start gap-2.5 pb-2 border-b border-gray-50 dark:border-gray-800/50">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">Database backup executed successfully</p>
                                            <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5 block">10 minutes ago</span>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-2.5 pb-2 border-b border-gray-50 dark:border-gray-800/50">
                                        <span class="h-2 w-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                                        <div>
                                            <p class="font-semibold text-gray-800 dark:text-gray-200">New registration: Elena Rostova</p>
                                            <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5 block">45 minutes ago</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- USER PROFILE SETTINGS DROPDOWN -->
                        <div class="relative">
                            <button 
                                @click="isProfileDropdownOpen = !isProfileDropdownOpen"
                                class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl border border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800 transition focus:outline-none"
                            >
                                <span 
                                    class="h-7.5 w-7.5 rounded-lg flex items-center justify-center text-xs font-bold text-white shadow-sm shrink-0 bg-gradient-to-tr"
                                    :class="[
                                        configStore.accentColor === 'indigo' ? 'from-indigo-600 to-violet-500' :
                                        configStore.accentColor === 'violet' ? 'from-violet-600 to-fuchsia-500' :
                                        configStore.accentColor === 'emerald' ? 'from-emerald-600 to-teal-500' :
                                        configStore.accentColor === 'amber' ? 'from-amber-600 to-yellow-500' :
                                        configStore.accentColor === 'rose' ? 'from-rose-600 to-pink-500' :
                                        'from-cyan-600 to-sky-500'
                                    ]"
                                >
                                    {{ userInitials }}
                                </span>
                                <div class="hidden sm:flex flex-col items-start text-left">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate max-w-[100px]">{{ user?.name }}</span>
                                    <span class="text-[9px] text-gray-400 dark:text-gray-500 tracking-wide font-medium leading-none">{{ user?.role || 'Admin' }}</span>
                                </div>
                                <ChevronDown class="h-3.5 w-3.5 text-gray-400" />
                            </button>

                            <!-- Profile Options Dropdown Menu -->
                            <Transition
                                enter-active-class="transition duration-150 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-100 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <div 
                                    v-if="isProfileDropdownOpen"
                                    class="absolute right-0 mt-2 w-52 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-xl py-2 z-50"
                                >
                                    <div class="px-4 py-2 border-b border-gray-50 dark:border-gray-800/80 mb-1">
                                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate">{{ user?.name }}</p>
                                        <p class="text-[10px] text-gray-400 dark:text-gray-500 truncate mt-0.5">{{ user?.email }}</p>
                                    </div>

                                    <Link 
                                        :href="route('profile.edit')"
                                        @click="isProfileDropdownOpen = false"
                                        class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 transition"
                                    >
                                        <User class="h-4 w-4" />
                                        <span>My Profile</span>
                                    </Link>

                                    <Link 
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50/50 dark:hover:bg-rose-950/20 transition text-left"
                                    >
                                        <LogOut class="h-4 w-4" />
                                        <span>Log Out</span>
                                    </Link>
                                </div>
                            </Transition>
                        </div>

                    </div>
                </header>

                <!-- SUB-HEADER ACTION ROW -->
                <div 
                    class="flex items-center justify-between px-8 border-b shrink-0 animate-fade-in transition-all duration-300"
                    :class="[
                        configStore.densityClasses.headerHeight,
                        configStore.theme === 'dark'
                            ? (configStore.darkModeStyle === 'obsidian'
                                ? 'bg-zinc-950/60 border-zinc-900/50'
                                : configStore.darkModeStyle === 'navy'
                                    ? 'bg-slate-900/40 border-slate-800/50'
                                    : 'bg-gray-900/40 border-gray-900/60')
                            : 'bg-gray-50/60 border-gray-100/80'
                    ]"
                >
                    <slot name="header" />
                </div>

                <!-- SCROLLABLE PAGE CONTENT AREA -->
                <main 
                    class="flex-1 overflow-y-auto flex flex-col justify-between transition-all duration-300"
                    :class="configStore.densityClasses.mainPadding"
                >
                    <div class="flex-1 flex flex-col" :class="configStore.densityClasses.mainGap">
                        <slot />
                    </div>
                    
                    <!-- Premium Base Footer -->
                    <footer 
                        class="py-4 border-t text-xs text-gray-400 flex items-center justify-between shrink-0 transition-all duration-300"
                        :class="[
                            configStore.densityClasses.mainMarginTop,
                            configStore.fixedFooter 
                                ? (configStore.theme === 'dark'
                                    ? (configStore.darkModeStyle === 'obsidian'
                                        ? 'sticky -bottom-4 z-10 bg-black/95 backdrop-blur-md px-6 -mx-8 py-3.5 border-t border-zinc-900 shadow-lg'
                                        : configStore.darkModeStyle === 'navy'
                                            ? 'sticky -bottom-4 z-10 bg-slate-950/95 backdrop-blur-md px-6 -mx-8 py-3.5 border-t border-slate-900 shadow-lg'
                                            : 'sticky -bottom-4 z-10 bg-gray-950/95 backdrop-blur-md px-6 -mx-8 py-3.5 border-t border-gray-900 shadow-lg')
                                    : 'sticky -bottom-4 z-10 bg-white/95 backdrop-blur-md px-6 -mx-8 py-3.5 border-t border-gray-100 shadow-[0_-4px_12px_rgba(0,0,0,0.03)]')
                                : (configStore.theme === 'dark'
                                    ? (configStore.darkModeStyle === 'obsidian' ? 'border-zinc-900/60' : configStore.darkModeStyle === 'navy' ? 'border-slate-900/60' : 'border-gray-900/60')
                                    : 'border-gray-100')
                        ]"
                    >
                        <span>© 2026 AdminDEE Inc.</span>
                        <span>v2.4.1</span>
                    </footer>
                </main>
            </div>

        </div> <!-- /boxed layout wrapper -->
    </div>
</template>

<style>
/* Custom animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.animate-fade-in {
    animation: fadeIn 0.2s ease-out forwards;
}
</style>
