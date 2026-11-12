<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'

const page = usePage()
const storeName = 'ArtsaShop'
</script>

<template>
  <header class="header sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between gap-4 py-4 flex-wrap">
        <!-- Logo -->
        <div id="logo" class="flex-shrink-0">
          <Link :href="route('index.home')" class="logo" :aria-label="storeName + ' - Home'">
            <img
              :src="route('index.home') + '/images/frontend/logo.webp'"
              :alt="storeName"
              width="120"
              height="47"
              loading="lazy"
            />
          </Link>
        </div>

        <!-- Navegação Principal (Desktop) -->
        <nav class="hidden md:flex items-center gap-6">
          <Link :href="route('index.home')" class="text-gray-700 hover:text-orange-600 transition font-medium">Home</Link>
          <Link href="/quem-somos" class="text-gray-700 hover:text-orange-600 transition font-medium">Quem Somos</Link>
          <Link href="/fale-conosco" class="text-gray-700 hover:text-orange-600 transition font-medium">Fale Conosco</Link>
        </nav>

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden p-2 text-gray-600 hover:text-orange-600" aria-label="Menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </header>
</template>

<style scoped></style>
