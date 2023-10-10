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

<script setup>
// Vue
import { ref, computed, watch } from "vue";

// Inertia
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';

// Primevue
import Menubar from "primevue/menubar";
import Button from "primevue/button";

defineProps({
    title: String,
});

const darkMode = ref(true);
const home = {
    icon: "pi pi-home",
    url: route("dashboard"),
};
const items = usePage().props.value.breadcrumbItems;

const theme = computed(() => (darkMode.value ? "/themes/bootstrap4-dark-blue/theme.css" : "/themes/bootstrap4-light-blue/theme.css"));

const themeColor = () => {
    darkMode.value = !darkMode.value;
    const container = document.getElementById("contentMain");
    const themeElement = document.getElementById("theme-link");
    const div = document.getElementById("main-container");

    if (darkMode.value) {
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

    themeElement.setAttribute("href", theme.value);
};

const cargar = async () => {
    const dark = localStorage.getItem("darkMode");
    darkMode.value = dark === "true";
    const themeElement = document.getElementById("theme-link");
    await setTimeout(() => {
        themeElement.setAttribute("href", theme.value);
    }, 200);
};

cargar();
</script>

<style>
.modoOscuro {
    background-color: #20262e;
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro .card {
    background-color: #20262e;
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro input {
    background-color: #20262e;
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
        background: #20262e;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #1f2d40;
        border-radius: 20px;
        border: 3px solid #2b3e58;
    }
}
</style>


