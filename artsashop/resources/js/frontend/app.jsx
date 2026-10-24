import {createInertiaApp} from '@inertiajs/react'
import {createRoot} from 'react-dom/client'

// Importar Swiper
// import styles bundle
import 'swiper/css/bundle';
import './plugins/masks'
import './plugins/validators'
import './scripts'


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.jsx')
        return pages[`./Pages/${name}.jsx`]()
    },
    setup({el, App, props}) {
        createRoot(el).render(<App {...props} />)
    },
})

