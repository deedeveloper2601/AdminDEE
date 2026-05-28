<script setup>
import { computed } from 'vue';
import { Doughnut } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement
} from 'chart.js';
import { useConfigStore } from '@/stores/config';

// Register Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    ArcElement
);

const props = defineProps({
    chartData: {
        type: Object,
        required: true
    },
    chartOptions: {
        type: Object,
        default: () => ({})
    },
    title: {
        type: String,
        default: ''
    }
});

const configStore = useConfigStore();

// Dynamically recreate the chart on theme/accent change to guarantee clean canvas updates
const chartKey = computed(() => `${configStore.theme}-${configStore.accentColor}`);

// Processes the chart options, injecting Pinia-configured theme styling
const processedOptions = computed(() => {
    const themeColors = configStore.chartColors;
    
    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: {
                display: true,
                position: 'right',
                labels: {
                    color: themeColors.text,
                    font: {
                        family: 'Inter, sans-serif',
                        size: 11,
                        weight: '500'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 15
                }
            },
            tooltip: {
                backgroundColor: themeColors.tooltipBg,
                titleColor: themeColors.tooltipText,
                bodyColor: themeColors.tooltipText,
                borderColor: themeColors.border,
                borderWidth: 1,
                padding: 12,
                boxPadding: 6,
                usePointStyle: true
            },
            title: {
                display: !!props.title,
                text: props.title,
                color: themeColors.text,
                font: {
                    family: 'Inter, sans-serif',
                    size: 14,
                    weight: '600'
                },
                padding: { bottom: 15 }
            }
        }
    };

    // Deep merge of customized props.chartOptions over defaults
    return { ...baseOptions, ...props.chartOptions };
});

// Processes the datasets, creating beautifully themed accent shades
const processedData = computed(() => {
    if (!props.chartData || !props.chartData.datasets) return props.chartData;

    const themeColors = configStore.chartColors;

    const datasets = props.chartData.datasets.map((dataset) => {
        // If background colors are not specified, create a gorgeous coherent gradient of accent colors
        const opacityLayers = [1.0, 0.75, 0.5, 0.3, 0.15];
        const generatedBackgrounds = opacityLayers.map(opacity => configStore.accentRgba(opacity));
        const generatedBorders = Array(opacityLayers.length).fill(themeColors.cardBg);

        return {
            borderWidth: 2,
            ...dataset,
            backgroundColor: dataset.backgroundColor || generatedBackgrounds,
            borderColor: dataset.borderColor || generatedBorders,
            hoverOffset: 4
        };
    });

    return {
        ...props.chartData,
        datasets
    };
});
</script>

<template>
    <div class="relative w-full h-full min-h-[300px]">
        <Doughnut :data="processedData" :options="processedOptions" :key="chartKey" />
    </div>
</template>
