<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'

const page = usePage()
</script>
<template>
  <div class="breadcrumbs container mx-auto px-4 py-3" v-if="page.url !== route('index.home')">
    <nav class="flex items-center gap-2 text-sm text-gray-500" aria-label="Breadcrumb">
      <Link :href="route('index.home')" class="hover:text-orange-600">Home</Link>
      <span class="text-gray-300">/</span>
      <span class="text-gray-900 font-medium">{{ page.component }}</span>
    </nav>
  </div>
</template>

<style scoped></style>
