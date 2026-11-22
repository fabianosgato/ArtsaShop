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

                <!-- Centro: Busca (flex-1) -->
                <div class="flex-1 min-w-0">
                    <SearchHeader />
                </div>

                <!-- Direita: Cart + Location + User -->
                <div class="flex items-center gap-4">
                    <CartHeader />
                    <LocationSelector class="hidden lg:flex" />
                    <UserDropdown />
                </div>

            </div>
        </div>
    </header>
</template>
