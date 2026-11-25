<script setup lang="ts">
import {Link, usePage} from '@inertiajs/vue3'

import {computed, onMounted, onUnmounted, ref, watch} from 'vue'
import type {Category} from '../composables/navigation'

const page = usePage()

// Props compartilhadas do Inertia
const categories = computed(() => {
    const cats = page.props.categories as Category[] | undefined
    return Array.isArray(cats) ? cats : []
})
const activeCategoryId = computed(() => page.props.activeCategoryId as number | null)
const activePathIds = computed(() => page.props.activePathIds as number[] || [])

// Estado do menu mobile
const isMobileMenuOpen = ref(false)
const mobileActiveDepartment = ref<number | null>(null)
const isMobileDetail = ref(false)

// Estado do menu desktop (hover)
const desktopActiveDepartment = ref<number | null>(null)
const isDesktopMenuOpen = ref(false)

// Breakpoints
const MOBILE_BREAKPOINT = 768
const TABLET_BREAKPOINT = 1024

// Verifica se é mobile
const isMobile = computed(() => {
    if (typeof window === 'undefined') return false
    return window.innerWidth < MOBILE_BREAKPOINT
})

const isTablet = computed(() => {
    if (typeof window === 'undefined') return false
    return window.innerWidth >= MOBILE_BREAKPOINT && window.innerWidth < TABLET_BREAKPOINT
})

// Primeira categoria com produtos para default no mobile
const firstCategoryWithProducts = computed(() => {
    return categories.value.find(c => c.hasProducts) || null
})

// Inicializa department ativo no mobile
const initMobileActiveDepartment = () => {
    if (activeCategoryId.value) {
        mobileActiveDepartment.value = activeCategoryId.value
    } else if (firstCategoryWithProducts.value) {
        mobileActiveDepartment.value = firstCategoryWithProducts.value.entityId
    }
}

// Handlers desktop
const handleDesktopMouseEnter = (categoryId: number) => {
    if (isMobile.value) return
    desktopActiveDepartment.value = categoryId
    isDesktopMenuOpen.value = true
}

const handleDesktopMouseLeave = () => {
    if (isMobile.value) return
    setTimeout(() => {
        if (!isDesktopMenuOpen.value) {
            desktopActiveDepartment.value = null
        }
    }, 100)
}

const handlePanelMouseEnter = () => {
    isDesktopMenuOpen.value = true
}

const handlePanelMouseLeave = () => {
    isDesktopMenuOpen.value = false
    desktopActiveDepartment.value = null
}

// Handlers mobile
const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value
    if (!isMobileMenuOpen.value) {
        isMobileDetail.value = false
    }
}

const closeMobileMenu = () => {
    isMobileMenuOpen.value = false
    isMobileDetail.value = false
}

const selectDepartmentMobile = (categoryId: number) => {
    mobileActiveDepartment.value = categoryId
    isMobileDetail.value = true
}

const goBackMobile = () => {
    isMobileDetail.value = false
}

// Fecha menu ao redimensionar para desktop
let resizeTimeout: ReturnType<typeof setTimeout> | null = null
const handleResize = () => {
    if (resizeTimeout) clearTimeout(resizeTimeout)
    resizeTimeout = setTimeout(() => {
        if (!isMobile.value && isMobileMenuOpen.value) {
            closeMobileMenu()
        }
    }, 100)
}

onMounted(() => {
    initMobileActiveDepartment()
    window.addEventListener('resize', handleResize)
    document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
    document.removeEventListener('keydown', handleKeydown)
    if (resizeTimeout) clearTimeout(resizeTimeout)
})

const handleKeydown = (e: KeyboardEvent) => {
    if (e.key === 'Escape') {
        closeMobileMenu()
        if (!isMobile.value) {
            desktopActiveDepartment.value = null
            isDesktopMenuOpen.value = false
        }
    }
}

// Watch para mudanças de rota (Inertia)
watch(() => page.url, () => {
    initMobileActiveDepartment()
    desktopActiveDepartment.value = activeCategoryId.value
})

// Usa categories diretamente (filtro de produtos será feito posteriormente)
const visibleCategories = computed(() => {
    if (import.meta.env.DEV) {
        console.log('[Navigation] visibleCategories (all):', categories.value)
    }
    return categories.value
})

// Categoria ativa no desktop (para highlight)
const getDesktopActiveCategory = computed(() => {
    return desktopActiveDepartment.value || activeCategoryId.value
})

// Subcategorias da categoria ativa
const activeCategoryChildren = computed(() => {
    const activeCat = visibleCategories.value.find(c => c.entityId === getDesktopActiveCategory.value)
    return activeCat?.children || []
})

</script>
<template>
    <nav
        id="navigation"
        class="navigation"
        role="navigation"
        aria-label="Navegação de categorias"
        @mouseenter="handlePanelMouseEnter"
        @mouseleave="handlePanelMouseLeave"
    >
        <div class="navigation-inner">
            <div class="container">
                <!-- Toggle Mobile: Botão "Departamentos" -->
                <button
                    type="button"
                    class="navigation-mobile-toggle"
                    @click="toggleMobileMenu"
                    :aria-expanded="isMobileMenuOpen"
                    :aria-controls="isMobileMenuOpen ? 'mobile-departments-panel' : undefined"
                    aria-label="Abrir menu de departamentos"
                >
                        <span class="navigation-toggle-icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2">
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </span>
                    <span class="navigation-toggle-text">Departamentos</span>
                    <span class="navigation-toggle-arrow" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                            <polyline :points="isMobileMenuOpen ? '18 15 12 9 6 15' : '6 9 12 15 18 9'"></polyline>
                        </svg>
                        </span>
                </button>

                <!-- Menu Horizontal (Desktop) -->
                <ul
                    class="navigation-menu"
                    role="menubar"
                    aria-label="Categorias principais"
                >
                    <li
                        v-for="category in visibleCategories"
                        :key="category.entityId"
                        class="navigation-menu-item"
                        role="none"
                        @mouseenter="handleDesktopMouseEnter(category.entityId)"
                        @mouseleave="handleDesktopMouseLeave"
                    >
                        <Link
                            :href="category.slugKey"
                            class="navigation-menu-link"
                            :class="{ 'is-active': getDesktopActiveCategory === category.entityId }"
                            role="menuitem"
                            :aria-current="getDesktopActiveCategory === category.entityId ? 'page' : undefined"
                        >
                            {{ category.category }}
                        </Link>
                    </li>
                </ul>

                <!-- Painel Dropdown Desktop -->
                <div
                    v-show="!isMobile && isDesktopMenuOpen && getDesktopActiveCategory"
                    class="navigation-desktop-panel"
                    role="region"
                    aria-label="Subcategorias"
                    @mouseenter="handlePanelMouseEnter"
                    @mouseleave="handlePanelMouseLeave"
                >
                    <div class="navigation-panel-grid">
                        <!-- Sidebar: Lista de departamentos -->
                        <aside class="navigation-panel-sidebar">
                            <div class="navigation-panel-header">
                                <h3>Todos os departamentos</h3>
                            </div>
                            <ul class="navigation-department-list" role="list">
                                <li
                                    v-for="category in visibleCategories"
                                    :key="category.entityId"
                                    class="navigation-department-item"
                                >
                                    <button
                                        type="button"
                                        class="navigation-department-btn"
                                        :class="{
                                          'is-active': getDesktopActiveCategory === category.entityId,
                                          'has-children': category.hasChildren
                                        }"
                                        @mouseenter="handleDesktopMouseEnter(category.entityId)"
                                        @click="handleDesktopMouseEnter(category.entityId)"
                                        :aria-current="getDesktopActiveCategory === category.entityId ? 'true' : 'false'"
                                    >
                                        <span class="navigation-department-name">{{ category.category }}</span>
                                        <span
                                            v-if="category.hasChildren"
                                            class="navigation-department-arrow"
                                            aria-hidden="true"
                                        >
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                      </svg>
                    </span>
                                    </button>
                                </li>
                            </ul>
                        </aside>

                        <!-- Content: Subcategorias do departamento ativo -->
                        <div class="navigation-panel-content">
                            <section
                                v-for="category in visibleCategories"
                                :key="category.entityId"
                                class="navigation-department-content"
                                v-show="getDesktopActiveCategory === category.entityId"
                                role="region"
                                :aria-labelledby="`dept-title-${category.entityId}`"
                            >
                                <header class="navigation-content-header">
                                    <Link
                                        :href="category.slugKey"
                                        :id="`dept-title-${category.entityId}`"
                                        class="navigation-content-title"
                                    >
                                        {{ category.category }}
                                    </Link>
                                    <Link
                                        :href="category.slugKey"
                                        class="navigation-content-see-all"
                                    >
                                        Ver departamento
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2">
                                            <polyline points="9 18 15 12 9 6"></polyline>
                                        </svg>
                                    </Link>
                                </header>

                                <div v-if="category.hasChildren" class="navigation-children">
                                    <Link
                                        v-for="child in category.children"
                                        :key="child.entityId"
                                        :href="child.slugKey"
                                        class="navigation-child-link"
                                    >
                                        {{ child.category }}
                                    </Link>
                                </div>

                                <p v-else class="navigation-empty">
                                    Confira os produtos deste departamento.
                                </p>
                            </section>
                        </div>
                    </div>
                </div>

                <!-- Painel Mobile (Drawer) -->
                <div
                    v-show="isMobileMenuOpen"
                    class="navigation-mobile-overlay"
                    @click="closeMobileMenu"
                    aria-hidden="true"
                ></div>

                <aside
                    id="mobile-departments-panel"
                    v-show="isMobileMenuOpen"
                    class="navigation-mobile-panel"
                    role="search"
                    aria-modal="true"
                    aria-label="Menu de departamentos"
                >
                    <!-- Header Mobile -->
                    <header class="navigation-mobile-header">
                        <h2>Departamentos</h2>
                        <button
                            type="button"
                            class="navigation-mobile-close"
                            @click="closeMobileMenu"
                            aria-label="Fechar menu"
                        >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </header>

                    <!-- Lista de departamentos (nível 1) -->
                    <div
                        v-show="!isMobileDetail"
                        class="navigation-mobile-list"
                    >
                        <ul class="navigation-mobile-department-list" role="list">
                            <li
                                v-for="category in visibleCategories"
                                :key="category.entityId"
                                class="navigation-mobile-department-item"
                            >
                                <button
                                    type="button"
                                    class="navigation-mobile-department-btn"
                                    :class="{ 'is-active': mobileActiveDepartment === category.entityId }"
                                    @click="selectDepartmentMobile(category.entityId)"
                                >
                                    <span class="navigation-mobile-department-name">{{ category.category }}</span>
                                    <span
                                        v-if="category.hasChildren"
                                        class="navigation-mobile-department-arrow"
                                        aria-hidden="true"
                                    >
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                  </span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Detalhe do departamento (nível 2) -->
                    <div
                        v-show="isMobileDetail && mobileActiveDepartment"
                        class="navigation-mobile-detail"
                    >
                        <header class="navigation-mobile-detail-header">
                            <button
                                type="button"
                                class="navigation-mobile-back"
                                @click="goBackMobile"
                                aria-label="Voltar aos departamentos"
                            >
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                                <span>Voltar</span>
                            </button>
                        </header>

                        <section
                            v-for="category in visibleCategories"
                            :key="category.entityId"
                            v-show="mobileActiveDepartment === category.entityId"
                            class="navigation-mobile-department-content"
                        >
                            <Link
                                :href="category.slugKey"
                                class="navigation-mobile-department-title"
                            >
                                {{ category.category }}
                            </Link>

                            <div v-if="category.hasChildren" class="navigation-mobile-children">
                                <Link
                                    v-for="child in category.children"
                                    :key="child.entityId"
                                    :href="child.slugKey"
                                    class="navigation-mobile-child-link"
                                >
                                    {{ child.category }}
                                </Link>
                            </div>

                            <p v-else class="navigation-mobile-empty">
                                Confira os produtos deste departamento.
                            </p>
                        </section>
                    </div>
                </aside>

            </div>
        </div>
    </nav>
</template>
<style scoped>
/* ============================================================
   NAVIGATION COMPONENT - Mobile First
   ============================================================ */

/* Container principal */
.navigation {
    position: relative;
    width: 100%;
    background-color: var(--primary, #ff8400);
    color: #fff;
    z-index: 100;
}

.navigation-inner {
    width: 100%;
}

.container {
    position: relative;
}

/* ============================================================
   MOBILE TOGGLE BUTTON
   ============================================================ */
.navigation-mobile-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 14px 16px;
    background: transparent;
    border: none;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    text-align: left;
    cursor: pointer;
    white-space: nowrap;
}

.navigation-toggle-icon {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.navigation-toggle-text {
    flex: 1;
}

.navigation-toggle-arrow {
    flex-shrink: 0;
    transition: transform 0.2s ease;
}

.navigation-mobile-toggle[aria-expanded="true"] .navigation-toggle-arrow {
    transform: rotate(180deg);
}

/* ============================================================
   DESKTOP MENU (Horizontal)
   ============================================================ */
.navigation-menu {
    display: none; /* Hidden on mobile */
    align-items: center;
    gap: 4px;
    margin: 0;
    padding: 0;
    list-style: none;
}

.navigation-menu-item {
    position: relative;
}

.navigation-menu-link {
    display: block;
    padding: 14px 16px;
    color: #fff;
    font-size: 15px;
    font-weight: 500;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.15s ease, color 0.15s ease;
    white-space: nowrap;
}

.navigation-menu-link:hover,
.navigation-menu-link:focus {
    background-color: rgba(255, 255, 255, 0.15);
    color: #fff;
    outline: none;
}

.navigation-menu-link.is-active {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.navigation-menu-link:focus-visible {
    outline: 2px solid #fff;
    outline-offset: -2px;
}

/* ============================================================
   DESKTOP PANEL (Mega Menu)
   ============================================================ */
.navigation-desktop-panel {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    padding: 24px;
    background-color: #fff;
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12), 0 4px 8px rgba(0, 0, 0, 0.08);
    border-radius: 0 0 12px 12px;
    z-index: 999;
    animation: panelSlideDown 0.2s ease-out;
}

@keyframes panelSlideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.navigation-panel-grid {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 32px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Sidebar - Lista de departamentos */
.navigation-panel-sidebar {
    border-right: 1px solid var(--gray-200, #e6e9f0);
    padding-right: 24px;
}

.navigation-panel-header h3 {
    margin: 0 0 16px;
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-700, #272f43);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.navigation-department-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.navigation-department-item {
    margin-bottom: 4px;
}

.navigation-department-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 10px 12px;
    background: transparent;
    border: none;
    border-radius: 6px;
    color: var(--gray-700, #272f43);
    font-size: 14px;
    font-weight: 500;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-department-btn:hover,
.navigation-department-btn:focus {
    background-color: var(--gray-100, #f1f5f9);
    color: var(--primary, #ff8400);
    outline: none;
}

.navigation-department-btn.is-active {
    background-color: var(--primary-light, #ff9116);
    color: #fff;
}

.navigation-department-btn.is-active:hover {
    background-color: var(--primary, #ff8400);
    color: #fff;
}

.navigation-department-btn:focus-visible {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}

.navigation-department-name {
    flex: 1;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.navigation-department-arrow {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400, #555f7d);
    transition: color 0.15s ease;
}

.navigation-department-btn:hover .navigation-department-arrow,
.navigation-department-btn.is-active .navigation-department-arrow {
    color: inherit;
}

/* Content - Subcategorias */
.navigation-panel-content {
    min-width: 0; /* Para grid funcionar corretamente */
}

.navigation-department-content {
    animation: contentFadeIn 0.15s ease-out;
}

@keyframes contentFadeIn {
    from {
        opacity: 0;
        transform: translateX(8px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.navigation-department-content[v-show="true"] {
    display: block;
}

.navigation-content-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--gray-200, #e6e9f0);
}

.navigation-content-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-900, #0a0f1a);
    text-decoration: none;
    transition: color 0.15s ease;
}

.navigation-content-title:hover {
    color: var(--primary, #ff8400);
}

.navigation-content-see-all {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 500;
    color: var(--primary, #ff8400);
    text-decoration: none;
    transition: color 0.15s ease;
}

.navigation-content-see-all:hover {
    color: var(--primary-dark, #d56d00);
    text-decoration: underline;
}

.navigation-children {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 8px 16px;
}

.navigation-child-link {
    display: block;
    padding: 8px 10px;
    color: var(--gray-600, #363d56);
    font-size: 14px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-child-link:hover,
.navigation-child-link:focus {
    background-color: var(--gray-100, #f1f5f9);
    color: var(--primary, #ff8400);
    outline: none;
}

.navigation-child-link:focus-visible {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}

.navigation-empty {
    margin: 0;
    padding: 24px;
    color: var(--gray-500, #454f6a);
    font-size: 14px;
    text-align: center;
    background-color: var(--gray-50, #f8f9fa);
    border-radius: 8px;
}

/* ============================================================
   MOBILE OVERLAY & PANEL
   ============================================================ */
.navigation-mobile-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    animation: overlayFadeIn 0.2s ease-out;
}

@keyframes overlayFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.navigation-mobile-panel {
    display: none;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    max-width: 360px;
    background-color: #fff;
    z-index: 1001;
    display: flex;
    flex-direction: column;
    box-shadow: -8px 0 24px rgba(0, 0, 0, 0.12);
    animation: panelSlideIn 0.3s ease-out;
}

@keyframes panelSlideIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Mobile Header */
.navigation-mobile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border-bottom: 1px solid var(--gray-200, #e6e9f0);
    flex-shrink: 0;
}

.navigation-mobile-header h2 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-900, #0a0f1a);
}

.navigation-mobile-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: transparent;
    border: none;
    border-radius: 8px;
    color: var(--gray-600, #363d56);
    cursor: pointer;
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-mobile-close:hover,
.navigation-mobile-close:focus {
    background-color: var(--gray-100, #f1f5f9);
    color: var(--gray-900, #0a0f1a);
    outline: none;
}

.navigation-mobile-close:focus-visible {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}

/* Mobile List */
.navigation-mobile-list {
    flex: 1;
    overflow-y: auto;
    padding: 8px 0;
}

.navigation-mobile-department-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

.navigation-mobile-department-item {
    border-bottom: 1px solid var(--gray-100, #e6e9f0);
}

.navigation-mobile-department-item:last-child {
    border-bottom: none;
}

.navigation-mobile-department-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 16px;
    background: transparent;
    border: none;
    color: var(--gray-700, #272f43);
    font-size: 16px;
    font-weight: 500;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-mobile-department-btn:hover,
.navigation-mobile-department-btn:focus {
    background-color: var(--gray-50, #f8f9fa);
    color: var(--primary, #ff8400);
    outline: none;
}

.navigation-mobile-department-btn.is-active {
    background-color: var(--primary-light, #fff3e6);
    color: var(--primary, #ff8400);
}

.navigation-mobile-department-name {
    flex: 1;
}

.navigation-mobile-department-arrow {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400, #555f7d);
}

/* Mobile Detail */
.navigation-mobile-detail {
    display: none;
    flex-direction: column;
    height: 100%;
    overflow-y: auto;
    animation: detailSlideIn 0.25s ease-out;
}

@keyframes detailSlideIn {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.navigation-mobile-detail[v-show="true"] {
    display: flex;
}

.navigation-mobile-detail-header {
    display: flex;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid var(--gray-200, #e6e9f0);
    flex-shrink: 0;
}

.navigation-mobile-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: transparent;
    border: none;
    border-radius: 8px;
    color: var(--gray-600, #363d56);
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-mobile-back:hover,
.navigation-mobile-back:focus {
    background-color: var(--gray-100, #f1f5f9);
    color: var(--gray-900, #0a0f1a);
    outline: none;
}

.navigation-mobile-back:focus-visible {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}

.navigation-mobile-department-content {
    flex: 1;
    padding: 20px 16px;
}

.navigation-mobile-department-title {
    display: block;
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 600;
    color: var(--gray-900, #0a0f1a);
    text-decoration: none;
}

.navigation-mobile-children {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.navigation-mobile-child-link {
    display: block;
    padding: 14px 16px;
    color: var(--gray-600, #363d56);
    font-size: 15px;
    text-decoration: none;
    border-radius: 8px;
    background-color: var(--gray-50, #f8f9fa);
    transition: background-color 0.15s ease, color 0.15s ease;
}

.navigation-mobile-child-link:hover,
.navigation-mobile-child-link:focus {
    background-color: var(--gray-100, #f1f5f9);
    color: var(--primary, #ff8400);
    outline: none;
}

.navigation-mobile-child-link:focus-visible {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}

.navigation-mobile-empty {
    margin: 0;
    padding: 32px 16px;
    color: var(--gray-500, #454f6a);
    font-size: 15px;
    text-align: center;
}

/* ============================================================
   RESPONSIVE: TABLET (≥768px) - Mostra toggle + menu horizontal
   ============================================================ */
@media (min-width: 768px) {
    .navigation-mobile-toggle {
        display: none;
    }

    .navigation-menu {
        display: flex;
    }
}

/* ============================================================
   RESPONSIVE: DESKTOP (≥1024px) - Full mega menu
   ============================================================ */
@media (min-width: 1024px) {
    .navigation {
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .navigation-mobile-overlay,
    .navigation-mobile-panel {
        display: none !important;
    }

    .navigation-desktop-panel {
        display: block;
    }
}

/* ============================================================
   ACCESSIBILITY: Reduced motion
   ============================================================ */
@media (prefers-reduced-motion: reduce) {
    .navigation-desktop-panel,
    .navigation-department-content,
    .navigation-mobile-overlay,
    .navigation-mobile-panel,
    .navigation-mobile-detail {
        animation: none !important;
    }
}

/* ============================================================
   FOCUS VISIBLE POLYFILL (para navegadores antigos)
   ============================================================ */
.navigation-menu-link:focus:not(:focus-visible),
.navigation-department-btn:focus:not(:focus-visible),
.navigation-child-link:focus:not(:focus-visible),
.navigation-mobile-department-btn:focus:not(:focus-visible),
.navigation-mobile-back:focus:not(:focus-visible),
.navigation-mobile-child-link:focus:not(:focus-visible),
.navigation-mobile-close:focus:not(:focus-visible),
.navigation-content-title:focus:not(:focus-visible),
.navigation-content-see-all:focus:not(:focus-visible) {
    outline: none;
}

.navigation-menu-link:focus-visible,
.navigation-department-btn:focus-visible,
.navigation-child-link:focus-visible,
.navigation-mobile-department-btn:focus-visible,
.navigation-mobile-back:focus-visible,
.navigation-mobile-child-link:focus-visible,
.navigation-mobile-close:focus:not(:focus-visible),
.navigation-content-title:focus:not(:focus-visible),
.navigation-content-see-all:focus:not(:focus-visible) {
    outline: 2px solid var(--primary, #ff8400);
    outline-offset: 2px;
}
</style>
