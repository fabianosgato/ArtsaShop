import {computed, ref} from 'vue'
import {usePage} from '@inertiajs/vue3'

export interface UserLocation {
    ip?: string
    country_code?: string
    country_name?: string
    state_code?: string
    state_name?: string
    city?: string
    postal_code?: string
    latitude?: number
    longitude?: number
    timezone?: string
    currency?: string
    locale?: string
}

export function useUserLocation() {
    const page = usePage()

    // Estado local para override manual (dev tools OU atualização via API)
    const manualOverride = ref<UserLocation | null>(null)

    const location = computed<UserLocation | null>(() => {
        // 1. Override manual (dev tools OU atualização via API)
        if (manualOverride.value) return manualOverride.value

        // 2. Do Inertia (server-side GeoIP)
        return page.props.userLocation as UserLocation | null ?? null
    })

    // Atualiza o override
    const updateLocation = (newLocation: UserLocation) => {
        manualOverride.value = newLocation
    }

    const clearOverride = () => {
        manualOverride.value = null
    }

    return {
        location,
        updateLocation,
        clearOverride,
    }
}
