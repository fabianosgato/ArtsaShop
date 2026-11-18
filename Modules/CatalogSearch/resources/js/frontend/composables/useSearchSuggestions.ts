import {onUnmounted, ref} from 'vue'
import {route} from 'ziggy-js'
import {usePage} from "@inertiajs/vue3";

const page = usePage()

interface RawProduct {
    product_id: number
    sku: string
    name: string
    image: string
    thumbnail: string
    slug_key: string;
    price: string
    final_price: string
    fulltext_score: number
    relevance_score: number
}

interface SearchSuggestionsResponse {
    products: RawProduct[]
    total: number
    url: string
}

interface ProductSuggestion {
    id: number
    name: string
    url: string
    image: string
    price: number
    price_fmt: string
}


export function useSearchSuggestions() {
    const query = ref('')
    const products = ref<ProductSuggestion[]>([])
    const total = ref(0)
    const resultsUrl = ref('')
    const loading = ref(false)
    const open = ref(false)
    let debounceTimer: ReturnType<typeof setTimeout> | null = null

    // Formata o preço dos produtos vindo da busca
    const formatPrice = (priceStr: string): string => {
        const price = parseFloat(priceStr)
        return new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        }).format(price)
    }

    const mapProduct = (raw: RawProduct): ProductSuggestion => ({
        id: raw.product_id,
        name: raw.name,
        url: raw.slug_key,
        image: raw.image,
        price: parseFloat(raw.final_price),
        price_fmt: formatPrice(raw.final_price),
    })

    const search = async (searchQuery: string) => {
        const q = searchQuery.trim()

        if (q.length < page.props.searchConfig.minQueryLength) {
            products.value = []
            total.value = 0
            resultsUrl.value = ''
            open.value = false
            return
        }

        loading.value = true
        try {
            const response = await fetch(`${route('catalogsearch.suggestions')}?q=${encodeURIComponent(q)}`)
            const data: SearchSuggestionsResponse = await response.json()

            products.value = (data.products || []).map(mapProduct)
            total.value = data.total || 0
            resultsUrl.value = data.url || ''
            open.value = products.value.length > 0

            console.log('Começa a buscar por... ' + encodeURIComponent(q))
            console.log('open.value = ' + open.value)
            console.log('products.value.length = ' + products.value.length)
            console.log(products.value)

        } catch (error) {
            console.error('Erro ao buscar sugestões:', error)
            products.value = []
            total.value = 0
            resultsUrl.value = ''
            open.value = false
        } finally {
            loading.value = false
        }
    }

    // Debounced input handler
    const onInput = (value: string) => {
        query.value = value
        if (debounceTimer) clearTimeout(debounceTimer)
        debounceTimer = setTimeout(() => search(value), 400)
    }

    const close = () => {
        open.value = false
    }

    // Cleanup
    onUnmounted(() => {
        if (debounceTimer) clearTimeout(debounceTimer)
    })

    return {
        query,
        products,
        total,
        resultsUrl,
        loading,
        open,
        onInput,
        search,
        close,
    }
}
