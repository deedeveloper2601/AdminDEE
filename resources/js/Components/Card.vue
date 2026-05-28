<script setup>
import { useConfigStore } from '@/stores/config';

defineProps({
    hoverable: {
        type: Boolean,
        default: false
    }
});

const configStore = useConfigStore();
</script>

<template>
    <div 
        class="border transition-all duration-300"
        :class="[
            configStore.densityClasses.cardPadding,
            configStore.cardRoundness,
            configStore.glassCards 
                ? (configStore.theme === 'dark'
                    ? (configStore.darkModeStyle === 'obsidian'
                        ? 'bg-zinc-950/45 border-zinc-900/40 backdrop-blur-lg shadow-xl'
                        : configStore.darkModeStyle === 'navy'
                            ? 'bg-slate-900/45 border-slate-800/40 backdrop-blur-lg shadow-xl'
                            : 'bg-gray-900/30 border-gray-800/40 backdrop-blur-lg shadow-xl')
                    : 'bg-white/40 border-white/20 backdrop-blur-lg shadow-xl')
                : (configStore.theme === 'dark'
                    ? (configStore.darkModeStyle === 'obsidian'
                        ? 'bg-zinc-950 border-zinc-900/80 shadow-sm'
                        : configStore.darkModeStyle === 'navy'
                            ? 'bg-slate-900 border-slate-850/80 shadow-sm'
                            : 'bg-gray-900 border-gray-900 shadow-sm')
                    : 'bg-white/75 border-gray-100 shadow-sm'),
            (hoverable || configStore.cardHoverEffect !== 'none')
                ? (configStore.cardHoverEffect === 'lift'
                    ? 'hover:-translate-y-1 hover:shadow-xl hover:shadow-gray-250/10 dark:hover:shadow-black/25'
                    : configStore.cardHoverEffect === 'glow'
                        ? 'hover:border-accent/40 hover:shadow-[0_0_20px_var(--accent-color-glow)]'
                        : '')
                : ''
        ]"
    >
        <!-- Card Header Section -->
        <div v-if="$slots.title || $slots.headerActions" class="pb-5 mb-6 border-b border-gray-100 dark:border-gray-800/80 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h3 class="text-base md:text-lg font-extrabold text-gray-800 dark:text-white leading-tight">
                    <slot name="title" />
                </h3>
                <p v-if="$slots.subtitle" class="text-xs text-gray-400 dark:text-gray-500 font-semibold mt-1">
                    <slot name="subtitle" />
                </p>
            </div>
            <div class="flex items-center gap-2">
                <slot name="headerActions" />
            </div>
        </div>

        <!-- Main Card Content -->
        <div class="w-full">
            <slot />
        </div>
    </div>
</template>
