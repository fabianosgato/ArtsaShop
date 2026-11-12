<script setup lang="ts">
import {computed, ref} from 'vue'
import {Link, usePage} from '@inertiajs/vue3'
import {route} from "ziggy-js";

const page = usePage()
const open = ref(false)

// Auth state vem do Inertia shared props (Laravel → Inertia)
const isLoggedIn = computed(() => page.props.auth?.user !== undefined)
const userName = computed(() => page.props.auth?.user?.customer_name || '')

const toggleMenu = () => {
    open.value = !open.value
}

const closeMenu = () => {
    open.value = false
}

const logout = () => {
    // Inertia POST para rota de logout
    window.location.href = route('account.logout')
}
</script>

<template>
    <div id="top_header" class="bg-gray-50 border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-2">
            <div class="flex flex-col md:flex-row items-center justify-between gap-3 py-2">
                <!-- Left: Account Menu -->
                <div class="topheader-left relative w-full md:w-auto" @click.outside="closeMenu">
                    <button
                        type="button"
                        class="account-top-menu flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-gray-100 rounded-lg transition"
                        @click="toggleMenu"
                        :aria-expanded="open"
                        aria-label="Abrir menu da conta"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="hidden sm:inline">Minha conta</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <Transition enter-active-class="transition ease-out duration-100" enter-from-class="opacity-0 transform -translate-y-1" leave-active-class="transition ease-in duration-75" leave-to-class="opacity-0 transform -translate-y-1">
                        <ul v-show="open" class="links topheader-mobile-trigger absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-50" role="menu">
                            <template v-if="isLoggedIn">
                                <li class="wellcome px-4 py-2 text-sm font-medium text-gray-900 border-b border-gray-100">
                                    Olá, {{ userName }}
                                </li>
                                <li role="none">
                                    <Link href="javascript:void(0)" class="customer-loggedin block px-4 py-2 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50" role="menuitem" @click="() => window.location.href = route('account.index')">
                                        Minha Conta
                                    </Link>
                                </li>
                                <li role="none">
                                    <Link href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50" role="menuitem" @click="() => window.location.href = '/wishlist'">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        Meus Favoritos
                                        <span v-if="wishlistStore.count > 0" class="ml-2 bg-orange-100 text-orange-700 text-xs px-2 py-0.5 rounded-full">{{ wishlistStore.count }}</span>
                                    </Link>
                                </li>
                                <li role="none">
                                    <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50" role="menuitem" @click="logout">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Sair
                                    </button>
                                </li>
                            </template>

                            <template v-else>
                                <li class="wellcome px-4 py-2 text-sm font-medium text-gray-900 border-b border-gray-100">
                                    Seja Bem-vindo
                                </li>
                                <li role="none">
                                    <Link href="javascript:void(0)" class="block px-4 py-2 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50" role="menuitem" @click="() => window.location.href = route('account.login')">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Entrar / Registre-se
                                    </Link>
                                </li>
                            </template>
                        </ul>
                    </Transition>
                </div>

                <!-- Right: Links Úteis -->
                <div class="topheader-right w-full md:w-auto">
                    <ul class="links flex flex-wrap items-center justify-end gap-4 md:gap-6">
                        <li class="link">
                            <Link href="/" class="text-sm text-gray-600 hover:text-orange-600 transition" role="menuitem">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Home
                            </Link>
                        </li>
                        <li class="link">
                            <Link href="/quem-somos" class="text-sm text-gray-600 hover:text-orange-600 transition" role="menuitem">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Quem Somos
                            </Link>
                        </li>
                        <li class="contact-us-now link">
                            <Link href="/fale-conosco" class="text-sm font-medium text-orange-600 hover:text-orange-700 transition flex items-center gap-1" role="menuitem">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                Fale Conosco
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Garante que o dropdown feche ao clicar fora */
:deep(.topheader-left) {
    @apply relative;
}
</style>
