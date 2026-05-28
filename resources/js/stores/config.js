import { defineStore } from 'pinia';

const accentColorsMap = {
    indigo: {
        primary: '#6366f1',
        rgb: '99, 102, 241',
        name: 'Indigo',
        bg: 'bg-indigo-600',
        text: 'text-indigo-600',
        hover: 'hover:bg-indigo-700',
        border: 'border-indigo-600',
        ring: 'focus:ring-indigo-500',
        accent: 'accent-indigo-600',
    },
    violet: {
        primary: '#8b5cf6',
        rgb: '139, 92, 246',
        name: 'Violet',
        bg: 'bg-violet-600',
        text: 'text-violet-600',
        hover: 'hover:bg-violet-700',
        border: 'border-violet-600',
        ring: 'focus:ring-violet-500',
        accent: 'accent-violet-600',
    },
    emerald: {
        primary: '#10b981',
        rgb: '16, 185, 129',
        name: 'Emerald',
        bg: 'bg-emerald-600',
        text: 'text-emerald-600',
        hover: 'hover:bg-emerald-700',
        border: 'border-emerald-600',
        ring: 'focus:ring-emerald-500',
        accent: 'accent-emerald-600',
    },
    amber: {
        primary: '#f59e0b',
        rgb: '245, 158, 11',
        name: 'Amber',
        bg: 'bg-amber-600',
        text: 'text-amber-600',
        hover: 'hover:bg-amber-700',
        border: 'border-amber-600',
        ring: 'focus:ring-amber-500',
        accent: 'accent-amber-600',
    },
    rose: {
        primary: '#f43f5e',
        rgb: '244, 63, 94',
        name: 'Rose',
        bg: 'bg-rose-600',
        text: 'text-rose-600',
        hover: 'hover:bg-rose-700',
        border: 'border-rose-600',
        ring: 'focus:ring-rose-500',
        accent: 'accent-rose-600',
    },
    cyan: {
        primary: '#06b6d4',
        rgb: '6, 182, 212',
        name: 'Cyan',
        bg: 'bg-cyan-600',
        text: 'text-cyan-600',
        hover: 'hover:bg-cyan-700',
        border: 'border-cyan-600',
        ring: 'focus:ring-cyan-500',
        accent: 'accent-cyan-600',
    },
};

const keyMap = {
    // Layouts
    topNav: 'layout-topnav',
    boxedLayout: 'layout-boxed',
    fixedSidebar: 'layout-fixedsidebar',
    fixedNavbar: 'layout-fixednavbar',
    fixedFooter: 'layout-fixedfooter',
    collapsedSidebar: 'layout-collapsedsidebar',
    lightSidebar: 'layout-lightsidebar',
    // Themes & Styling
    cardRoundness: 'theme-roundness',
    animationSpeed: 'theme-animationspeed',
    sidebarAesthetic: 'theme-sidebaraesthetic',
    sidebarHoverGlow: 'theme-sidebarhoverglow',
    glassCards: 'theme-glasscards',
    accentBg: 'theme-accentbg',
    // Premium Additions
    darkModeStyle: 'theme-darkmodestyle',
    fontFamily: 'theme-fontfamily',
    layoutDensity: 'theme-layoutdensity',
    sidebarNodeStyle: 'theme-sidebarnodestyle',
    cardHoverEffect: 'theme-cardhovereffect'
};

export const useConfigStore = defineStore('config', {
    state: () => ({
        theme: localStorage.getItem('app-theme') || 'light',
        accentColor: localStorage.getItem('app-accent') || 'indigo',
        topNav: localStorage.getItem('layout-topnav') === 'true',
        boxedLayout: localStorage.getItem('layout-boxed') === 'true',
        fixedSidebar: localStorage.getItem('layout-fixedsidebar') !== 'false',
        fixedNavbar: localStorage.getItem('layout-fixednavbar') !== 'false',
        fixedFooter: localStorage.getItem('layout-fixedfooter') === 'true',
        collapsedSidebar: localStorage.getItem('layout-collapsedsidebar') === 'true',
        lightSidebar: localStorage.getItem('layout-lightsidebar') === 'true',
        cardRoundness: localStorage.getItem('theme-roundness') || 'rounded-2xl',
        animationSpeed: localStorage.getItem('theme-animationspeed') || 'duration-305', // duration-305 used to distinguish customized
        sidebarAesthetic: localStorage.getItem('theme-sidebaraesthetic') || 'glass',
        sidebarHoverGlow: localStorage.getItem('theme-sidebarhoverglow') === 'true',
        glassCards: localStorage.getItem('theme-glasscards') === 'true',
        accentBg: localStorage.getItem('theme-accentbg') === 'true',
        
        // Premium additions
        darkModeStyle: localStorage.getItem('theme-darkmodestyle') || 'coal',
        fontFamily: localStorage.getItem('theme-fontfamily') || 'font-sans',
        layoutDensity: localStorage.getItem('theme-layoutdensity') || 'balanced',
        sidebarNodeStyle: localStorage.getItem('theme-sidebarnodestyle') || 'solid-accent',
        cardHoverEffect: localStorage.getItem('theme-cardhovereffect') || 'lift',
    }),
    getters: {
        isDark: (state) => state.theme === 'dark',
        isSidebarLight: (state) => state.lightSidebar || state.theme === 'light',
        accentDetails: (state) => accentColorsMap[state.accentColor] || accentColorsMap.indigo,
        accentHex() {
            return this.accentDetails.primary;
        },
        accentRgba() {
            return (opacity = 1) => `rgba(${this.accentDetails.rgb}, ${opacity})`;
        },
        chartColors() {
            if (this.isDark) {
                return {
                    grid: '#374151', // gray-700
                    text: '#9ca3af', // gray-400
                    tooltipBg: '#1f2937', // gray-800
                    tooltipText: '#f9fafb', // gray-50
                    cardBg: '#1f2937', // gray-800
                    border: '#4b5563', // gray-600
                };
            }
            return {
                grid: '#e5e7eb', // gray-200
                text: '#4b5563', // gray-600
                tooltipBg: '#ffffff',
                tooltipText: '#111827', // gray-900
                cardBg: '#ffffff',
                border: '#e5e7eb', // gray-200
            };
        },
        accentList: () => Object.keys(accentColorsMap).map(key => ({ key, ...accentColorsMap[key] })),
        
        // Dynamic Computed Overrides
        darkModeBgClass(state) {
            if (state.theme !== 'dark') {
                return {
                    bg: 'bg-gray-150',
                    card: 'bg-white/75 border-gray-100/70 dark:border-gray-900 shadow-sm',
                    sidebar: 'bg-white border-gray-150',
                    header: 'bg-white/70 border-gray-100'
                };
            }
            if (state.darkModeStyle === 'obsidian') {
                return {
                    bg: 'bg-black',
                    card: 'bg-zinc-950/70 border-zinc-900/80',
                    sidebar: 'bg-black/90 border-zinc-900/80 text-white',
                    header: 'bg-zinc-950/70 border-zinc-900/80'
                };
            }
            if (state.darkModeStyle === 'navy') {
                return {
                    bg: 'bg-slate-950',
                    card: 'bg-slate-900/70 border-slate-800/80',
                    sidebar: 'bg-slate-950/90 border-slate-800/80 text-white',
                    header: 'bg-slate-900/70 border-slate-800/80'
                };
            }
            // Default: 'coal'
            return {
                bg: 'bg-gray-950',
                card: 'bg-gray-900/70 border-gray-900/80',
                sidebar: 'bg-gray-950/90 border-gray-900/80 text-white',
                header: 'bg-gray-900/70 border-gray-900/80'
            };
        },

        densityClasses(state) {
            if (state.layoutDensity === 'compact') {
                return {
                    mainPadding: 'px-4 pt-4 pb-2',
                    mainGap: 'gap-4',
                    mainMarginTop: 'mt-4',
                    headerHeight: 'h-12',
                    cardPadding: 'p-4 md:p-5',
                    cardMarginBottom: 'mb-4',
                    navPadding: 'py-2 px-3',
                    navGap: 'gap-1'
                };
            }
            if (state.layoutDensity === 'spacious') {
                return {
                    mainPadding: 'px-12 pt-12 pb-6',
                    mainGap: 'gap-8',
                    mainMarginTop: 'mt-12',
                    headerHeight: 'h-20',
                    cardPadding: 'p-8 md:p-10',
                    cardMarginBottom: 'mb-8',
                    navPadding: 'py-4 px-5',
                    navGap: 'gap-3.5'
                };
            }
            // Default: 'balanced'
            return {
                mainPadding: 'px-8 pt-8 pb-4',
                mainGap: 'gap-6',
                mainMarginTop: 'mt-8',
                headerHeight: 'h-16',
                cardPadding: 'p-6 md:p-8',
                cardMarginBottom: 'mb-6',
                navPadding: 'py-3 px-4',
                navGap: 'gap-2'
            };
        },

        accentMeshGradient(state) {
            const rgb = state.accentDetails.rgb;
            return `linear-gradient(135deg, rgba(${rgb}, 0.85) 0%, rgba(139, 92, 246, 0.9) 100%)`;
        }
    },
    actions: {
        setTheme(theme) {
            this.theme = theme;
            localStorage.setItem('app-theme', theme);
            this.syncThemeClass();
        },
        toggleTheme() {
            const nextTheme = this.theme === 'light' ? 'dark' : 'light';
            this.setTheme(nextTheme);
        },
        setAccentColor(color) {
            if (accentColorsMap[color]) {
                this.accentColor = color;
                localStorage.setItem('app-accent', color);
                this.syncAccentVars();
            }
        },
        toggleLayoutSetting(setting) {
            this[setting] = !this[setting];
            const storageKey = keyMap[setting] || `layout-${setting.toLowerCase()}`;
            localStorage.setItem(storageKey, this[setting]);
        },
        setThemeSetting(setting, value) {
            this[setting] = value;
            const storageKey = keyMap[setting] || `theme-${setting.toLowerCase()}`;
            localStorage.setItem(storageKey, value);
        },
        toggleThemeSetting(setting) {
            this[setting] = !this[setting];
            const storageKey = keyMap[setting] || `theme-${setting.toLowerCase()}`;
            localStorage.setItem(storageKey, this[setting]);
        },
        syncThemeClass() {
            if (typeof document !== 'undefined') {
                const root = document.documentElement;
                if (this.theme === 'dark') {
                    root.classList.add('dark');
                } else {
                    root.classList.remove('dark');
                }
            }
        },
        syncAccentVars() {
            if (typeof document !== 'undefined') {
                const root = document.documentElement;
                const details = this.accentDetails;
                root.style.setProperty('--accent-color', details.primary);
                root.style.setProperty('--accent-color-hover', `${details.primary}dd`);
                root.style.setProperty('--accent-color-light', `rgba(${details.rgb}, 0.1)`);
                root.style.setProperty('--accent-color-glow', `rgba(${details.rgb}, 0.15)`);
            }
        },
        init() {
            this.syncThemeClass();
            this.syncAccentVars();
        },
    },
});
