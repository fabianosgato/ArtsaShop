import {createInertiaApp} from '@inertiajs/vue3'
import type {DefineComponent} from 'vue'
import {createApp, h} from 'vue'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import {ZiggyVue} from 'ziggy-js'
import {createPinia} from 'pinia'
import '../../css/frontend/app.css'

const modules = import.meta.glob('./pages/frontend/**/*.vue')

createInertiaApp({
  resolve: (name: string): Promise<DefineComponent> =>
    resolvePageComponent(
      `./pages/frontend/${name}.vue`,
      modules
    ) as Promise<DefineComponent>,

  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })

    app.use(plugin)
    app.use(ZiggyVue)
    app.use(createPinia())

    app.mount(el)
  },

  progress: {
    color: '#ff8400',
    showSpinner: true,
  },
})
