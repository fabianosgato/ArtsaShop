<script setup lang="ts">
import {computed, onMounted, onUnmounted, ref} from 'vue'
import {useUserLocation} from '../composables/useUserLocation'
import LocationForm from './LocationForm.vue'
import {useGeolocation} from '@/composables/useGeolocation'

import IconLocation from '@/components/icons/IconLocation.vue'
import IconChevronDown from '@/components/icons/IconChevronDown.vue'
import IconCurrentLocation from '@/components/icons/IconCurrentLocation.vue'

const { location, updateLocation } = useUserLocation()

const { getCurrentPosition, loading: geoLoading, error: geoError } = useGeolocation()

const open = ref(false)

const displayLocation = computed(() => {
    console.log(location.value)
    const loc = location.value
    const parts = []
    if (loc?.city) parts.push(loc.city)
    if (loc?.state_code) parts.push(loc.state_code)
    if (loc?.country_name) parts.push(loc.country_name)
    return parts.join(', ') || 'Brasil'
})

const hasLocation = computed(() => {
    const loc = location.value
    return !!(loc?.city || loc?.state_code || loc?.country_name)
})

const close = () => {
    open.value = false
}

const handleClickOutside = (event: MouseEvent) => {
    const dropdown = document.getElementById('location-dropdown')
    if (dropdown && !dropdown.contains(event.target as Node)) {
        open.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
})

const useCurrentLocation = async () => {
    try {
        const coords = await getCurrentPosition()

        // Reverse geocoding via Nominatim (OpenStreetMap)
        const response = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${coords.latitude}&lon=${coords.longitude}&addressdetails=1&accept-language=pt-BR`
        )
        const data = await response.json()

        if (data.address) {
            const location = {
                country_code: data.address.country_code?.toUpperCase() || 'BR',
                country_name: data.address.country || 'Brasil',
                state_code: data.address.state || '',
                state_name: data.address.state || '',
                city: data.address.city || data.address.town || data.address.village || data.address.municipality || '',
                postal_code: data.address.postcode || '',
                currency: 'BRL',
                locale: 'pt_BR',
                timezone: 'America/Sao_Paulo',
            }

            updateLocation(location)

            // Opcional: salvar no backend
            await fetch('/location/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify(location),
            })

            close()
        }
    } catch (err) {
        console.error('Erro ao obter localização:', err)
        alert('Não foi possível obter sua localização. Verifique as permissões do navegador.')
    }
}
</script>

<template>
    <div id="location-dropdown" class="relative">
        <!-- Trigger Button -->
        <button
            type="button"
            class="location-trigger flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition"
            @click="open = !open"
            :aria-expanded="open"
            aria-label="Alterar local de entrega"
        >
            <IconLocation class="w-5 h-5 text-orange-600" />
            <span class="hidden sm:inline block truncate" style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ displayLocation }}</span>
            <IconChevronDown class="w-4 h-4 ml-1 text-gray-400" />
        </button>

        <!-- Dropdown Panel -->
        <Transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="opacity-0 transform -translate-y-1"
            leave-active-class="transition ease-in duration-75"
            leave-to-class="opacity-0 transform -translate-y-1"
        >
            <div
                v-show="open"
                id="location-dropdown"
                class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-xl shadow-lg py-1 z-50"
                role="menu"
                aria-orientation="vertical"
            >
                <!-- Current Location Display -->
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 rounded-t-xl">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Entregando para</p>
                    <p class="text-sm font-medium text-gray-900 truncate">{{ displayLocation }}</p>
                </div>

                <!-- Location Form (inline no dropdown) -->
                <LocationForm @saved="close" />

                <!-- Divider -->
                <hr class="border-gray-100 my-1" />

                <!-- Quick Actions -->
                <div class="px-4 py-2 space-y-1">
                    <button
                        :disabled="geoLoading"
                        class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:text-orange-600 hover:bg-gray-50 rounded-lg transition"
                        @click="useCurrentLocation"
                    >
                        <IconCurrentLocation class="w-5 h-5 flex-shrink-0 text-orange-600" />
                        <span v-if="geoLoading">Obtendo localização...</span>
                        <span v-else>Usar minha localização atual</span>
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>
