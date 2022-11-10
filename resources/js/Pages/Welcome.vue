<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

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
import Avatar from 'primevue/avatar';
import Carousel from 'primevue/carousel';
import Card from 'primevue/card';
import Divider from 'primevue/divider';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    empresas: {
        type: Object,
        default: null
    },
    anuncios: {
        type: Object,
        default: null
    },
    vacantes: {
        type: Object,
        default: null
    }
});

console.log(props.vacantes)

</script>

<template>
    <Head :title="title" />
        <div
            class="dark:modoOscuro h-auto"
            :class="{ modoOscuro: darkMode, 'surface-hover' : !darkMode }"
            id="contentMain"
        >
        <Menubar class="container-fluid">
            <template #start>
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
            <div class="row col-sm-12 mx-0">
                <Carousel
                    :value="images"
                    :numVisible="1"
                    :numScroll="1"
                    class="custom-carousel px-0"
                    :circular="true"
                    :autoplayInterval="15000"
                    :showNavigators="false"
                >
                    <template #item="slotProps">
                            <div class="overflow-hidden">
                                <div
                                    class="bg-cover bg-center w-full flex justify-content-end flex-wrap flex-column"
                                    :style="{'background-image': 'url('+slotProps.data.itemImageSrc+')'}"
                                    style="height: 85vh"
                                >
                                    <h1 class="align-items-center text-white" style="background: rgba(0, 0, 0, 0.5)">{{ slotProps.data.title }}</h1>
                                    <h2 class="align-items-center text-white" style="background: rgba(0, 0, 0, 0.5)">{{ slotProps.data.alt }}</h2>
                                </div>
                            </div>
                    </template>
                </Carousel>
            </div>
            <div class="col-sm-12 my-4" v-if="anuncios.length">
                <Divider class="pt-6"></Divider>
                <h3 class="display-6 text-center">Anuncios</h3>
                <Card class="m-auto mt-4 col-sm-11" style="box-shadow: 7px 7px #83838312">
                    <template #content>
                        <Carousel :value="anuncios" :numVisible="1" :numScroll="1" class="custom-carousel" :circular="true" :autoplayInterval="15000">
                            <template #item="slotProps">
                                <div class="product-item m-auto p-auto">
                                    <div class="product-item-content">
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-4 my-auto mb-3">
                                                <div class="flex align-items-center mb-2 col-sm-12">
                                                    <div class="col-sm-2">
                                                        <Avatar
                                                            class="p-avatar-lg p-avatar-circle"
                                                            :image="`/storage/${slotProps.data.empresa.imagen}`"
                                                        />
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <p class="text-2xl font-semibold">{{ slotProps.data.empresa.name }}</p>
                                                    </div>
                                                </div>
                                                <img
                                                    class="my-auto"
                                                    :src="`/storage/${slotProps.data.imagen}`"
                                                    :alt="slotProps.data.name"
                                                />
                                                <h5 class="mb-1 text-center">{{slotProps.data.name}}</h5>
                                            </div>
                                            <div class="col-sm-8 overflow-auto my-auto px-4" style="max-height: 400px;">
                                                <div v-html="slotProps.data.contenido">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Carousel>
                    </template>
                </Card>
            </div>
            <div class="col-sm-12 mt-4" v-if="vacantes.length">
                <Divider class="pt-6"></Divider>
                <h3 class="display-6 text-center">Vacantes</h3>
                <Card class="m-auto mt-4 col-sm-11" style="box-shadow: 7px 7px #83838312">
                    <template #content>
                        <Carousel :value="vacantes" :numVisible="1" :numScroll="1" class="custom-carousel" :circular="true" :autoplayInterval="15000">
                            <template #item="slotProps">
                                <div class="product-item m-auto p-auto">
                                    <div class="product-item-content">
                                        <div class="col-sm-12 row">
                                            <div class="col-sm-4 my-auto mb-3">
                                                <div class="flex align-items-center mb-2 col-sm-12">
                                                    <div class="col-sm-2">
                                                        <Avatar
                                                            class="p-avatar-lg p-avatar-circle"
                                                            :image="`/storage/${slotProps.data.empresa.imagen}`"
                                                        />
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <p class="text-2xl font-semibold ms-2">{{ slotProps.data.empresa.name }}</p>
                                                    </div>
                                                </div>
                                                <img
                                                    class="my-auto"
                                                    :src="`/storage/${slotProps.data.imagen}`"
                                                    :alt="slotProps.data.name"
                                                />
                                                <p class="text-lg mb-1 text-center">{{slotProps.data.name}}</p>
                                            </div>
                                            <div class="col-sm-8 overflow-auto my-auto px-4" style="max-height: 400px;">
                                                <div v-html="slotProps.data.contenido">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Carousel>
                    </template>
                </Card>
            </div>
            <div class="col-sm-12 mt-4" v-if="empresas.length">
                <Divider class="pt-6"></Divider>
                <h3 class="display-6 text-center">Empresas</h3>
                <Card class="m-auto mt-4 col-sm-10" style="box-shadow: 7px 7px #83838312">
                    <template #content>
                        <Carousel :value="empresas" :numVisible="3" :responsiveOptions="responsiveOptions" :numScroll="1" class="custom-carousel" :circular="true" :autoplayInterval="10000">
                            <template #item="slotProps">
                                <div class="product-item m-auto p-auto">
                                    <div class="product-item-content ms-4">
                                        <div class="mb-3">
                                            <img
                                                class="m-auto"
                                                :src="`/storage/${slotProps.data.imagen}`"
                                                :alt="slotProps.data.name"
                                                width="200"
                                            />
                                        </div>
                                        <div class="text-center">
                                            <p class="text-2xl font-semibold mb-1">{{slotProps.data.name}}</p>
                                            <p class="text-lg mb-1">{{slotProps.data.razon_social}}</p>
                                            <p class="text-base mb-1">{{ slotProps.data.ubicacion_empresa }}</p>
                                            <p class="text-base mb-1">Calle: {{ slotProps.data.calle }} | Número exterior: {{ slotProps.data.num_ext }} <span v-if="slotProps.data.num_int">| Número Interior: {{ slotProps.data.num_int }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </Carousel>
                    </template>
                </Card>
            </div>
            <div class="col-sm-12 mt-4">&nbsp;</div>
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
            responsiveOptions: [
                {
                    breakpoint: '1024px',
                    numVisible: 3,
                    numScroll: 3
                },
                {
                    breakpoint: '700px',
                    numVisible: 2,
                    numScroll: 2
                },
                {
                    breakpoint: '480px',
                    numVisible: 1,
                    numScroll: 1
                }
            ],
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
                ? "/themes/bootstrap4-dark-blue/theme.css"
                : "/themes/bootstrap4-light-blue/theme.css";
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

