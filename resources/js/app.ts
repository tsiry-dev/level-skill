import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import Layout from './layouts/Layout.vue';



// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),

    resolve: async (name) => {
        const pages = import.meta.glob<DefineComponent>('./pages/**/*.vue');
        const normalizedName = name.replace(/^pages\//, '');

        const page = await resolvePageComponent(`./pages/${normalizedName}.vue`, pages);

        if(
            !normalizedName.startsWith('auth/') &&
            !normalizedName.startsWith('settings/') &&
             normalizedName !== 'Dashboard' &&
             normalizedName !== 'HomeView'
        ) {
            page.default.layout = Layout;
        }
        // if(normalizedName.startsWith('admin/')){

        //     page.default.layout = null;

        // }else if(
        //     !normalizedName.startsWith('auth/') &&
        //     !normalizedName.startsWith('settings/') &&
        //      normalizedName !== 'Dashboard' &&
        //      normalizedName !== 'HomeView'
        // ) {
        //     page.default.layout = Layout;
        // }

        return page;

    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
