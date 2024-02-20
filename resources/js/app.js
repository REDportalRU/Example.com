import {createApp, h} from 'vue'
import {createInertiaApp} from '@inertiajs/vue3'
import CKEditor from '@ckeditor/ckeditor5-vue'
// https://github.com/KABBOUCHI/vue-tippy
// https://vue-tippy.netlify.app/
// (npm install --save vue-tippy)
import VueTippy from 'vue-tippy'
import 'tippy.js/dist/tippy.css'
import 'tippy.js/animations/scale.css'
// https://primevue.org/vite/
// https://primevue.org/multiselect/
import PrimeVue from 'primevue/config'
import 'primevue/resources/themes/bootstrap4-light-blue/theme.css'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(CKEditor)
            .use(VueTippy,
                {
                    directive: 'tippy', // => v-tippy
                    component: 'tippy', // => <tippy/>
                    componentSingleton: 'tippy-singleton', // => <tippy-singleton/>,
                    defaultProps: {
                        theme: 'light',
                        animation: 'scale',
                        placement: 'auto-end',
                        allowHTML: true,
                        arrow: true,
                    },
                })
            .use(PrimeVue)
            .mount(el)
    },
    progress: false,
    // progress: {
    //     delay: 250,
    //     color: '#0088cc',
    //     includeCSS: true,
    //     showSpinner: false,
    // }
})
