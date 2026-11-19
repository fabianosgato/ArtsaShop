<script setup lang="ts">
import {useSearchSuggestions} from '../composables/useSearchSuggestions'
import {route} from 'ziggy-js'
import {usePage} from "@inertiajs/vue3";

const page = usePage()
const minInputSearch = page.props.searchConfig.minQueryLength
const maxInputSearch = page.props.searchConfig.maxQueryLength

console.log("Min: " + minInputSearch)
console.log("Max: " + maxInputSearch)

const {
    query,
    products,
    total,
    resultsUrl,
    loading,
    open,
    onInput,
    close,
} = useSearchSuggestions()

</script>

<template>
    <div class="form-search">
        <form
            :action="route('catalogsearch.result')"
            method="GET"
            role="search"
        >
            <div class="search-container">
                <div class="search-input-wrapper">
                    <input
                        type="text"
                        name="q"
                        v-model="query"
                        @input="onInput($event.target.value)"
                        @focus="open = products.length > minInputSearch"
                        @blur="close"
                        placeholder="O que você está procurando?"
                        autocomplete="off"
                        class="search-input"
                    >

                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                    </div>
                </div>

                <!-- Dropdown de sugestões -->
                <div v-show="open"
                     class="search-results"
                     @mouseenter="open = true"
                     @mouseleave="close"
                     @mousedown.prevent
                >
                    <template v-if="loading">
                        <div class="search-message">Buscando resultados...</div>
                    </template>
                    <template v-else-if="products.length === 0 && query.length >= 3">
                        <div class="search-message">
                            Nenhum produto encontrado para "{{ query }}"
                        </div>
                    </template>
                    <template v-else-if="products.length === 0 && query.length > 0">
                        <div class="search-message">
                            Digite pelo menos {{ minInputSearch }} caracteres para buscar
                        </div>
                    </template>
                    <template v-else>
                        <a
                            v-for="product in products"
                            :key="product.id"
                            :href="product.url"
                            class="search-result"
                        >
                            <img :src="product.image" :alt="product.name" class="search-result-image"/>
                            <div class="search-result-info">
                                <span class="search-result-name">{{ product.name }}</span>
                                <span class="search-result-price">{{ product.price_fmt }}</span>
                            </div>
                        </a>
                        <a v-if="total > 5" :href="resultsUrl" class="search-results-all">Ver todos os {{ total }}
                            produtos</a>
                    </template>
                </div>

            </div>

        </form>
    </div>

</template>

<style scoped>

</style>
