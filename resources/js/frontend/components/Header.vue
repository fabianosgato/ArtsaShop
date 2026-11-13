<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import UserDropdown from '@customers/components/UserDropdown.vue'

const page = usePage()
const appName = page.props.appName
const appUrl = page.props.appUrl
</script>

<template>
    <header class="header sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between gap-4 py-4 flex-wrap">

                <!-- Logo -->
                <div id="logo" class="flex-shrink-0">
                    <Link :href="route('index.home')" class="logo" :aria-label="appName + ' - Home'">
                        <img
                            :src="appUrl + 'images/frontend/logo.webp'"
                            :alt="appName"
                            width="120"
                            height="47"
                            loading="lazy"
                        />
                    </Link>
                </div>

                <!-- User Dropdown (Customers Module) -->
                <div class="flex-1 flex justify-end">
                    <UserDropdown />
                </div>

                <!-- Mobile Menu Toggle -->
                <button class="md:hidden p-2 text-gray-600 hover:text-orange-600" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
</template>

<style scoped></style>
