import type {UserLocation} from '@/composables/useUserLocation'

// CartSummary baseado no getSummary() do CheckoutCartService
interface CartSummary {
    items_count: number
    total_qty: number
    subtotal: number
    subtotal_fmt: string
}

// Store props
interface StoreProps {
    code: string
    layout: string
    store_name?: string
    // adicione outros campos da store se necessário
}

// CurrentStore (vem do app('currentStore'))
interface CurrentStore extends StoreProps {
    id?: number
    name?: string
    url?: string
}

// SearchConfig
interface SearchConfig {
    minQueryLength: number
    maxQueryLength: number
    maxQueryWords: number
}

// Auth customer
interface AuthCustomer {
    customer_id: number
    customer_name: string
    customer_email: string
}

// Flash messages
interface Flash {
    success: () => string | null
    error: () => string | null
}

// Route info
interface RouteInfo {
    name: string | null
}

declare module '@inertiajs/vue3' {
    interface PageProps {
        // App
        appName: string
        appUrl: string
        assetUrl: string

        // Store
        currentStore: CurrentStore
        store: StoreProps

        // Route
        route: RouteInfo

        // Auth
        auth: {
            customer: AuthCustomer | null
        }

        // Flash
        flash: Flash

        // Search
        searchConfig: SearchConfig

        // Pagarme
        pagarmePublicKey: string

        // CSRF
        csrf_token: string

        // User Location (GeoIP)
        userLocation: UserLocation | null

        // Cart Summary
        cart: CartSummary | null
    }
}
