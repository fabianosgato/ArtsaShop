import {createInertiaApp} from '@inertiajs/vue3'
import type {DefineComponent} from 'vue'
import {createApp, h} from 'vue'
import {ZiggyVue} from 'ziggy-js'
import {createPinia} from 'pinia'
import '../../css/frontend/app.css'
import Button from './ui/Button.vue'

// Type for the enabled modules JSON
interface EnabledModules {
    [key: string]: boolean;
}

// Static globs - Vite requires static strings at compile time
const mainPages = import.meta.glob('./pages/**/*.vue');
const allModulePages = import.meta.glob('../../../Modules/*/resources/js/frontend/pages/**/*.vue');
const enabledModules = (await import("../../../modules_statuses.json")).default as EnabledModules;

createInertiaApp({
    // resolve: (name: string): Promise<DefineComponent> =>
    //     resolvePageComponent(
    //         `./pages/${name}.vue`,
    //         modules
    //     ) as Promise<DefineComponent>,

    resolve: name => resolvePage(name),

    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)})
        app.use(plugin)
        app.use(ZiggyVue)
        app.use(createPinia())
        app.mount(el)
        app.component('Button', Button)
    },

    progress: {
        color: '#ff8400',
        showSpinner: true,
    },
})


async function resolvePage(pageUri: string): Promise<DefineComponent> {
    const [module, page] = pageUri.split('::');

    let pageImport: (() => Promise<DefineComponent>) | undefined;
    let pagePath = "";

    if (!module) {
        // Main app page: ./pages/{page}.vue

        pagePath = `./pages/${page}.vue`;
        pageImport = mainPages[pagePath];
    } else {
        // Module page: ../../../Modules/{Module}/resources/js/frontend/pages/{page}.vue
        // Check if module is enabled
        if (!enabledModules[module]) {
            throw new Error(`Module not enabled: ${module}`);
        }

        pagePath = `../../../Modules/${module}/resources/js/frontend/pages/${page}.vue`;
        pageImport = allModulePages[pagePath];
    }

    if (!pageImport) {
        throw new Error(`Page not found: ${pagePath}`);
    }

    return pageImport();
}
