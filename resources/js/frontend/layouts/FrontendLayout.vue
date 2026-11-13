<script setup lang="ts">
import {computed} from 'vue'
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import Navigation from '@/components/Navigation.vue'
import Breadcrumbs from '@/components/Breadcrumbs.vue'
import Banners from '@/components/Banners.vue'

interface Props {
    layout?: '1column' | '2columns-left' | '2columns-right' | '2columns-home' | '2columns-product' | '2columns-customer'
}

const props = withDefaults(defineProps<Props>(), {
    layout: '2columns-left' as const,
})

const showBanners = computed(() => props.layout === '2columns-home')
const showBreadcrumbs = computed(() => props.layout !== '2columns-home' && props.layout !== '1column')
const showLeftNav = computed(() => props.layout === '2columns-left' || props.layout === '2columns-product')
const isCustomerLayout = computed(() => props.layout === '2columns-customer')
</script>

<template>
    <section class="flex flex-col min-h-screen bg-white">
        <!-- Header Principal -->
        <Header v-if="!isCustomerLayout"/>

        <!-- Navigation (Categorias topo) -->
        <Navigation v-if="!isCustomerLayout"/>

        <!-- Banners (só Home) -->
        <Banners v-if="showBanners"/>

        <!-- Breadcrumbs -->
        <Breadcrumbs v-if="showBreadcrumbs"/>

        <!-- Conteúdo Principal -->
        <div class="flex-1">
            <div class="mx-auto px-4 max-w-[1400px]">
                <!-- Home: container centralizado simples -->
                <div class="py-0" v-if="props.layout === '2columns-home'">
                    <slot/>
                </div>

                <!-- Layouts com sidebar esquerda (Categoria, Produto) -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12" v-else-if="showLeftNav">
                    <!-- Sidebar Esquerda (Filtros/Categorias) -->
                    <aside id="navigation_left" class="lg:col-span-3">
                        <slot name="sidebar"/>
                    </aside>

                    <!-- Main Content -->
                    <main class="lg:col-span-9">
                        <slot/>
                    </main>
                </div>

                <!-- Layout sidebar direita (futuro) -->
                <div v-else-if="props.layout === '2columns-right'">
                    <slot/>
                </div>

                <!-- Layout cliente (área logada) -->
                <div v-else-if="isCustomerLayout">
                    <slot/>
                </div>

                <!-- 1column - Simples -->
                <div v-else>
                    <slot/>
                </div>
            </div>
        </div>

    </section>
    <!-- Footer -->
    <Footer v-if="!isCustomerLayout"/>

</template>
