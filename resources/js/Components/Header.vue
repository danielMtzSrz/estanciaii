<template>
    <div class="d-flex">
        <Menubar :model="items" class="container-fluid">
            <template #start>
                <div class="d-flex align-items-center">
                    <!-- <Sidebar :items="items"/> -->
                    <Button icon="pi pi-home" class="p-button-text p-button-plain" @click="Inertia.visit('/')"/>
                    <span class="mx-2 my-0 py-0 text-2xl font-light" style="font-family: Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;">{{ title ?? "Bienvenido" }}</span>
                </div>
            </template>
            <template #end>
                <div class="d-flex align-items-center">
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
                        @click="emits('themeColor')"
                    />
                    <user-menu></user-menu>
                </div>
            </template>
        </Menubar>
    </div>
</template>

<script setup>
// Vue
import { ref } from "vue";

// Inertia
import { Inertia } from "@inertiajs/inertia";
import { usePage } from '@inertiajs/inertia-vue3';

// Componentes de primevue
import Button from "primevue/button";
import Menubar from "primevue/menubar";
import UserMenu from "@/Components/UserMenu.vue";

// Layouts
import Sidebar from "@/Layouts/Sidebar.vue";

const props = defineProps({
    title: String,
    darkMode: {
        type: Boolean,
        default: null,
    },
    titleModule: String
});

const emits = defineEmits(["themeColor"]);

const logout = () => {
    Inertia.post(route("logout"));
};

const { auth } = usePage().props.value;

const superAdmin = ref('Superadmin')

const itemsRoutes = ref([
    {
        label: "Sistema",
        icon: "pi pi-cog",
        items: [
            {
                label: "Usuarios",
                icon: "pi pi-users",
                route: 'user.index'
            },
            {
                label: "Roles",
                icon: "bi bi-person-bounding-box",
                route: 'role.index'
            },
            {
                label: "Permisos",
                icon: "bi bi-person-lines-fill",
                route: 'permission.index'
            },
            {
                label: "Países",
                icon: "bi bi-globe",
                route: 'paises.index'
            },
            {
                label: "Estados",
                icon: "pi pi-map",
                route: 'estados.index'
            },
            {
                label: "Municipios",
                icon: "bi bi-geo-fill",
                route: 'municipios.index'
            }
        ]
    },
    {
        label: "Calendarizaciones",
        icon: "pi pi-calendar",
        items: [
            {
                label: "Periodos",
                icon: "bi bi-calendar3",
                route: 'Calendarizaciones.Periodos.index'
            },
            {
                label: "Tipos de periodos",
                icon: "bi bi-calendar2-check",
                route: 'Calendarizaciones.TiposPeriodo.index'
            },
            {
                label: "Tipos de convocatorias",
                icon: "bi bi-pencil-square",
                route: 'Calendarizaciones.TiposConvocatoria.index'
            },
            {
                label: "Convocatorias",
                icon: "bi bi-files-alt",
                route: 'Calendarizaciones.Convocatorias.index'
            }
        ]
    },
    {
        label: "Estructura Académica",
        icon: "bi bi-columns-gap",
        items: [
            {
                label: "Aulas",
                icon: "bi bi-easel2",
                route: 'EstructuraAcademica.Aulas.index'
            },
            {
                label: "Aulas Reservación",
                icon: "bi bi-calendar-check",
                route: 'EstructuraAcademica.AulasReservacion.index'
            },
            {
                label: "Grupos",
                icon: "bi bi-people",
                route: 'EstructuraAcademica.Grupos.index'
            }
        ]
    },
    {
        label: "Gestión Académica",
        icon: "pi pi-briefcase",
        items: [
            {
                label: "Carreras",
                icon: "bi bi-mortarboard-fill",
                route: 'GestionAcademica.Carreras.index'
            },
            {
                label: "Mapas Curriculares",
                icon: "bi bi-calendar2-range",
                route: 'GestionAcademica.MapasCurriculares.index'
            },
            {
                label: "Materias",
                icon: "pi pi-book",
                route: 'GestionAcademica.Materias.index'
            },
            {
                label: "Planes de estudio",
                icon: "bi bi-journal-bookmark",
                route: 'GestionAcademica.PlanesEstudios.index'
            },
            {
                label: "Asesorías",
                icon: "bi bi-person-video3",
                route: 'GestionAcademica.Asesorias.index'
            },
            {
                label: "Asignar materias",
                icon: "bi bi-window-plus",
                route: 'GestionAcademica.GrupoMateria.index'
            }
        ]
    }
]);

const items = ref(
    itemsRoutes.value.map(group => ({
        label: group.label,
        icon: group.icon,
        visible: auth.permissions.some(permiso => group.items.some(item => item.route === permiso)) || auth.roles.includes(superAdmin.value),
        items: group.items.map(item => ({
            label: item.label,
            icon: item.icon,
            command: () => Inertia.visit(route(item.route)),
            visible: auth.permissions.includes(item.route) || auth.roles.includes(superAdmin.value)
        }))
    }))
);
</script>