<script setup lang="ts">
import {Link} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
</script>

<template>
  <footer class="footer bg-gray-900 text-gray-400 py-12">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Logo + Descrição -->
        <div class="md:col-span-2">
          <Link :href="route('index.home')" class="block mb-4" aria-label="ArtsaShop Home">
            <img :src="route('index.home') + '/images/frontend/logo.webp'" alt="ArtsaShop" width="120" height="47" />
          </Link>
          <p class="text-sm max-w-xs">Sua loja de eletrônicos e acessórios. Qualidade, entrega rápida e melhor preço.</p>
        </div>

        <!-- Links Institucionais -->
        <div>
          <h4 class="text-white font-semibold mb-3">Institucional</h4>
          <nav class="space-y-2 text-sm">
            <Link :href="route('index.home')" class="block hover:text-orange-400 transition">Home</Link>
            <Link href="/quem-somos" class="block hover:text-orange-400 transition">Quem Somos</Link>
            <Link href="/fale-conosco" class="block hover:text-orange-400 transition">Fale Conosco</Link>
          </nav>
        </div>

        <!-- Contato / Redes -->
        <div>
          <h4 class="text-white font-semibold mb-3">Contato</h4>
          <address class="text-sm not-italic space-y-1">
            <p>São Paulo - SP</p>
            <p>contato@artsashop.com.br</p>
            <Link href="/fale-conosco" class="block hover:text-orange-400 transition">Formulário de Contato</Link>
          </address>
        </div>
      </div>

      <!-- Copyright -->
      <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
        <p>&copy; {{ new Date().getFullYear() }} ArtsaShop. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>
</template>

<style scoped></style>
