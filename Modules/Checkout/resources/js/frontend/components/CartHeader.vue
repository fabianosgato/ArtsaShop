<script setup lang="ts">
import {computed, onMounted, ref} from 'vue'
import {Link, usePage} from '@inertiajs/vue3'
import {useCartStore} from '../composables/Cart'

const page = usePage()
const open = ref(false)
const cartStore = useCartStore()

// Buscar carrinho ao montar
onMounted(() => {
    cartStore.fetch()
})

// Getters reativos do store
const totalQty = computed(() => cartStore.total_qty)
const subtotalFmt = computed(() => cartStore.subtotal_fmt)
const grandTotalFmt = computed(() => cartStore.grand_total_fmt)
const itemsCount = computed(() => cartStore.items_count)
const cartItems = computed(() => cartStore.items)
const isEmpty = computed(() => cartStore.is_empty)
const loading = computed(() => cartStore.loading)

const toggle = () => open.value = !open.value
const close = () => open.value = false
</script>

<template>
    <div class="top-cart-wrapper px-3" @mouseover="toggle" @mouseout="close">
        <div class="top-cart-trigger">
            <div class="top-cart-icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6h13M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
                    />
                </svg>
                <span class="top-cart-label">Carrinho</span>
                <span id="top-cart-qtd" class="top-cart-qtd">{{ totalQty }}</span>
            </div>
        </div>

        <div
            class="top-cart-content"
            v-show="open"
            :aria-expanded="open"
            aria-label="Meu Carrinho"
        >
            <div class="top-cart-inner">

                <div class="top-cart-items">
                    <ol class="cart-sidebar">
                        <li v-if="isEmpty" class="cart-item empty">
                            Carrinho vazio
                        </li>
                        <li v-for="item in cartItems" :key="item.product_id" class="cart-item">
                            <a :href="route('product.show', item.product.slug_key)" class="cart-item-image">
                                <img :src="item.product.image" :alt="item.product.name" />
                            </a>
                            <div class="cart-item-details">
                                <p class="cart-item-name">
                                    <a :href="route('product.show', item.product.slug_key)">{{ item.product.name }}</a>
                                </p>
                                <span class="price">{{ item.subtotal | currency }}</span>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="top-subtotal">
                <span>Subtotal</span>
                <span id="top-cart-subtotal-fmt">
                    <span class="price">{{ subtotalFmt }}</span>
                </span>
            </div>
            <div class="top-cart-actions">

                <Link
                    :href="route('checkout.cart')"
                    class="top-cart-button top-cart-button-cart"
                >
                    Ver Carrinho
                </Link>

                <Link
                    :href="route('checkout.onepage.index')"
                    title="Finalizar compra"
                    class="top-cart-button top-cart-button-checkout"
                >
                    Finalizar compra
                </Link>

            </div>

        </div>


    </div>

</template>

<style scoped>

</style>
