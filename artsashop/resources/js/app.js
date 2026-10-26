import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'
import {ZiggyVue} from 'ziggy-js'
import appLayout from './Layouts/AppLayout.vue'
import {vMask} from './Directives/mask'

createInertiaApp({
    title: (title) => `ArtisaShop ~ ${title}`,
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = appLayout;
        return page;
    },
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
