<script setup>
import { onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Sparkles } from 'lucide-vue-next';

// Sync dark mode from localStorage so the auth pages respect it too
onMounted(() => {
    const theme = localStorage.getItem('app-theme') || 'light';
    const accent = localStorage.getItem('app-accent') || 'indigo';
    const accentMap = {
        indigo:  { primary: '#6366f1', rgb: '99, 102, 241' },
        violet:  { primary: '#8b5cf6', rgb: '139, 92, 246' },
        emerald: { primary: '#10b981', rgb: '16, 185, 129' },
        amber:   { primary: '#f59e0b', rgb: '245, 158, 11' },
        rose:    { primary: '#f43f5e', rgb: '244, 63, 94' },
        cyan:    { primary: '#06b6d4', rgb: '6, 182, 212' },
    };
    const root = document.documentElement;
    if (theme === 'dark') root.classList.add('dark');
    else root.classList.remove('dark');
    const details = accentMap[accent] || accentMap.indigo;
    root.style.setProperty('--accent-color', details.primary);
    root.style.setProperty('--accent-color-light', `rgba(${details.rgb}, 0.1)`);
    root.style.setProperty('--accent-color-glow', `rgba(${details.rgb}, 0.15)`);
});
</script>

<template>
    <div class="min-h-screen flex bg-gray-50 dark:bg-gray-950 font-sans transition-colors duration-300">

        <!-- LEFT: Decorative Branding Panel (hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden flex-col items-center justify-center p-12"
             style="background: linear-gradient(135deg, var(--accent-color) 0%, color-mix(in srgb, var(--accent-color) 60%, #000) 100%)">

            <!-- Animated Background Blobs -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full opacity-20 blur-3xl"
                     style="background: white;"></div>
                <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full opacity-15 blur-3xl"
                     style="background: white;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full opacity-10 blur-2xl"
                     style="background: white;"></div>
            </div>

            <!-- Grid Pattern Overlay -->
            <div class="absolute inset-0 opacity-[0.06]"
                 style="background-image: linear-gradient(rgba(255,255,255,.8) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.8) 1px, transparent 1px); background-size: 40px 40px;">
            </div>

            <!-- Brand Content -->
            <div class="relative z-10 text-white text-center max-w-md">
                <div class="flex items-center justify-center gap-3 mb-8">
                    <span class="p-3 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 shadow-lg">
                        <Sparkles class="h-8 w-8 text-white" />
                    </span>
                    <span class="font-extrabold text-3xl tracking-tight text-white drop-shadow">AdminDEE</span>
                </div>

                <h1 class="text-3xl font-extrabold leading-tight mb-4 text-white drop-shadow">
                    Your command center,<br>reimagined.
                </h1>
                <p class="text-white/75 text-base leading-relaxed font-medium">
                    A premium admin dashboard built for scale — with real-time telemetry, bento layouts, and dynamic theming out of the box.
                </p>

                <!-- Feature Pills -->
                <div class="flex flex-wrap justify-center gap-2 mt-8">
                    <span class="px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold text-white">⚡ Real-time</span>
                    <span class="px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold text-white">🎨 Themeable</span>
                    <span class="px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold text-white">🌙 Dark mode</span>
                    <span class="px-3 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold text-white">📊 Analytics</span>
                </div>
            </div>
        </div>

        <!-- RIGHT: Auth Form Panel -->
        <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 lg:px-12">

            <!-- Mobile-only brand mark -->
            <div class="flex lg:hidden items-center gap-2.5 mb-8">
                <Link href="/" class="flex items-center gap-2.5">
                    <span class="p-2 rounded-xl text-white shadow-sm" style="background: var(--accent-color)">
                        <Sparkles class="h-5 w-5" />
                    </span>
                    <span class="font-extrabold text-xl tracking-tight text-gray-900 dark:text-white">AdminDEE</span>
                </Link>
            </div>

            <!-- Form Card -->
            <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-black/30 p-8">
                <slot />
            </div>

            <!-- Footer -->
            <p class="mt-8 text-xs text-gray-400 dark:text-gray-600 text-center">
                &copy; {{ new Date().getFullYear() }} AdminDEE. All rights reserved.
            </p>
        </div>

    </div>
</template>
