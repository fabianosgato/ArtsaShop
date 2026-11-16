<!-- resources/js/frontend/components/ui/Button.vue -->
<script setup lang="ts">
import {computed} from 'vue'

interface Props {
    /** Variante visual do botão */
    variant?: 'primary' | 'secondary' | 'success' | 'danger' | 'warning' | 'info' | 'light' | 'dark' | 'outline-primary' | 'outline-secondary' | 'outline-success' | 'outline-danger' | 'outline-warning' | 'outline-info' | 'outline-light' | 'outline-dark'
    /** Tamanho do botão */
    size?: 'sm' | 'md' | 'lg'
    /** Largura total (block) */
    block?: boolean
    /** Estado desabilitado */
    disabled?: boolean
    /** Tipo nativo do botão */
    type?: 'button' | 'submit' | 'reset'
    /** Tag HTML (button, a, router-link via component) */
    tag?: 'button' | 'a'
    /** HREF (quando tag='a') */
    href?: string
    /** Classes CSS adicionais */
    class?: string
    /** Indica loading */
    loading?: boolean
    /** Ícone à esquerda (nome do componente Icon) */
    iconLeft?: string
    /** Ícone à direita */
    iconRight?: string
}

const props = withDefaults(defineProps<Props>(), {
    variant: 'primary',
    size: 'md',
    block: false,
    disabled: false,
    type: 'button',
    tag: 'button',
    loading: false,
})

// Mapeamento de variantes para classes CSS do buttons.css
const variantClasses = {
    primary: 'btn-forms',
    secondary: 'btn-default',
    success: 'btn-success',
    danger: 'btn-danger',
    warning: 'btn-warning',
    info: 'btn-info',
    light: 'btn-light',
    dark: 'btn-dark',
    'outline-primary': 'btn-outline-primary',
    'outline-secondary': 'btn-outline-secondary',
    'outline-success': 'btn-outline-success',
    'outline-danger': 'btn-outline-danger',
    'outline-warning': 'btn-outline-warning',
    'outline-info': 'btn-outline-info',
    'outline-light': 'btn-light', // btn-outline-light não existe no CSS, usa btn-light
    'outline-dark': 'btn-dark',   // btn-outline-dark não existe, usa btn-dark
}

const sizeClasses = {
    sm: 'btn-sm',
    md: '',  // padrão
    lg: 'btn-lg',
}

const blockClass = computed(() => props.block ? 'btn-block' : '')

const variantClass = computed(() => variantClasses[props.variant] || variantClasses.primary)

const sizeClass = computed(() => sizeClasses[props.size] || '')

const baseClasses = computed(() => [
    'btn',
    variantClass.value,
    sizeClass.value,
    blockClass.value,
    props.class || '',
].filter(Boolean).join(' '))

const isDisabled = computed(() => props.disabled || props.loading)

const handleClick = (event: MouseEvent) => {
    if (isDisabled.value) {
        event.preventDefault()
        event.stopPropagation()
    }
    // $emit('click', event) // Vue 3 auto-emite para native events
}
</script>

<template>
    <component
        :is="tag"
        :href="tag === 'a' ? href : undefined"
        :type="tag === 'button' ? type : undefined"
        :disabled="isDisabled"
        :class="baseClasses"
        @click="handleClick"
        aria-busy="loading"
        aria-disabled="isDisabled"
    >
        <!-- Loading Spinner -->
        <span v-if="loading" class="inline-flex items-center justify-center mr-2" aria-hidden="true">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </span>

        <!-- Ícone à esquerda -->
        <span v-if="iconLeft && !loading" class="inline-flex items-center mr-2" aria-hidden="true">
            <component :is="iconLeft" class="w-4 h-4" />
        </span>

        <!-- Texto do botão -->
        <span class="flex-1 text-center">
            <slot />
        </span>

        <!-- Ícone à direita -->
        <span v-if="iconRight && !loading" class="inline-flex items-center ml-2" aria-hidden="true">
            <component :is="iconRight" class="w-4 h-4" />
        </span>
    </component>
</template>

<style scoped>
/* Garante que o botão não quebre layout */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Ajuste para loading */
.btn[aria-busy="true"] {
    pointer-events: none;
    opacity: 0.8;
}
</style>
