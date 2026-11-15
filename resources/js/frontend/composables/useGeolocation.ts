// resources/js/frontend/composables/useGeolocation.ts
import {ref} from 'vue'

export interface GeoCoords {
    latitude: number
    longitude: number
    accuracy: number
}

export function useGeolocation() {
    const coords = ref<GeoCoords | null>(null)
    const error = ref<string | null>(null)
    const loading = ref(false)

    const getCurrentPosition = (): Promise<GeoCoords> => {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocalização não suportada'))
                return
            }

            loading.value = true
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const coordsData = {
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude,
                        accuracy: pos.coords.accuracy,
                    }
                    coords.value = coordsData
                    loading.value = false
                    resolve(coordsData)
                },
                (err) => {
                    loading.value = false
                    error.value = err.message
                    reject(err)
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 300000, // 5 min cache
                }
            )
        })
    }

    const watchPosition = (callback: (coords: GeoCoords) => void) => {
        if (!navigator.geolocation) return null

        return navigator.geolocation.watchPosition(
            (pos) => callback({
                latitude: pos.coords.latitude,
                longitude: pos.coords.longitude,
                accuracy: pos.coords.accuracy,
            }),
            (err) => error.value = err.message,
            { enableHighAccuracy: true }
        )
    }

    return { coords, error, loading, getCurrentPosition, watchPosition }
}
