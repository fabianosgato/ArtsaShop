<script setup>
import {usePage} from "@inertiajs/vue3";
import ProductPrice from "./ProductPrice.vue";

const page = usePage();
const appUrl = page.props.appUrl

const props = defineProps({
    product: { type: Object, required: true },
})

const prices = {
    'price_id': props.product.price_id,
    'price': props.product.price,
    'final_price': props.product.final_price,
    'price_discount': props.product.price - (props.product.price * (10/100)),
}

</script>

<template>
    <div class="item">
        <div class="item-inner">
            <a :href="product.slug_key" :title="product.name" class="product-image">
                <img :src="product.image" :alt="product.name" width="255" height="255">
            </a>
            <div class="free-shipp">
                <div class="discount-badge">-10% de desconto no PIX</div>
                Frete Grátis
            </div>

            <div class="product-category">
                <Link :href="appUrl+product.category_slug_key">{{ product.category_name }}</Link>
            </div>

            <h2 class="product-name"><a :href="product.slug_key" title="product.name">{{ product.name }}</a></h2>
            <div class="actions">
                <ul v-if="product.status_key = 'in-stock'" class="add-to-links">
                    <li class="add-to-cart"><button type="button" class="button btn-cart-page" data-original-title="Adicionar ao carrinho" rel="tooltip" data-product-id="{{ $product['product_id'] }}">Adicionar ao carrinho</button></li>
                    <li class="add-to-favorites">
                        <a href="#" class="link-wishlist" data-original-title="Adicionar aos Favoritos" rel="tooltip"><i class="fa-regular fa-heart"></i></a>
                    </li>
                </ul>
                <div v-else class="availability out-of-stock">
                    <span>Sem estoque</span>
                </div>
            </div>

            <div class="brand-name"><Link :href="appUrl+product.brand_key">{{ product.brand_name }}</Link></div>

            <ProductPrice :prices=prices />

        </div>


    </div>
</template>
