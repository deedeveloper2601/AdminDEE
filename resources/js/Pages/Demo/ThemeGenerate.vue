<script setup>
import { useConfigStore } from '@/stores/config';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from '@/Components/Card.vue';
import { 
    Palette, 
    Check, 
    Sun, 
    Moon, 
    Sliders,
    Monitor,
    Tv,
    Eye,
    Zap,
    Sparkles,
    CheckCircle2,
    ToggleLeft,
    ToggleRight,
    Type,
    Layout,
    Layers,
    Compass,
    Shield
} from 'lucide-vue-next';

const configStore = useConfigStore();

const roundnessOptions = [
    { key: 'rounded-none', name: 'Sharp (0px)' },
    { key: 'rounded-xl', name: 'Modern (12px)' },
    { key: 'rounded-2xl', name: 'Premium (16px)' },
    { key: 'rounded-3xl', name: 'Curved (24px)' }
];

const animationSpeedOptions = [
    { key: 'duration-100', name: 'Fast (100ms)' },
    { key: 'duration-305', name: 'Balanced (300ms)' },
    { key: 'duration-500', name: 'Smooth (500ms)' },
    { key: 'duration-700', name: 'Relaxed (700ms)' }
];

const sidebarOptions = [
    { key: 'glass', name: 'Translucent Glass' },
    { key: 'flat', name: 'Monochromatic Solid' }
];

// Premium Options Lists
const fontOptions = [
    { key: 'font-sans', name: 'Sans (Inter / Outfit)', desc: 'Clean, modern tech sans-serif' },
    { key: 'font-serif', name: 'Serif (Merriweather)', desc: 'Classic, editorial serif elegance' },
    { key: 'font-mono', name: 'Mono (Fira Code)', desc: 'Sharp, monospace code aesthetic' }
];

const densityOptions = [
    { key: 'compact', name: 'Compact', desc: 'Higher density content lists' },
    { key: 'balanced', name: 'Balanced', desc: 'Standard balanced spacing layout' },
    { key: 'spacious', name: 'Spacious', desc: 'Breathing editorial structure' }
];

const darkModeStyleOptions = [
    { key: 'coal', name: 'Charcoal Gray', desc: 'Warm sleek charcoal dark theme' },
    { key: 'navy', name: 'Midnight Navy', desc: 'Premium deep space midnight ocean' },
    { key: 'obsidian', name: 'Pure Obsidian', desc: 'Pure black pitch obsidian background' }
];

const sidebarNodeStyleOptions = [
    { key: 'solid-accent', name: 'Solid Accent', desc: 'Solid color active background fill' },
    { key: 'tinted-glow', name: 'Tinted Glow', desc: 'Pastel glass backdrop with glowing border' },
    { key: 'border-indicator', name: 'Left Indicator', desc: 'Minimal vertical line active accent highlight' },
    { key: 'gradient-mesh', name: 'Gradient Mesh', desc: 'Diagonal multi-color gradient active pill' }
];

const cardHoverOptions = [
    { key: 'none', name: 'Static Classic', desc: 'Traditional flat cards' },
    { key: 'lift', name: 'Elevated Lift', desc: 'Dynamic 3D translate hover lift' },
    { key: 'glow', name: 'Neon Accent Glow', desc: 'Accent-colored glowing borders on hover' }
];

const changeThemeSetting = (setting, value) => {
    configStore.setThemeSetting(setting, value);
};

const toggleThemeSetting = (setting) => {
    configStore.toggleThemeSetting(setting);
};
</script>

<template>
    <Head title="Premium Theme Studio Generator" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between w-full">
                <div class="flex items-center gap-3">
                    <span class="p-2 rounded-xl bg-accent-glow border border-accent/15 text-accent animate-spin-slow">
                        <Palette class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-900 dark:text-white leading-none">Theme Customizer Studio</h2>
                        <span class="text-xs text-gray-400 dark:text-gray-500 font-medium">Bespoke design controls syncing layout aesthetics globally in real-time.</span>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-6xl mx-auto">
            <!-- Studio Config Box (left) -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                <Card>
                    <template #title>
                        <span class="flex items-center gap-2 font-extrabold text-sm"><Sliders class="h-4.5 w-4.5 text-accent" /> Control System</span>
                    </template>
                    <template #subtitle>Manage structural components and palettes globally.</template>

                    <div class="flex flex-col gap-6 pt-3">
                        
                        <!-- SECTION 1: Core Branding -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block border-b border-gray-100 dark:border-gray-800/80 pb-1">1. Core Branding</span>
                            
                            <!-- Accent Colors Selection -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Global Primary Hue</span>
                                <div class="grid grid-cols-6 gap-2">
                                    <button
                                        v-for="color in configStore.accentList"
                                        :key="color.key"
                                        @click="configStore.setAccentColor(color.key)"
                                        class="h-10 rounded-xl border transition-all flex items-center justify-center focus:outline-none relative group"
                                        :class="configStore.accentColor === color.key ? 'border-gray-900 dark:border-white scale-105 shadow-md shadow-black/5' : 'border-gray-100 dark:border-gray-800 hover:scale-102'"
                                        :style="{ backgroundColor: color.primary }"
                                        :title="color.name"
                                    >
                                        <span v-if="configStore.accentColor === color.key" class="p-1 rounded-full bg-white text-gray-950 shadow-sm shrink-0">
                                            <Check class="h-3 w-3 stroke-[3]" />
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Dark/Light Theme Selection -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">System Aesthetics Mode</span>
                                <div class="grid grid-cols-2 gap-4">
                                    <button
                                        @click="configStore.setTheme('light')"
                                        class="flex items-center justify-center gap-2 p-3 border rounded-2xl text-xs font-bold transition duration-200"
                                        :class="!configStore.isDark ? 'bg-white dark:bg-gray-950 border-gray-900 text-gray-900 shadow-sm' : 'border-gray-100 dark:border-gray-850 text-gray-400 hover:text-gray-300 bg-white/5'"
                                    >
                                        <Sun class="h-4.5 w-4.5 text-amber-500" />
                                        <span>Light Mode</span>
                                    </button>
                                    <button
                                        @click="configStore.setTheme('dark')"
                                        class="flex items-center justify-center gap-2 p-3 border rounded-2xl text-xs font-bold transition duration-200"
                                        :class="configStore.isDark ? 'bg-gray-900 border-white text-white shadow-sm' : 'border-gray-100 dark:border-gray-850 text-gray-400 hover:text-gray-300 bg-white/5'"
                                    >
                                        <Moon class="h-4.5 w-4.5 text-indigo-400" />
                                        <span>Dark Mode</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Dark Mode Style Preset -->
                            <div v-if="configStore.isDark">
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Dark Mode Aesthetic Theme</span>
                                <div class="grid grid-cols-3 gap-2">
                                    <button
                                        v-for="dStyle in darkModeStyleOptions"
                                        :key="dStyle.key"
                                        @click="changeThemeSetting('darkModeStyle', dStyle.key)"
                                        class="p-2 border rounded-xl text-[10px] font-bold transition duration-200 flex flex-col items-center gap-1 text-center"
                                        :class="configStore.darkModeStyle === dStyle.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        <span>{{ dStyle.name }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: Typography & Spacing -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block border-b border-gray-100 dark:border-gray-800/80 pb-1">2. Typography & Density</span>
                            
                            <!-- Font Family Selection -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2"><Type class="h-3.5 w-3.5 inline mr-1 text-accent" /> Font Preset</span>
                                <div class="grid grid-cols-3 gap-2">
                                    <button
                                        v-for="font in fontOptions"
                                        :key="font.key"
                                        @click="changeThemeSetting('fontFamily', font.key)"
                                        class="p-2 border rounded-xl text-[10px] font-bold transition duration-200 text-center"
                                        :class="[
                                            font.key,
                                            configStore.fontFamily === font.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'
                                        ]"
                                    >
                                        {{ font.name.split(' ')[0] }}
                                    </button>
                                </div>
                            </div>

                            <!-- Layout Density Spacing -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2"><Layout class="h-3.5 w-3.5 inline mr-1 text-accent" /> Layout Spacing Density</span>
                                <div class="grid grid-cols-3 gap-2">
                                    <button
                                        v-for="density in densityOptions"
                                        :key="density.key"
                                        @click="changeThemeSetting('layoutDensity', density.key)"
                                        class="p-2 border rounded-xl text-[10px] font-bold transition duration-200 text-center"
                                        :class="configStore.layoutDensity === density.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ density.name }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 3: Sidebar Controls -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block border-b border-gray-100 dark:border-gray-800/80 pb-1">3. Sidebar & Navigations</span>

                            <!-- Sidebar Aesthetics Style -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Sidebar Surface Type</span>
                                <div class="grid grid-cols-2 gap-3">
                                    <button 
                                        v-for="sidebarOpt in sidebarOptions"
                                        :key="sidebarOpt.key"
                                        @click="changeThemeSetting('sidebarAesthetic', sidebarOpt.key)"
                                        class="py-2.5 px-3 border rounded-xl text-[10px] font-bold transition duration-200"
                                        :class="configStore.sidebarAesthetic === sidebarOpt.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ sidebarOpt.name }}
                                    </button>
                                </div>
                            </div>

                            <!-- Active Sidebar Node Style Selection -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2"><Compass class="h-3.5 w-3.5 inline mr-1 text-accent" /> Active Route Link Design</span>
                                <div class="grid grid-cols-2 gap-2">
                                    <button
                                        v-for="nodeStyle in sidebarNodeStyleOptions"
                                        :key="nodeStyle.key"
                                        @click="changeThemeSetting('sidebarNodeStyle', nodeStyle.key)"
                                        class="p-2 border rounded-xl text-[10px] font-bold transition duration-200 text-center"
                                        :class="configStore.sidebarNodeStyle === nodeStyle.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ nodeStyle.name }}
                                    </button>
                                </div>
                            </div>

                            <!-- Sidebar Glow Toggle -->
                            <div class="flex items-center justify-between p-3 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100 dark:border-gray-850 rounded-2xl">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Active Sidebar Glow</span>
                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-semibold leading-none">Renders glowing shadows on active sidebar nodes.</p>
                                </div>
                                <button @click="toggleThemeSetting('sidebarHoverGlow')" class="text-accent focus:outline-none transition">
                                    <component :is="configStore.sidebarHoverGlow ? ToggleRight : ToggleLeft" class="h-7 w-7 stroke-[1.5]" />
                                </button>
                            </div>
                        </div>

                        <!-- SECTION 4: Container Aesthetics -->
                        <div class="flex flex-col gap-4">
                            <span class="text-[10px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider block border-b border-gray-100 dark:border-gray-800/80 pb-1">4. Container Visual Settings</span>

                            <!-- Card Border Roundness -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Border Roundness Scale</span>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <button 
                                        v-for="round in roundnessOptions"
                                        :key="round.key"
                                        @click="changeThemeSetting('cardRoundness', round.key)"
                                        class="py-2.5 px-3 border rounded-xl text-[10px] font-bold transition duration-200"
                                        :class="configStore.cardRoundness === round.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ round.name }}
                                    </button>
                                </div>
                            </div>

                            <!-- Animations Speed -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Animations Timing</span>
                                <div class="grid grid-cols-2 gap-2.5">
                                    <button 
                                        v-for="speed in animationSpeedOptions"
                                        :key="speed.key"
                                        @click="changeThemeSetting('animationSpeed', speed.key)"
                                        class="py-2.5 px-3 border rounded-xl text-[10px] font-bold transition duration-200"
                                        :class="configStore.animationSpeed === speed.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ speed.name }}
                                    </button>
                                </div>
                            </div>

                            <!-- Card Hover Behavior -->
                            <div>
                                <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2"><Layers class="h-3.5 w-3.5 inline mr-1 text-accent" /> Container Hover Feedback</span>
                                <div class="grid grid-cols-3 gap-2">
                                    <button
                                        v-for="hover in cardHoverOptions"
                                        :key="hover.key"
                                        @click="changeThemeSetting('cardHoverEffect', hover.key)"
                                        class="p-2 border rounded-xl text-[10px] font-bold transition duration-200 text-center"
                                        :class="configStore.cardHoverEffect === hover.key ? 'bg-accent text-white border-accent' : 'border-gray-150 dark:border-gray-800 text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 bg-white/5'"
                                    >
                                        {{ hover.name.split(' ')[0] }}
                                    </button>
                                </div>
                            </div>

                            <!-- Glassmorphic Cards Toggle -->
                            <div class="flex items-center justify-between p-3 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100 dark:border-gray-850 rounded-2xl">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Glassmorphic Cards</span>
                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-semibold leading-none">Forces translucent glass filters on all page cards.</p>
                                </div>
                                <button @click="toggleThemeSetting('glassCards')" class="text-accent focus:outline-none transition">
                                    <component :is="configStore.glassCards ? ToggleRight : ToggleLeft" class="h-7 w-7 stroke-[1.5]" />
                                </button>
                            </div>

                            <!-- Soft Accent Background Gradient Toggle -->
                            <div class="flex items-center justify-between p-3 bg-gray-50/50 dark:bg-gray-950/20 border border-gray-100 dark:border-gray-850 rounded-2xl">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-xs font-bold text-gray-800 dark:text-gray-200">Accent Background Gradients</span>
                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-semibold leading-none">Embeds subtle accent-colored gradients on layouts.</p>
                                </div>
                                <button @click="toggleThemeSetting('accentBg')" class="text-accent focus:outline-none transition">
                                    <component :is="configStore.accentBg ? ToggleRight : ToggleLeft" class="h-7 w-7 stroke-[1.5]" />
                                </button>
                            </div>
                        </div>

                    </div>
                </Card>
            </div>

            <!-- Studio Mockup Live Preview (right) -->
            <div class="lg:col-span-6 flex flex-col gap-6">
                <Card class="flex-1">
                    <template #title>
                        <span class="flex items-center gap-2 font-extrabold text-sm"><Eye class="h-4.5 w-4.5 text-accent animate-pulse" /> Live Workspace Studio Mockup</span>
                    </template>
                    <template #subtitle>Inspect rendering output matching configurations instantly.</template>

                    <!-- Real-time Virtual Mockup Workspace -->
                    <div 
                        class="border p-6 flex flex-col transition-all min-h-[460px] relative transition-colors duration-300"
                        :class="[
                            configStore.cardRoundness, 
                            configStore.animationSpeed,
                            configStore.fontFamily,
                            configStore.theme === 'dark'
                                ? (configStore.darkModeStyle === 'obsidian'
                                    ? 'bg-black border-zinc-900 shadow-inner'
                                    : configStore.darkModeStyle === 'navy'
                                        ? 'bg-slate-950 border-slate-800/80 shadow-inner'
                                        : 'bg-gray-950 border-gray-900 shadow-inner')
                                : 'bg-gray-50 border-gray-150 shadow-inner'
                        ]"
                    >
                        <!-- Top Header of Mockup -->
                        <div class="flex items-center justify-between border-b border-gray-200/20 pb-4 mb-4 select-none">
                            <div class="flex items-center gap-2">
                                <span class="h-3 w-3 rounded-full bg-red-400"></span>
                                <span class="h-3 w-3 rounded-full bg-amber-400"></span>
                                <span class="h-3 w-3 rounded-full bg-green-400"></span>
                            </div>
                            <span class="text-[10px] font-mono text-gray-400">workspace_core_mockup.vue</span>
                        </div>

                        <!-- Inside Workspace Grid layout mockup -->
                        <div 
                            class="grid grid-cols-1 md:grid-cols-12 transition-all duration-300"
                            :class="configStore.layoutDensity === 'compact' ? 'gap-3' : configStore.layoutDensity === 'spacious' ? 'gap-6' : 'gap-4'"
                        >
                            <!-- Left Sidebar Mockup (Col 4) -->
                            <div 
                                class="md:col-span-4 border flex flex-col transition-all"
                                :class="[
                                    configStore.cardRoundness,
                                    configStore.layoutDensity === 'compact' ? 'p-3 gap-2' : configStore.layoutDensity === 'spacious' ? 'p-6 gap-4' : 'p-4 gap-3',
                                    configStore.sidebarAesthetic === 'glass' 
                                        ? 'bg-white/40 dark:bg-gray-900/30 backdrop-blur-md border-white/20 dark:border-gray-850/50 shadow-md' 
                                        : 'bg-white dark:bg-gray-900 border-gray-150 dark:border-gray-850'
                                ]"
                            >
                                <span class="text-[9px] font-extrabold text-gray-400 dark:text-gray-500 uppercase tracking-wider">NAV BAR</span>
                                <div class="flex flex-col gap-2">
                                    
                                    <!-- Active Leaf Mockup -->
                                    <div class="h-8.5 flex items-center gap-2 px-2.5 rounded-lg font-bold text-[10px] border border-transparent transition-all select-none" 
                                        :class="[
                                            configStore.sidebarNodeStyle === 'solid-accent'
                                                ? [configStore.accentDetails.bg, 'text-white shadow-sm', configStore.sidebarHoverGlow ? 'shadow-[0_0_12px_var(--accent-color)]/45' : '']
                                                : configStore.sidebarNodeStyle === 'tinted-glow'
                                                    ? ['text-accent border-accent/25', configStore.sidebarHoverGlow ? 'shadow-[0_0_12px_var(--accent-color)]/20' : '']
                                                    : configStore.sidebarNodeStyle === 'border-indicator'
                                                        ? 'bg-gray-100/70 dark:bg-gray-800/25 text-accent border-l-4 border-accent rounded-l-none rounded-r-lg'
                                                        : ['text-white shadow-sm', configStore.sidebarHoverGlow ? 'shadow-[0_0_12px_var(--accent-color)]/45' : '']
                                        ]"
                                        :style="configStore.sidebarNodeStyle === 'tinted-glow'
                                            ? { backgroundColor: 'var(--accent-color-light)', borderColor: 'var(--accent-color)' }
                                            : configStore.sidebarNodeStyle === 'gradient-mesh'
                                                ? { backgroundImage: configStore.accentMeshGradient }
                                                : {}"
                                    >
                                        <Sparkles class="h-3.5 w-3.5 shrink-0" />
                                        <span>Active Route</span>
                                    </div>
                                    
                                    <!-- Inactive Leaf Mockup -->
                                    <div class="h-8.5 flex items-center gap-2 px-2.5 rounded-lg text-[10px] text-gray-450 dark:text-gray-500 hover:bg-gray-100/50 dark:hover:bg-gray-850/50 select-none">
                                        <Tv class="h-3.5 w-3.5 shrink-0" />
                                        <span>Inactive Leaf</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content Mockup Cards (Col 8) -->
                            <div class="md:col-span-8 flex flex-col gap-4">
                                <!-- Card Mockup 1 -->
                                <div 
                                    class="border flex flex-col justify-between h-28 transition-all relative group"
                                    :class="[
                                        configStore.cardRoundness,
                                        configStore.layoutDensity === 'compact' ? 'p-3.5' : configStore.layoutDensity === 'spacious' ? 'p-6' : 'p-4',
                                        configStore.glassCards 
                                            ? 'bg-white/40 dark:bg-gray-900/30 backdrop-blur-lg border-white/20 dark:border-gray-850/50 shadow-lg' 
                                            : 'bg-white dark:bg-gray-900 border-gray-150 dark:border-gray-850 shadow-sm',
                                        configStore.cardHoverEffect === 'lift'
                                            ? 'hover:-translate-y-1 hover:shadow-lg transition-transform'
                                            : configStore.cardHoverEffect === 'glow'
                                                ? 'hover:border-accent/40 hover:shadow-[0_0_15px_var(--accent-color-glow)]'
                                                : ''
                                    ]"
                                >
                                    <div class="flex items-center justify-between">
                                        <span class="text-[8px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">SALES RATE</span>
                                        <Zap class="h-4.5 w-4.5" :class="configStore.accentDetails.text" />
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white leading-none">$14,240</h4>
                                        <span class="text-[8px] font-bold text-emerald-500 flex items-center mt-0.5">+12% gain</span>
                                    </div>
                                </div>

                                <!-- Card Mockup 2 -->
                                <div 
                                    class="border flex flex-col justify-between h-28 transition-all relative group"
                                    :class="[
                                        configStore.cardRoundness,
                                        configStore.layoutDensity === 'compact' ? 'p-3.5' : configStore.layoutDensity === 'spacious' ? 'p-6' : 'p-4',
                                        configStore.glassCards 
                                            ? 'bg-white/40 dark:bg-gray-900/30 backdrop-blur-lg border-white/20 dark:border-gray-850/50 shadow-lg' 
                                            : 'bg-white dark:bg-gray-900 border-gray-150 dark:border-gray-850 shadow-sm',
                                        configStore.cardHoverEffect === 'lift'
                                            ? 'hover:-translate-y-1 hover:shadow-lg transition-transform'
                                            : configStore.cardHoverEffect === 'glow'
                                                ? 'hover:border-accent/40 hover:shadow-[0_0_15px_var(--accent-color-glow)]'
                                                : ''
                                    ]"
                                >
                                    <div class="flex items-center justify-between">
                                        <span class="text-[8px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">CPU UTILIZATION</span>
                                        <Monitor class="h-4.5 w-4.5 text-emerald-500" />
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <h4 class="text-sm font-extrabold text-gray-900 dark:text-white leading-none">38%</h4>
                                        <div class="w-full bg-gray-100 dark:bg-gray-800 h-1 rounded-full overflow-hidden mt-0.5">
                                            <div class="h-full rounded-full transition-all duration-300" :class="configStore.accentDetails.bg" style="width: 38%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
