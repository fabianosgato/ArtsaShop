import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import {ZiggyVue} from 'ziggy-js'
import appLayout from './Layouts/AppLayout.vue'

createInertiaApp({
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
            .mount(el)
    },
})
