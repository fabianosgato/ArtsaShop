<!-- resources/js/Components/Navigation.vue -->
<script setup>
import {computed, onBeforeUnmount, onMounted, ref} from 'vue'
import {router, usePage} from '@inertiajs/vue3'

const page = usePage()
const categories = computed(() => page.props.menuCategories ?? [])

const root = ref(null)
const open = ref(false)
const mobileDetail = ref(false)
const activeDepartment = ref(categories.value[0]?.id ?? null)

const activeCategory = computed(() =>
    categories.value.find((category) => category.id === activeDepartment.value)
)

function toggleMenu() {
    open.value = !open.value
    mobileDetail.value = false
}

// mouseenter no menu superior
function hoverDepartment(id) {
    activeDepartment.value = id
    open.value = true
    mobileDetail.value = false
}

// mouseenter ou click na lista lateral
function selectDepartment(id) {
    activeDepartment.value = id

    if (window.matchMedia('(max-width: 768px)').matches) {
        mobileDetail.value = true
    }
}

function closeMenu() {
    open.value = false
    mobileDetail.value = false
}

// @click.outside e @keydown.escape.window do Alpine
function onClickOutside(event) {
    if (root.value && !root.value.contains(event.target)) closeMenu()
}

function onKeydown(event) {
    if (event.key === 'Escape') closeMenu()
}

let removeNavigateListener

onMounted(() => {
    document.addEventListener('click', onClickOutside)
    window.addEventListener('keydown', onKeydown)
    // o layout persiste entre páginas, então o menu precisa fechar ao navegar
    removeNavigateListener = router.on('navigate', closeMenu)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', onClickOutside)
    window.removeEventListener('keydown', onKeydown)
    removeNavigateListener?.()
})
</script>

<template>
    <div id="sns_menu" ref="root">
        <div class="inner">
            <div class="container">
                <ul class="menu" aria-label="Navegação de departamentos">
                    <li class="departments-menu-item">
                        <button
                            type="button"
                            class="departments-trigger"
                            :aria-expanded="open"
                            @click="toggleMenu"
                        >
                            <span class="departments-trigger-icon" aria-hidden="true">☰</span>
                            <span>Departamentos</span>
                        </button>
                    </li>

                    <li v-for="category in categories" :key="category.id" class="menu-item">
                        <a
                            :href="category.url"
                            class="menu-link"
                            @mouseenter="hoverDepartment(category.id)"
                        >
                            {{ category.name }}
                        </a>
                    </li>
                </ul>

                <Transition name="fade">
                    <div v-show="open" class="departments-panel" @mouseenter="open = true">
                        <div class="departments-list">
                            <div class="departments-list-header">
                                <span>Todos os departamentos</span>
                            </div>

                            <button
                                v-for="category in categories"
                                :key="category.id"
                                type="button"
                                class="department-item"
                                :class="{ 'is-active': activeDepartment === category.id }"
                                @mouseenter="selectDepartment(category.id)"
                                @click="selectDepartment(category.id)"
                            >
                                <span>{{ category.name }}</span>
                                <span v-if="category.children.length" class="department-arrow" aria-hidden="true">›</span>
                            </button>
                        </div>

                        <div class="departments-content" :class="{ 'is-mobile-detail': mobileDetail }">
                            <button type="button" class="departments-back" @click="mobileDetail = false">
                                <span aria-hidden="true">‹</span>
                                <span>Voltar</span>
                            </button>

                            <section v-if="activeCategory" class="department-content">
                                <div class="department-content-header">
                                    <a :href="activeCategory.url" class="department-title">
                                        {{ activeCategory.name }}
                                    </a>
                                    <a :href="activeCategory.url" class="department-see-all">
                                        Ver departamento
                                    </a>
                                </div>

                                <div v-if="activeCategory.children.length" class="department-children">
                                    <a
                                        v-for="child in activeCategory.children"
                                        :key="child.id"
                                        :href="child.url"
                                        class="department-child-link"
                                    >
                                        {{ child.name }}
                                    </a>
                                </div>

                                <p v-else class="department-empty">
                                    Confira os produtos deste departamento.
                                </p>
                            </section>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active { transition: opacity 0.15s ease; }
.fade-enter-from,
.fade-leave-to { opacity: 0; }
</style>
