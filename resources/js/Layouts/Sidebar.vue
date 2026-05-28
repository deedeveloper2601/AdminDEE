<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import SidebarItem from '@/Components/SidebarItem.vue';

defineProps({
    isCollapsed: {
        type: Boolean,
        default: false
    },
    isMobile: {
        type: Boolean,
        default: false
    }
});

const page = usePage();

// Retrieve list of database-seeded, active menu trees shared globally
const menusList = computed(() => {
    return page.props.menus || [];
});
</script>

<template>
    <div class="flex flex-col gap-1.5 w-full">
        <SidebarItem
            v-for="menuItem in menusList"
            :key="menuItem.id"
            :menu="menuItem"
            :is-collapsed="isCollapsed"
            :is-mobile="isMobile"
        />
    </div>
</template>
