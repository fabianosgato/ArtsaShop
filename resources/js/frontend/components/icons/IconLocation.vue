<script setup lang="ts">
interface Props {
    className?: string
    fill?: string
    stroke?: string
    strokeWidth?: number | string
}
const props = withDefaults(defineProps<Props>(), {
    fill: 'none',
    stroke: 'currentColor',
    strokeWidth: 2,
})
</script>

<template>
    <svg
        :class="className"
        :fill="fill"
        :stroke="stroke"
        :stroke-width="strokeWidth"
        viewBox='0 0 24 24'
        aria-hidden="true"
    >
        <path stroke-linecap="round" stroke-linejoin="round" :stroke-width="strokeWidth" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" :stroke-width="strokeWidth" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
    </svg>
</template>
