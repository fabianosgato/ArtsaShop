import {createInertiaApp} from '@inertiajs/vue3'
import type {DefineComponent} from 'vue'
import {createApp, h} from 'vue'
import {renderToString} from 'vue/server-renderer'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'

const modules = import.meta.glob('./pages/**/*.vue')

createInertiaApp({
  resolve: (name: string): Promise<DefineComponent> =>
    resolvePageComponent(
      `./pages/${name}.vue`,
      modules
    ) as Promise<DefineComponent>,

  setup({ App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin)
    return renderToString(app)
  },

  progress: false,
})
