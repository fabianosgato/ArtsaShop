<script setup lang="ts">
import TopHeader from "../Components/TopHeader.vue";
import Header from "../Components/Header.vue";
import Footer from "../Components/Footer.vue";
</script>

<template>
    <section class="wrapper">
        <TopHeader/>
        <Header/>
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
