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
        :class='className'
        :fill='fill'
        :stroke='stroke'
        :stroke-width='strokeWidth'
        viewBox='0 0 24 24'
        aria-hidden='true'
    >
        <path stroke-linecap="round" stroke-linejoin="round" :stroke-width="strokeWidth" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
    </svg>
</template>
