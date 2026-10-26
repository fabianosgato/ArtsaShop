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
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    <aside id="navigation_left" class="lg:col-span-3">
                        <p>MEnu</p>
                    </aside>
                    <main class="lg:col-span-9">
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
