<script setup lang="ts">
import {useGeolocation} from '@/composables/useGeolocation'
import {usePage} from '@inertiajs/vue3'

const page = usePage()
const { coords, error, loading, getCurrentPosition } = useGeolocation()

const userLocation = page.props.userLocation // Do server-side (IP)

const detectLocation = async () => {
    try {
        await getCurrentPosition()
        // Enviar coords para backend para calcular frete/lojas próximas
        // await axios.post(route('location.update'), coords.value)
    } catch (err) {
        // Fallback para userLocation (IP)
    }
}
</script>

<template>
    <div class="location-prompt flex items-center gap-2 p-3 bg-blue-50 border border-blue-200 rounded-lg">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>

        <div class="flex-1 text-sm">
            <p class="font-medium text-blue-900">Quer entregas mais precisas?</p>
            <p class="text-blue-700">Permita acesso à sua localização</p>
        </div>

        <button
            :disabled="loading"
            @click="detectLocation"
            class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-white border border-blue-300 rounded-lg hover:bg-blue-50 transition disabled:opacity-50"
        >
            <span v-if="loading">Detectando...</span>
            <span v-else>Permitir</span>
        </button>
    </div>
</template>
