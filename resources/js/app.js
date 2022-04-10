require('./bootstrap')
require('./eventBus')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { Link, Head } from '@inertiajs/inertia-vue3'
import Flash from '@/Components/FlashNoti'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .component('Flash', Flash)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
})

InertiaProgress.init({ color: '#4B5563', showSpinner: true })
