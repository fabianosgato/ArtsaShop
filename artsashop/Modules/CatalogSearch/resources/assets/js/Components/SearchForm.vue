<script setup>
import {onBeforeUnmount, onMounted, ref} from 'vue'
import {route} from 'ziggy-js'

const props = defineProps({
    initialQuery: { type: String, default: '' },
})

const root = ref(null)
const query = ref(props.initialQuery)
const open = ref(false)
const products = ref([])
const total = ref(0)
const resultsUrl = ref('')
const loading = ref(false)

let timer = null
let controller = null

function reset() {
    products.value = []
    total.value = 0
    resultsUrl.value = ''
    open.value = false
}

function onInput() {
    clearTimeout(timer)
    timer = setTimeout(search, 400)
}

async function search() {
    const searchQuery = query.value.trim()

    controller?.abort()

    if (searchQuery.length < 3) {
        loading.value = false
        reset()
        return
    }

    const ctrl = new AbortController()
    controller = ctrl
    loading.value = true

    try {
        const response = await fetch(
            `${route('catalogsearch.suggestions')}?q=${encodeURIComponent(searchQuery)}`,
            { signal: ctrl.signal, headers: { Accept: 'application/json' } }
        )
        const data = await response.json()

        products.value = data.products || []
        total.value = data.total || 0
        resultsUrl.value = data.url || ''
        open.value = products.value.length > 0
    } catch (error) {
        if (error.name === 'AbortError') return
        console.error('Erro ao buscar sugestões', error)
        reset()
    } finally {
        if (!ctrl.signal.aborted) loading.value = false
    }
}

function onFocus() {
    open.value = products.value.length > 0
}

function onClickOutside(event) {
    if (root.value && !root.value.contains(event.target)) {
        open.value = false
    }
}

onMounted(() => document.addEventListener('click', onClickOutside))

onBeforeUnmount(() => {
    document.removeEventListener('click', onClickOutside)
    clearTimeout(timer)
    controller?.abort()
})
</script>

<template>
    <div class="form-search" ref="root">
        <form :action="route('catalogsearch.result')" method="GET" role="search">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <input
                        type="text"
                        name="q"
                        v-model="query"
                        @input="onInput"
                        @focus="onFocus"
                        placeholder="O que você está procurando?"
                        autocomplete="off"
                        class="search-input"
                    />

                    <div class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                </div>

                <Transition name="fade">
                    <div v-show="open" class="search-results">
                        <div v-if="loading" class="search-message">
                            Buscando resultados...
                        </div>

                        <div v-else-if="products.length === 0" class="search-message">
                            Nenhum produto encontrado.
                        </div>

                        <a
                            v-for="product in products"
                            :key="product.url"
                            :href="product.url"
                            class="search-result"
                        >
                            <img :src="product.image" :alt="product.name" class="search-result-image" />
                            <span class="search-result-name">{{ product.name }}</span>
                        </a>

                        <a v-if="total > 5" :href="resultsUrl" class="search-results-all">
                            Ver todos os produtos
                        </a>
                    </div>
                </Transition>
            </div>
        </form>
    </div>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.15s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
