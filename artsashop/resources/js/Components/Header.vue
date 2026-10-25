<script setup>
import SearchForm from "../../../Modules/CatalogSearch/resources/assets/js/Components/SearchForm.vue";
import {usePage} from '@inertiajs/vue3';

const page = usePage();
const isHome = page.props.route.name === 'index.home'
const currentStore = page.props.currentStore
</script>

<template>
    <div class="header">
        <div class="container">
            <div class="header-content md:px-2">
                <div id="logo">

                    <h1 v-if="isHome" class="m-0">
                        <a :href="route('index.home')" class="logo">
                            <img
                                :src="'/images/frontend/logo.webp'"
                                alt="{{ currentStore }}"
                                width="120"
                                height="47"
                                loading="lazy"
                            />
                        </a>
                    </h1>
                    <a v-else href="{{ route('index.home') }}" class="logo">
                        <img
                            :src="'/images/frontend/logo.webp'"
                            alt="{{ currentStore }}"
                            width="120"
                            height="47"
                            loading="lazy"
                        />
                    </a>
                </div>

                <div class="header-search">
                    <SearchForm />
                </div>

                <div class="header-cart">

                </div>

            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
