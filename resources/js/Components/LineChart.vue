<script setup>
import { computed } from 'vue';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler
} from 'chart.js';
import { useConfigStore } from '@/stores/config';

// Register Chart.js components
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler
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
        },
        interaction: {
            mode: 'index',
            intersect: false
        }
    };

    // Deep merge of customized props.chartOptions over defaults
    return { ...baseOptions, ...props.chartOptions };
});

// Processes the datasets, injecting Pinia accent colors
const processedData = computed(() => {
    if (!props.chartData || !props.chartData.datasets) return props.chartData;

    const themeColors = configStore.chartColors;

    const datasets = props.chartData.datasets.map((dataset, idx) => {
        // If the dataset does not specify custom colors, style it automatically using the theme accent
        const isPrimary = idx === 0;
        
        return {
            tension: 0.4,
            borderWidth: 3,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBorderWidth: 2,
            ...dataset,
            // Override with accent theme coloring
            borderColor: isPrimary ? configStore.accentHex : (dataset.borderColor || '#9ca3af'),
            backgroundColor: isPrimary 
                ? (ctx) => {
                      const canvas = ctx.chart.ctx;
                      const gradient = canvas.createLinearGradient(0, 0, 0, 300);
                      gradient.addColorStop(0, configStore.accentRgba(0.25));
                      gradient.addColorStop(1, configStore.accentRgba(0.00));
                      return gradient;
                  }
                : (dataset.backgroundColor || 'rgba(156, 163, 175, 0.05)'),
            pointBackgroundColor: isPrimary ? configStore.accentHex : (dataset.pointBackgroundColor || '#9ca3af'),
            pointBorderColor: themeColors.cardBg,
            pointHoverBackgroundColor: themeColors.cardBg,
            pointHoverBorderColor: isPrimary ? configStore.accentHex : (dataset.pointHoverBorderColor || '#9ca3af'),
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
        <Line :data="processedData" :options="processedOptions" :key="chartKey" />
    </div>
</template>
