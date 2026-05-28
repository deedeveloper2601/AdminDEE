<script setup>
import { ref, computed } from 'vue';
import { useConfigStore } from '@/stores/config';

const props = defineProps({
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
    type: {
        type: String,
        default: 'text'
    },
    required: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const configStore = useConfigStore();
const isFocused = ref(false);

const isFloating = computed(() => {
    return isFocused.value || (props.modelValue !== null && props.modelValue !== undefined && String(props.modelValue).length > 0);
});
</script>

<template>
    <div class="relative w-full">
        <!-- Text Input Element -->
        <input
            :id="id"
            :type="type"
            :value="modelValue"
            :required="required"
            @input="$emit('update:modelValue', $event.target.value)"
            @focus="isFocused = true"
            @blur="isFocused = false"
            class="block w-full px-4 pt-6 pb-2 text-sm bg-gray-50/50 dark:bg-gray-950/40 border border-gray-200 dark:border-gray-800 rounded-2xl text-gray-900 dark:text-gray-100 placeholder-transparent focus:bg-white dark:focus:bg-gray-900 transition-all focus:outline-none focus:ring-2 focus:ring-offset-0"
            :class="[configStore.accentDetails.border, configStore.accentDetails.ring]"
            placeholder=" "
        />
        
        <!-- Floating Label Element -->
        <label
            :for="id"
            class="absolute left-4 transition-all duration-200 pointer-events-none select-none"
            :class="[
                isFloating
                    ? 'top-2 text-[10px] font-bold text-accent'
                    : 'top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 dark:text-gray-500',
                isFocused && isFloating ? configStore.accentDetails.text : ''
            ]"
        >
            {{ label }}<span v-if="required" class="text-rose-500 ml-0.5">*</span>
        </label>
    </div>
</template>
