<script setup>
import { useConfigStore } from '@/stores/config';
import { ChevronDown } from 'lucide-vue-next';

defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    label: {
        type: String,
        required: true
    },
    id: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        required: true
    },
    required: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const configStore = useConfigStore();
</script>

<template>
    <div class="relative w-full">
        <!-- Floating Label Element -->
        <label
            :for="id"
            class="absolute left-4 top-2 text-[10px] font-bold text-gray-400 dark:text-gray-500 pointer-events-none select-none"
        >
            {{ label }}<span v-if="required" class="text-rose-500 ml-0.5">*</span>
        </label>

        <!-- Select Component -->
        <select
            :id="id"
            :value="modelValue"
            :required="required"
            @change="$emit('update:modelValue', $event.target.value)"
            class="block w-full px-4 pt-6 pb-2 text-sm bg-gray-50/50 dark:bg-gray-950/40 border border-gray-200 dark:border-gray-800 rounded-2xl text-gray-900 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0 appearance-none cursor-pointer"
            :class="[configStore.accentDetails.border, configStore.accentDetails.ring]"
        >
            <option value="" disabled>Select an option...</option>
            <option 
                v-for="opt in options" 
                :key="typeof opt === 'object' ? opt.value : opt"
                :value="typeof opt === 'object' ? opt.value : opt"
                class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100"
            >
                {{ typeof opt === 'object' ? opt.label : opt }}
            </option>
        </select>

        <!-- Chevron Down Arrow -->
        <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400 dark:text-gray-500">
            <ChevronDown class="h-4 w-4" />
        </span>
    </div>
</template>
