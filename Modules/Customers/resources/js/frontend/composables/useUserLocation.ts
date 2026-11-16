// resources/js/frontend/composables/useUserLocation.ts
import {computed, ref} from 'vue'
import {usePage} from '@inertiajs/vue3'

export interface UserLocation {
    ip?: string
    country_code: string
    country_name: string
    state_code?: string
    state_name?: string
    city?: string
    postal_code?: string
    latitude?: number
    longitude?: number
    timezone?: string
    currency: string
    locale: string
}

export function useUserLocation() {
    const page = usePage()

    // Estado local para override em dev
    const manualOverride = ref<UserLocation | null>(null)

    const location = computed<UserLocation>(() => {
        // 1. Override manual (dev tools)
        if (manualOverride.value) return manualOverride.value

        // 2. Do Inertia (server-side GeoIP)
        return page.props.userLocation as UserLocation ?? {
            country_code: 'BR',
            country_name: 'Brasil',
            state_code: 'SP',
            state_name: 'São Paulo',
            city: 'São Paulo',
            currency: 'BRL',
            locale: 'pt_BR',
            timezone: 'America/Sao_Paulo',
        }
    })

    // Para dev tools: window.__SET_LOCATION__(location)
    if (import.meta.env.DEV && typeof window !== 'undefined') {
        (window as any).__SET_LOCATION__ = (loc: UserLocation) => {
            manualOverride.value = loc
        }
        ;(window as any).__CLEAR_LOCATION__ = () => {
            manualOverride.value = null
        }
    }

    return {
        location,
        setManualOverride: (loc: UserLocation) => manualOverride.value = loc,
        clearOverride: () => manualOverride.value = null,
    }
}
