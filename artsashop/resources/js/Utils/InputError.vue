<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <span class="required">
            {{ message }}
        </span>
    </div>
</template>
