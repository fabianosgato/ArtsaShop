<script setup>
import {computed} from 'vue'
import DOMPurify from 'dompurify'

const props = defineProps({
    CmsPage: { type: Object, default: () => [] },
})

const safeContent = computed(() => DOMPurify.sanitize(props.CmsPage.content))
</script>

<template>
    <div class="cms-pages">
        <div class="page-title title-buttons">
            <h1>{{ CmsPage.title }}</h1>
        </div>
        <div>
            <div v-html="safeContent"></div>
        </div>
    </div>

</template>

<style scoped>

</style>
