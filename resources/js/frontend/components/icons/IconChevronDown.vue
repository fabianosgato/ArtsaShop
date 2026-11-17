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
        <path stroke-linecap="round" stroke-linejoin="round" :stroke-width="strokeWidth" d="M19 9l-7 7-7-7"></path>
    </svg>
</template>
