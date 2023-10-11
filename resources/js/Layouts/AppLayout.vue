<template>
    <div>
        <Toast position="bottom-right"/>
        <Head :title="title" />

        <div
            class="min-h-screen dark:modoOscur"
            :class="{ modoOscuro: darkMode, 'bg-gray-300' : !darkMode }"
            id="contentMain"
        >
            <Header 
                :darkMode="darkMode"
                @themeColor="themeColor"
                :title="title"
            />

            <!-- Page Content -->
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
// Vue
import { computed, watch, ref } from "vue";

// Inertia
import { Head, usePage } from "@inertiajs/inertia-vue3";

// Components
import Header from "@/Components/Header.vue";

// Primevue
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import Breadcrumb from 'primevue/breadcrumb';

const toast = useToast();
const toastData = computed(() => usePage().props.value.flash);
const darkMode = ref(true);

const theme = computed(() => (darkMode.value ? "/themes/bootstrap4-dark-blue/theme.css" : "/themes/bootstrap4-light-blue/theme.css"));

const home = ref({
    icon: 'pi pi-home',
    to: '/',
});

const items = ref([
    {label: 'Computer'},
    {label: 'Notebook'},
    {label: 'Accessories'},
    {label: 'Backpacks'},
    {label: 'Item'}
]);

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

watch(toastData, (newData) => {
    if (Object.values(newData).includes(null)) {
        return;
    }

    toast.add({
        severity: newData.severity,
        summary: newData.summary,
        detail: newData.detail,
        life: newData.life,
    });
});

const props = defineProps({
    title: {
        type: String,
        default: null
    }
})
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

  

    ::-webkit-scrollbar-thumb {
        background-color: #565c6323;
        border-radius: 20px;
        border: 3px solid #454e5ab6;
    }
}
</style>
