<script setup lang="ts">
import {ref} from 'vue'
import FrontendLayout from '@/layouts/FrontendLayout.vue'
// import ProductGrid from '@/components/ProductGrid.vue'
// import CategorySection from '@/components/CategorySection.vue'

// interface Product {
//   product_id: number
//   sku: string
//   name: string
//   image: string | null
//   slug_key: string
//   final_price: number
//   price: number
// }
//
// interface Category {
//   entity_id: number
//   category_name: string
//   slug_key: string
//   image: string | null
// }

// Props vindas do Controller via Inertia
interface Props {
  featuredProducts: { data: Product[] }
  newProducts: { data: Product[] }
  categories: Category[]
}

const props = defineProps<Props>()

const featuredProducts = ref<Product[]>(props.featuredProducts.data || [])
const newProducts = ref<Product[]>(props.newProducts.data || [])
const categories = ref<Category[]>(props.categories || [])
const loading = ref(false)
</script>

<template>
  <FrontendLayout layout="2columns-home">
    <!-- Hero Section -->
    <section class="hero-section mb-8" aria-labelledby="hero-title">
      <div class="relative h-96 md:h-[500px] bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl overflow-hidden flex items-center justify-center">
        <div class="container mx-auto px-4 text-center text-white">
          <h1 id="hero-title" class="text-4xl md:text-5xl font-bold mb-4">
            Bem-vindo à ArtsaShop
          </h1>
          <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto">
            Encontre os melhores produtos com os melhores preços. Entrega rápida e segura para todo o Brasil.
          </p>
          <a href="#featured" class="bg-white text-orange-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors inline-block">
            Ver Ofertas
          </a>
        </div>
      </div>
    </section>

    <!-- Categorias em Destaque -->
    <CategorySection :categories="categories" v-if="categories.length > 0" />

    <!-- Produtos em Destaque -->
    <section id="featured" class="mb-12" aria-labelledby="featured-title">
      <div class="flex items-center justify-between mb-6">
        <h2 id="featured-title" class="text-2xl font-bold text-gray-900">Em Destaque</h2>
        <a href="#" class="text-orange-600 hover:underline text-sm font-medium">Ver todos</a>
      </div>
      <ProductGrid
        :products="featuredProducts"
        :loading="loading"
        :columns="{ default: 2, sm: 2, md: 3, lg: 4 }"
      />
    </section>

    <!-- Novidades -->
    <section class="mb-12" aria-labelledby="new-title">
      <div class="flex items-center justify-between mb-6">
        <h2 id="new-title" class="text-2xl font-bold text-gray-900">Novidades</h2>
        <a href="#" class="text-orange-600 hover:underline text-sm font-medium">Ver todos</a>
      </div>
      <ProductGrid
        :products="newProducts"
        :loading="loading"
        :columns="{ default: 2, sm: 2, md: 3, lg: 4 }"
      />
    </section>

    <!-- Newsletter / CTA Final -->
    <section class="bg-gray-50 rounded-xl p-8 md:p-12 text-center" aria-labelledby="newsletter-title">
      <h2 id="newsletter-title" class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
        Receba nossas ofertas exclusivas
      </h2>
      <p class="text-gray-600 mb-6 max-w-xl mx-auto">
        Cadastre-se na nossa newsletter e receba promoções, lançamentos e cupons de desconto direto no seu e-mail.
      </p>
      <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" @submit.prevent>
        <input
          type="email"
          placeholder="Seu melhor e-mail"
          class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500"
          required
        />
        <button
          type="submit"
          class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors whitespace-nowrap"
        >
          Cadastrar
        </button>
      </form>
    </section>
  </FrontendLayout>
</template>

<style scoped>
</style>
