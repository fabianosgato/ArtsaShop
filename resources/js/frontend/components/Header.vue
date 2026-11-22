<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import UserDropdown from '@customers/components/UserDropdown.vue'
import LocationSelector from '@customers/components/LocationSelector.vue'
import CartHeader from "@checkout/components/CartHeader.vue";
import SearchHeader from "@catalogsearch/components/SearchHeader.vue";

const page = usePage()
const appName = page.props.appName
const appUrl = page.props.appUrl
</script>

<template>
    <header class="header">
        <div class="container">
            <div class="header-content">

                <!-- Logo -->
                <h1 id="logo">
                    <Link :href="route('index.home')" class="logo" :aria-label="appName + ' - Home'">
                        <img
                            :src="appUrl + 'images/frontend/logo.webp'"
                            :alt="appName"
                            width="120"
                            height="47"
                            loading="lazy"
                        />
                    </Link>
                </h1>

                <!-- Centro: Busca Principal (apenas desktop ≥1024px) -->
                <div class="header-search-middle">
                    <SearchHeader />
                </div>

                <!-- Direita: Cart + Location + User -->
                <div class="flex items-center gap-4">
                    <CartHeader />
                    <LocationSelector class="hidden md:flex" />
                    <UserDropdown />
                </div>

            </div>

            <!-- Centro: Busca Mobile (apenas mobile ≤768px, full-width abaixo do header) -->
            <div class="header-search-full lg:hidden">
                <SearchHeader />
            </div>

        </div>
    </header>
</template>
