<script setup>

</script>

<template>
    <div id="top_header">
        <div class="container">
            <div class="md:px-2">
                <div class="topheader-right">
                    <ul class="links">
                        <li class="link"><a :href="route('index.home')">Home</a></li>
                        <li class="link"><a :href="route('quem-somos')">Quem Somos</a></li>
                        <li class="contact-us-now"><a :href="route('fale-conosco')">Fale Conosco</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
