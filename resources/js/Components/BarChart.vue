<script setup>
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';
import { useConfigStore } from '@/stores/config';

// Register Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
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
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: themeColors.text,
                    font: {
                        family: 'Inter, sans-serif',
                        size: 12,
                        weight: '500'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 20
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
                usePointStyle: true,
                callbacks: {
                    labelColor: (context) => {
                        return {
                            borderColor: configStore.accentHex,
                            backgroundColor: configStore.accentHex
                        };
                    }
                }
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
        },
        scales: {
            x: {
                grid: {
                    color: themeColors.grid,
                    drawBorder: false
                },
                ticks: {
                    color: themeColors.text,
                    font: {
                        family: 'Inter, sans-serif',
                        size: 11
                    }
                }
            },
            y: {
                grid: {
                    color: themeColors.grid,
                    drawBorder: false
                },
                ticks: {
                    color: themeColors.text,
                    font: {
                        family: 'Inter, sans-serif',
                        size: 11
                    }
                }
            }
        }
    };

    // Deep merge of customized props.chartOptions over defaults
    return { ...baseOptions, ...props.chartOptions };
});

// Processes the datasets, injecting Pinia accent colors
const processedData = computed(() => {
    if (!props.chartData || !props.chartData.datasets) return props.chartData;

    const datasets = props.chartData.datasets.map((dataset, idx) => {
        const isPrimary = idx === 0;
        
        return {
            borderRadius: 6,
            borderWidth: 0,
            ...dataset,
            // Override with accent theme coloring
            backgroundColor: isPrimary ? configStore.accentHex : (dataset.backgroundColor || '#9ca3af'),
            hoverBackgroundColor: isPrimary ? configStore.accentRgba(0.85) : (dataset.hoverBackgroundColor || '#6b7280'),
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
        <Bar :data="processedData" :options="processedOptions" :key="chartKey" />
    </div>
</template>
