<script setup>
import Layout from '../../../../../../resources/js/Layouts/LayoutTwoColums.vue'
import ProductListItem from "../Components/ProductListItem.vue";

defineOptions({layout: Layout})

const props = defineProps({
    catalogCategory: { type: Object, required: true },
    catalogProducts: { type: Object, required: true },
})
</script>

<template>
    <div class="category-view">
        <div class="page-title title-buttons category">
            <h1>{{ catalogCategory.category }}</h1>
        </div>
        <div class="category-products">
            <div class="products-grid grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                <div v-for="product in catalogProducts.data" :key="product.product_id">
                    <ProductListItem :product="product" />
                </div>

            </div>
            <div class="toolbar-bottom">
                <div class="toolbar">

                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
