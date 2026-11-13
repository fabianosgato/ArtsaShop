<script setup lang="ts">
import {computed, onMounted, onUnmounted, ref} from 'vue'
import {Link, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'

const page = usePage()

// Auth state via Inertia shared props
const customer = page.props.auth.customer ?? undefined
const userName = computed(() => customer?.customer_name || '')
const open = ref(false)

const toggle = () => {
    open.value = !open.value
}

const close = () => {
    open.value = false
}

// Close on outside click
const handleClickOutside = (event: MouseEvent) => {
    const dropdown = document.getElementById('user-dropdown')
    if (dropdown && !dropdown.contains(event.target as Node)) {
        close()
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <div id="user-dropdown" class="relative">
        <!-- Trigger Button -->
        <button
            type="button"
            class="user-dropdown-trigger flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 hover:bg-gray-100 rounded-lg transition"
            @click="toggle"
            :aria-expanded="open"
            aria-label="Abrir menu do usuário"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="hidden sm:inline">
                {{ customer ? userName : 'Minha Conta' }}
            </span>
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <Transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="opacity-0 transform -translate-y-1"
            leave-active-class="transition ease-in duration-75"
            leave-to-class="opacity-0 transform -translate-y-1"
        >
            <div
                v-show="open"
                class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-50"
                role="menu"
                aria-orientation="vertical"
            >
                <template v-if="customer">
                    <!-- Welcome -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">Olá, {{ userName }}</p>
                    </div>

                    <!-- Account Links -->
                    <div class="py-1">
                        <Link
                            :href="route('account.index')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Minha Conta
                        </Link>

                        <Link
                            :href="route('account.orders')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 002-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Meus Pedidos
                        </Link>

                        <Link
                            :href="route('account.wishlist.index')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Lista de Desejos
                        </Link>

                        <!-- Divider -->
                        <hr class="border-gray-100 my-1" />

                        <!-- Cart & Help -->
                        <Link
                            :href="route('checkout.cart')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Meu Carrinho
                        </Link>

                        <Link
                            :href="route('contacts.index')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Ajuda
                        </Link>

                        <Link
                            :href="route('index.home') + 'quem-somos'"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Quem Somos
                        </Link>

                        <!-- Logout -->
                        <hr class="border-gray-100 my-1" />
                        <button
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 transition"
                            role="menuitem"
                            @click="() => window.location.href = route('account.logout')"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Sair
                        </button>
                    </div>
                </template>

                <template v-else>
                    <!-- Not Logged In Welcome -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">Seja Bem-vindo</p>
                        <p class="text-xs text-gray-500 mt-0.5">Entre ou registre-se</p>
                    </div>

                    <!-- Account Links -->
                    <div class="py-1">
                        <Link
                            :href="route('account.login')"
                            class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 transition"
                            role="menuitem"
                            @click="close"
                        >
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Entrar / Cadastrar
                        </Link>
                    </div>
                </template>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
/* Garante posicionamento correto do dropdown */
#user-dropdown {
    @apply relative;
}
</style>
