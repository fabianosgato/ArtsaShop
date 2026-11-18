<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'
import {ref} from "vue";


const page = usePage()
const open = ref(false)

const close = () => {
    open.value = false
}

const toggle = () => {
    open.value = !open.value
}

</script>

<template>
    <div class="top-cart-wrapper">
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
                <span id="top-cart-qtd" class="top-cart-qtd">

                </span>
            </div>
        </div>

        <div
            class="top-cart-content"
            @mouseover="toggle"
            @mouseout="close"
            :aria-expanded="open"
            aria-label="Meu Carrinho"
        >
            <div class="top-cart-inner">

                <div class="top-cart-items">
                    <ol class="cart-sidebar">
                        <li class="cart-item">

                        </li>
                    </ol>
                </div>
            </div>
            <div class="top-subtotal">
                <span>Subtotal</span>
                <span id="top-cart-subtotal-fmt">
                    <span class="price">
                        R$ 100,00
                    </span>
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
