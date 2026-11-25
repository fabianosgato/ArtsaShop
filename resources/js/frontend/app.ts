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
// Explicitly type the glob imports: each returns a module with a default export of DefineComponent
const mainPages = import.meta.glob<{ default: DefineComponent }>('./pages/**/*.vue');
const allModulePages = import.meta.glob<{ default: DefineComponent }>('../../../Modules/*/resources/js/frontend/pages/**/*.vue');
const enabledModules = (await import("../../../modules_statuses.json")).default as EnabledModules;

createInertiaApp({
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
    const [moduleName, page] = pageUri.split('::');

    // Determine the base path and glob map based on module
    let pageImport: (() => Promise<{ default: DefineComponent }>) | undefined;
    let pagePath = "";

    if (!moduleName || moduleName.toLowerCase() === 'home') {
        // Main app pages (including home special case)
        // If moduleName is "home", page will be "index" or similar
        // If no moduleName, page is the actual page name
        const pageName = moduleName ? 'Home' : page;
        pagePath = `./pages/${pageName}.vue`;
        pageImport = mainPages[pagePath];
    } else {
        // Module pages
        if (!enabledModules[moduleName]) {
            throw new Error(`Module not enabled: ${moduleName}`);
        }
        pagePath = `../../../Modules/${moduleName}/resources/js/frontend/pages/${page}.vue`;
        pageImport = allModulePages[pagePath];
    }

    if (!pageImport) {
        throw new Error(`Page not found: ${pagePath}`);
    }

    const pageModule = await pageImport();
    return pageModule.default;
}
