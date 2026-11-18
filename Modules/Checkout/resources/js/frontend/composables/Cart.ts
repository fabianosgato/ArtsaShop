import {defineStore} from 'pinia'
import {computed, ref} from 'vue'
import {usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'

interface CartItem {
    product_id: number
    price: number
    qty: number
    product: {
        name: string
        slug_key: string
        image: string
    }
    subtotal: number
}

interface CartState {
    items: CartItem[]
    total_qty: number
    subtotal: number
    grand_total: number
    discount_amount: number
    payment_method: string | null
    discount_rule_id: number | null
}

export const useCartStore = defineStore('cart', () => {
    // ===== STATE =====
    const items = ref<CartItem[]>([])
    const total_qty = ref(0)
    const subtotal = ref(0)
    const grand_total = ref(0)
    const discount_amount = ref(0)
    const payment_method = ref<string | null>(null)
    const discount_rule_id = ref<number | null>(null)
    const loading = ref(false)
    const error = ref<string | null>(null)

    // ===== GETTERS (computed) =====
    const items_count = computed(() => items.value.length)

    const subtotal_fmt = computed(() =>
        new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(subtotal.value)
    )

    const grand_total_fmt = computed(() =>
        new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(grand_total.value)
    )

    const is_empty = computed(() => items.value.length === 0)

    // ===== ACTIONS =====

    // Buscar carrinho do backend (Inertia props ou API)
    const fetch = async () => {
        loading.value = true
        error.value = null

        try {
            // Opção A: Via Inertia props (já disponível no page.props.cart)
            const page = usePage()
            if (page.props.cart) {
                hydrate(page.props.cart)
                return
            }

            // Opção B: Via API (fallback)
            const response = await fetch(route('api.cart.summary'))
            if (response.ok) {
                const data = await response.json()
                hydrate(data)
            }
        } catch (e) {
            error.value = 'Erro ao carregar carrinho'
        } finally {
            loading.value = false
        }
    }

    // Hidratar store com dados do backend
    const hydrate = (data: any) => {
        // Suporta tanto getSummary() quanto get() completo
        items.value = data.items || []
        total_qty.value = data.total_qty || 0
        subtotal.value = data.subtotal || 0
        grand_total.value = data.grand_total || data.subtotal || 0
        discount_amount.value = data.discount_amount || 0
        payment_method.value = data.payment_method || null
        discount_rule_id.value = data.discount_rule_id || null
    }

    // Adicionar item (chama API + atualiza store otimisticamente)
    const add = async (productId: number, qty: number = 1, productData?: any) => {
        try {
            const response = await fetch(route('cart.addTo'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                body: JSON.stringify({ product_id: productId, qty, product: productData }),
            })

            if (response.ok) {
                await fetch() // Recarrega do backend (source of truth)
            }
        } catch (e) {
            error.value = 'Erro ao adicionar ao carrinho'
        }
    }

    // Atualizar quantidade
    const updateQty = async (productId: number, qty: number) => {
        if (qty <= 0) return remove(productId)

        try {
            const response = await fetch(route('cart.updatePost'), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body: JSON.stringify({ product_id: productId, qty }),
            })

            if (response.ok) await fetch()
        } catch (e) {
            error.value = 'Erro ao atualizar carrinho'
        }
    }

    // Remover item
    const remove = async (productId: number) => {
        try {
            const response = await fetch(route('cart.remove'), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body: JSON.stringify({ product_id: productId }),
            })
            if (response.ok) await fetch()
        } catch (e) {
            error.value = 'Erro ao remover item'
        }
    }

    // Limpar carrinho
    const clear = async () => {
        try {
            const response = await fetch(route('cart.clear'), { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken() }})
            if (response.ok) await fetch()
        } catch (e) {
            error.value = 'Erro ao limpar carrinho'
        }
    }

    // Helper para CSRF token
    const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

    // ===== RETORNO =====
    return {
        // State
        items,
        total_qty,
        subtotal,
        grand_total,
        discount_amount,
        payment_method,
        discount_rule_id,
        loading,
        error,
        // Getters
        items_count,
        subtotal_fmt,
        grand_total_fmt,
        is_empty,
        // Actions
        fetch,
        hydrate,
        add,
        updateQty,
        remove,
        clear,
    }
})


