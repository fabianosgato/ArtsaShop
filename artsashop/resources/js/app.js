import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'
import {ZiggyVue} from 'ziggy-js'
import appLayout from './Layouts/AppLayout.vue'
import {vMask} from './Directives/mask'

// O glob precisa de strings literais (não aceita variáveis)
const pages = {
    ...import.meta.glob('./Pages/**/*.vue'),
    ...import.meta.glob('../../Modules/*/resources/assets/js/Pages/**/*.vue'),
}

async function resolvePage(name) {
    let path
    console.log(name)
    if (name.includes('::')) {
        // 'Checkout::Frontend/Cart' -> Modules/Checkout/.../Pages/Frontend/Cart.vue
        const [module, page] = name.split('::')
        path = `../../Modules/${module}/resources/assets/js/Pages/${page}.vue`
    } else {
        path = `./Pages/${name}.vue`
    }

    const loader = pages[path]

    if (!loader) {
        throw new Error(`Página Inertia não encontrada: "${name}" (procurei em ${path})`)
    }

    const page = await loader()

    // Layout padrão, sem sobrescrever páginas que definem o próprio
    page.default.layout ??= appLayout

    return page

}

createInertiaApp({
    title: (title) => `ArtisaShop ~ ${title}`,
    resolve: resolvePage,

    // resolve: name => {
    //     const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    //     let page = pages[`./Pages/${name}.vue`];
    //     page.default.layout = appLayout;
    //     return page;
    // },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .directive('mask', vMask)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el)
    },
})
