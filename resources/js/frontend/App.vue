<script setup lang="ts">
import {onBeforeUnmount} from 'vue'
import {Inertia} from '@inertiajs/vue3'

// Global loading indicator
const handleStart = () => document.body.classList.add('loading')
const handleFinish = () => document.body.classList.remove('loading')

Inertia.on('start', handleStart)
Inertia.on('finish', handleFinish)
Inertia.on('cancel', handleFinish)

onBeforeUnmount(() => {
  Inertia.off('start', handleStart)
  Inertia.off('finish', handleFinish)
  Inertia.off('cancel', handleFinish)
})
</script>

<template>
  <Head />
  <RouterView />
</template>

<style>
@tailwind base;
@tailwind components;
@tailwind utilities;
</style>
