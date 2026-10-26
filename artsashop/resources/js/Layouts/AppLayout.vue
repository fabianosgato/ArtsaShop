<script setup lang="ts">
import TopHeader from "../Partials/TopHeader.vue";
import Header from "../Partials/Header.vue";
import Footer from "../Partials/Footer.vue";
import Navigation from "../Partials/Navigation.vue";
</script>

<template>
    <section class="wrapper">
        <TopHeader/>
        <Header/>
        <Navigation/>
        <div class="content">
            <div class="container">
                <div class="grid-cols-1 gap-2 lg:grid-cols-1 px-2 justify-center">
                    <main class="lg:col-span-9 py-6">
                    <slot/>
                    </main>
                </div>
            </div>
        </div>
        <Footer/>
    </section>
</template>

<style scoped>

</style>
