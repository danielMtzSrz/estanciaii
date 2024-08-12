import "./bootstrap";
import "../css/app.css";

import "/node_modules/bootstrap-icons/font/bootstrap-icons.css";
import "/node_modules/bootstrap/dist/css/bootstrap.css";
import "/node_modules/bootstrap/dist/js/bootstrap.js";

import "primevue/resources/primevue.min.css ";
import "primeicons/primeicons.css";
import "/node_modules/primeflex/primeflex.css";

import { createApp, h } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import Tooltip from "primevue/tooltip";
import { Link } from "@inertiajs/inertia-vue3";

// Componentes usados generalmente
import Button from "primevue/button";

// Roles y permisos
import VueGates from "vue-gates";
import Permissions from "./Plugins/Permissions";

import { spatieMixin } from "./mixin/spatie-mixin";

// Pinia
import { createPinia } from "pinia";

const router = createRouter({
        history: createWebHistory(import.meta.env.BASE_URL),
        routes: [],
    }),
    pinia = createPinia(),
    appName =
        window.document.getElementsByTagName("title")[0]?.innerText ||
        "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return (
            createApp({ render: () => h(app, props) })
                .use(plugin)
                .use(ZiggyVue, Ziggy)
                .use(PrimeVue)
                .use(ToastService)
                .use(router)
                .use(VueGates)
                .use(Permissions)
                .use(pinia)
                // Directives
                .directive("tooltip", Tooltip)
                // Components
                .component("Link", Link)
                .component("Button", Button)
                // Mixins
                .mixin(spatieMixin)
                .mount(el)
        );
    },
});

InertiaProgress.init({ color: "#4B5563" });
