import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'FUSS';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toasity,
							{
								position: 'bottom-right',
          			rtl: false,
          			hideProgressBar: true,
          			newestOnTop: true,
          			closeOnClick: true,
          			pauseOnFocusLoss: true,
          			pauseOnHover: true,
          			draggable: true,
							})
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
