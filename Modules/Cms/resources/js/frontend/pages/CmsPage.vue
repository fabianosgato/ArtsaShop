<script setup lang="ts">
import FrontendLayout from '@layouts/FrontendLayout.vue'
import {usePage} from "@inertiajs/vue3";

const page = usePage()

</script>

<template>
    <FrontendLayout layout="1column">
        <div class="cms-pages">
            <div class="page-title title-buttons">
                <h1>{{ page.props.title }}</h1>
            </div>
            <div>
                <div v-html="page.props.content"></div>
            </div>
        </div>
    </FrontendLayout>
</template>

<style scoped>

</style>
