<script setup>
import {ref} from 'vue';

const open = ref(false);
</script>

<template>
    <div class="form-search">
        <form method="get" :action="route('catalogsearch.result')">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <input
                        type="text"
                        name="q"
                        x-model="query"
                        @input.debounce.400ms="search()"
                        @focus="open = products.length > 0"
                        @click.away="open = false"
                        value=""
                        placeholder="O que você está procurando?"
                        autocomplete="off"
                        class="search-input"
                    >

                    <div class="search-icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"
                            />
                        </svg>
                    </div>

                </div>
            </div>
        </form>


    </div>

</template>

<style scoped>

</style>
