<script setup>
import { Head, Link, usePage, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

import Galleria from 'primevue/galleria';
import Menubar from "primevue/menubar";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Checkbox from 'primevue/checkbox';
import Button from "primevue/button";
import Image from 'primevue/image';

defineProps({
    title: String,
});
</script>
    
    <template>
        <Head :title="title" />
        <div>        
            <div
                class="min-h-screen dark:modoOscuro"
                :class="{ modoOscuro: darkMode }"
                id="contentMain"
            >
            <Menubar :model="items" class="container-fluid">
                <template #start>
                    Algo al principio
                </template>
                <template #end>
                    <div class="d-flex align-items-center space-x-2">
                        <Button
                            :icon="darkMode == true ? 'pi pi-moon' : 'pi pi-sun'"
                            class="p-button-rounded"
                            :class="
                                darkMode == true
                                    ? 'p-button-text p-button-help'
                                    : 'p-button-warning p-button-outlined'
                            "
                            id="darkModeId"
                            name="darkModeId"
                            @click="themeColor"
                        />
                        <Link :href="route('login')" class="text-sm text-gray-400 underline">
                            Iniciar sesión
                        </Link>
    
                        <Link :href="route('register')" class="ml-4 text-sm text-gray-400 underline">
                            Crear usuario
                        </Link>
                    </div>
                </template>
            </Menubar>
    
                <!-- Page Content -->
                <div class="col-md-">
                    <slot name="content"/>
                </div>
            </div>
        </div>
    </template>
    
    <script>
    export default {
        data() {
            return {
                darkMode: true,
                checked: true,
                home: {
                    icon: "pi pi-home",
                    url: route("dashboard"),
                },
                items: usePage().props.value.breadcrumbItems,
                activeIndex: 0,
                images: [
                    {
                        "itemImageSrc": "/storage/login/img1.jpg",
                        "thumbnailImageSrc": "/storage/login/img1.jpg",
                        "alt": "Descripción de la imagen 1",
                        "title": "Imágen 1"
                    },
                    {
                        "itemImageSrc": "/storage/login/img2.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                    {
                        "itemImageSrc": "/storage/login/img3.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                    {
                        "itemImageSrc": "/storage/login/img4.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                    {
                        "itemImageSrc": "/storage/login/img5.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                    {
                        "itemImageSrc": "/storage/login/img6.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                    {
                        "itemImageSrc": "/storage/login/img7.jpg",
                        "thumbnailImageSrc": "/storage/login/img2.jpg",
                        "alt": "Descripción de la imagen 2",
                        "title": "Imágen 2"
                    },
                ]
            };
        },
        props: {
            title: String,
            breadcrumbItems: Array,
        },
        methods: {
            theme() {
                return this.darkMode
                    ? "/themes/vela-blue/theme.css"
                    : "/themes/saga-blue/theme.css";
            },
            themeColor() {
                this.darkMode = this.cheked = !this.darkMode;
                let container = document.getElementById("contentMain");
                let themeElement = document.getElementById("theme-link");
                let div = document.getElementById("main-container");
                console.log(div);
                if (this.darkMode) {
                    localStorage.setItem("darkMode", true);
                    document.documentElement.classList.add("dark");
                    container.classList.add("modoOscuro");
                    div.classList.add("dark");
                } else {
                    localStorage.setItem("darkMode", false);
                    document.documentElement.classList.remove("dark");
                    container.classList.remove("modoOscuro");
                    div.classList.remove("dark");
                }
                themeElement.setAttribute("href", this.theme());
            },
        },
        beforeMount() {
            let cargar = async () => {
                let dark = localStorage.getItem("darkMode");
                if (dark === "true") {
                    this.darkMode = this.checked = true;
                } else {
                    this.darkMode = this.checked = false;
                }
                let themeElement = document.getElementById("theme-link");
                await setTimeout(() => {
                    themeElement.setAttribute("href", this.theme());
                }, 200);
            };
            cargar();
        },
    };
    </script>
    
    <style>
    .modoOscuro {
        background-color: #17212f;
        color: rgba(255, 255, 255, 0.87);
    }
    .modoOscuro .card {
        background-color: #17212f;
        color: rgba(255, 255, 255, 0.87);
    }
    .modoOscuro input {
        background-color: #17212f;
        color: rgba(255, 255, 255, 0.87);
    }
    .modoOscuro label {
        color: rgba(255, 255, 255, 0.87);
    }
    .modoOscuro p {
        color: rgba(255, 255, 255, 0.87);
    }
    .modoOscuro strong {
        color: rgba(255, 255, 255, 0.87);
    }
    
    @media (prefers-color-scheme: dark) {
        ::-webkit-scrollbar {
            width: 12px;
        }
    
        ::-webkit-scrollbar-track {
            background: #17212f;
        }
    
        ::-webkit-scrollbar-thumb {
            background-color: #1f2d40;
            border-radius: 20px;
            border: 3px solid #2b3e58;
        }
    }
    </style>
    
    