<script setup>
import { ref, computed } from 'vue';
import { useConfigStore } from '@/stores/config';
import PrimaryButton from './PrimaryButton.vue';
import SecondaryButton from './SecondaryButton.vue';
import { Check } from 'lucide-vue-next';

const props = defineProps({
    steps: {
        type: Array,
        required: true,
        validator: (value) => value.length > 0
    }
});

const emit = defineEmits(['submit', 'step-change']);

const configStore = useConfigStore();

// --- STATE ---
const currentStep = ref(1);
const transitionName = ref('slide-next');

// --- GETTERS & COMPUTED ---
const isFirstStep = computed(() => currentStep.value === 1);
const isLastStep = computed(() => currentStep.value === props.steps.length);

const progressPercentage = computed(() => {
    if (props.steps.length <= 1) return 0;
    return ((currentStep.value - 1) / (props.steps.length - 1)) * 100;
});

// --- NAVIGATION METHODS ---
const next = () => {
    if (currentStep.value < props.steps.length) {
        transitionName.value = 'slide-next';
        // Delay slightly for smooth transition triggering
        currentStep.value++;
        emit('step-change', currentStep.value);
    } else if (isLastStep.value) {
        emit('submit');
    }
};

const prev = () => {
    if (currentStep.value > 1) {
        transitionName.value = 'slide-prev';
        currentStep.value--;
        emit('step-change', currentStep.value);
    }
};

const goToStep = (stepNum) => {
    // Only allow clicking steps that are already completed or the next adjacent step
    if (stepNum >= 1 && stepNum <= props.steps.length && stepNum <= currentStep.value + 1) {
        transitionName.value = stepNum > currentStep.value ? 'slide-next' : 'slide-prev';
        currentStep.value = stepNum;
        emit('step-change', currentStep.value);
    }
};

// Expose internal state to parent components using template ref
defineExpose({
    currentStep,
    next,
    prev,
    goToStep,
    isFirstStep,
    isLastStep
});
</script>

<template>
    <div class="w-full flex flex-col bg-white/70 dark:bg-gray-900/60 backdrop-blur-md border border-gray-100 dark:border-gray-900 rounded-3xl p-6 md:p-8 shadow-sm hover:shadow-xl hover:shadow-gray-200/10 dark:hover:shadow-black/10 transition-all duration-300">
        
        <!-- STEP INDICATOR ROW -->
        <div class="relative w-full mb-10 px-2 md:px-6">
            
            <!-- Progress Line Container -->
            <div class="absolute top-5 left-8 right-8 h-0.5 bg-gray-100 dark:bg-gray-800 -translate-y-1/2 rounded-full z-0">
                <!-- Connected Active Progress Bar -->
                <div 
                    class="h-full rounded-full transition-all duration-500 ease-out"
                    :class="[configStore.accentDetails.bg]"
                    :style="{ width: `${progressPercentage}%` }"
                ></div>
            </div>

            <!-- Steps Circle Flow -->
            <div class="flex items-center justify-between relative z-10">
                <div 
                    v-for="(stepName, index) in steps" 
                    :key="stepName"
                    class="flex flex-col items-center flex-1 group"
                >
                    <!-- Circle node button -->
                    <button
                        type="button"
                        @click="goToStep(index + 1)"
                        :disabled="index + 1 > currentStep + 1"
                        class="h-10 w-10 rounded-full flex items-center justify-center font-bold text-sm border-2 transition-all duration-300 select-none relative focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
                        :class="[
                            // Completed state
                            index + 1 < currentStep 
                                ? [configStore.accentDetails.bg, configStore.accentDetails.border, 'text-white shadow-md shadow-accent/10 hover:brightness-110']
                                : '',
                            // Active state
                            index + 1 === currentStep
                                ? ['bg-white dark:bg-gray-950 text-accent border-accent shadow-lg shadow-accent/15 scale-110 ring-2 ring-accent/30', configStore.accentDetails.border, configStore.accentDetails.text]
                                : '',
                            // Pending/Future state
                            index + 1 > currentStep
                                ? 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-400 dark:text-gray-500 cursor-not-allowed hover:bg-gray-50 dark:hover:bg-gray-700/50'
                                : ''
                        ]"
                    >
                        <Transition name="fade" mode="out-in">
                            <span v-if="index + 1 < currentStep" class="flex items-center justify-center">
                                <Check class="h-5 w-5 stroke-[3]" />
                            </span>
                            <span v-else>{{ index + 1 }}</span>
                        </Transition>
                    </button>

                    <!-- Text description label -->
                    <span 
                        class="text-[11px] md:text-xs font-bold tracking-wide mt-3 text-center transition-colors duration-300 max-w-[120px] select-none"
                        :class="[
                            index + 1 <= currentStep 
                                ? 'text-gray-900 dark:text-gray-200 font-extrabold' 
                                : 'text-gray-400 dark:text-gray-500 font-semibold'
                        ]"
                    >
                        {{ stepName }}
                    </span>
                </div>
            </div>
        </div>

        <!-- FORM CONTENT WRAPPER WITH TRANSITION -->
        <div class="flex-1 min-h-[220px] py-2 overflow-hidden relative">
            <Transition :name="transitionName" mode="out-in">
                <div :key="currentStep" class="w-full h-full">
                    <slot 
                        :currentStep="currentStep" 
                        :isFirstStep="isFirstStep" 
                        :isLastStep="isLastStep"
                        :next="next"
                        :prev="prev"
                    />
                </div>
            </Transition>
        </div>

        <!-- ACTION FOOTER BUTTONS -->
        <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-100 dark:border-gray-900">
            <!-- Previous Button -->
            <SecondaryButton
                type="button"
                @click="prev"
                :disabled="isFirstStep"
                class="flex items-center gap-1.5 px-4 py-2 border-gray-200 dark:border-gray-700 hover:border-gray-300 transition duration-150 rounded-xl"
            >
                Previous
            </SecondaryButton>

            <!-- Next / Submit Button -->
            <PrimaryButton
                type="button"
                @click="next"
                class="flex items-center gap-1.5 px-5 py-2.5 transition duration-150 rounded-xl text-white font-bold"
                :class="[configStore.accentDetails.bg, configStore.accentDetails.hover, 'shadow-md shadow-accent/15']"
            >
                <span v-if="isLastStep">Submit</span>
                <span v-else>Next</span>
            </PrimaryButton>
        </div>

    </div>
</template>

<style scoped>
/* dynamic step indicator transitions */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* slide-next (Forward Navigation) */
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-next-enter-from {
    opacity: 0;
    transform: translateX(40px);
}
.slide-next-leave-to {
    opacity: 0;
    transform: translateX(-40px);
}

/* slide-prev (Backward Navigation) */
.slide-prev-enter-from {
    opacity: 0;
    transform: translateX(-40px);
}
.slide-prev-leave-to {
    opacity: 0;
    transform: translateX(40px);
}
</style>
