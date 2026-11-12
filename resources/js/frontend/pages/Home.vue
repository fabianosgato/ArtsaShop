<script setup lang="ts">
import FrontendLayout from '@/layouts/FrontendLayout.vue'
</script>

<template>
  <FrontendLayout layout="2columns-home">
    <!-- Hero Section -->
    <section class="hero-section -mx-4 md:mx-0 mb-8" aria-labelledby="hero-title">
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

    <!-- Placeholder para vitrines futuras -->
    <section id="featured" class="mb-12" aria-labelledby="featured-title">
      <div class="flex items-center justify-between mb-6">
        <h2 id="featured-title" class="text-2xl font-bold text-gray-900">Em Destaque</h2>
        <span class="text-gray-500 text-sm">Produtos em breve...</span>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <!-- ProductGrid virá aqui depois -->
        <div class="col-span-full text-center py-12 text-gray-500">
          <p>Implementação de vitrines em andamento...</p>
        </div>
      </div>
    </section>

    <!-- Newsletter -->
    <section class="bg-gray-50 rounded-xl p-8 md:p-12 text-center" aria-labelledby="newsletter-title">
      <h2 id="newsletter-title" class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
        Receba nossas ofertas exclusivas
      </h2>
      <p class="text-gray-600 mb-6 max-w-xl mx-auto">
        Cadastre-se na nossa newsletter e receba promoções, lançamentos e cupons de desconto direto no seu e-mail.
      </p>
      <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" @submit.prevent>
        <input type="email" placeholder="Seu melhor e-mail" class="flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-500" required />
        <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors whitespace-nowrap">Cadastrar</button>
      </form>
    </section>
  </FrontendLayout>
</template>