<script setup>
import {money} from '@/bootstrap'

const props = defineProps({
    prices: { type: Object, required: true },
})
</script>

<template>
    <div class="price-box">
        <div v-if="prices.price_discount">
            <p class="old-price">
                <span class="price" :id="'old-price-'+prices.price_id"><span class="currencySymbol">R$</span>{{ money(prices.price) }}</span>
            </p>
            <p class="special-price">
                <span class="price"><span class="currencySymbol">R$</span> {{ money(prices.price_discount) }} <span class="discount">no PIX</span></span>
            </p>
        </div>

        <div v-else-if="prices.final_price >= prices.price">
            <span class="regular-price" :id="'product-price-' + prices.price_id">
                <span class="price"><span class="currencySymbol">R$</span>{{ money(prices.price) }}</span>
            </span>
        </div>

        <div v-else>
            <p class="old-price">
                <span class="price" :id="'old-price-'+prices.price_id"><span class="currencySymbol">R$</span>{{ money(prices.final_price) }}</span>
            </p>
            <p class="special-price">
                <span class="price"><span class="currencySymbol">R$</span>{{ money(prices.final_price) }}</span>
            </p>
        </div>

    </div>
</template>
