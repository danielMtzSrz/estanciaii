<script setup>
// Inertia
import { Inertia } from "@inertiajs/inertia";
import { Link } from '@inertiajs/inertia-vue3';
// Componentes de Vue

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
</script>

<template>
    <div class="d-flex">
        <Menubar :model="items" class="container-fluid">
            <template #start>
                <div class="d-flex align-items-center">
                    <!-- <Sidebar :items="items"/> -->
                    <Button icon="pi pi-home" plain text @click="Inertia.visit('/')"/>
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

<script>
export default {
    data() {
        return {
            items: [
                {
                    label: "Sistema",
                    icon: "pi pi-cog",
                    items: [
                        {
                            label: "Usuarios",
                            icon: "pi pi-users",
                            command: () => {
                                Inertia.visit(route("user.index"));
                            },
                        },
                        {
                            label: "Roles",
                            icon: "pi pi-key",
                            command: () => {
                                Inertia.visit(route("role.index"));
                            },
                        },
                        {
                            label: "Permisos",
                            icon: "pi pi-unlock",
                            command: () => {
                                Inertia.visit(route("permission.index"));
                            },
                        },
                        {
                            label: "Empresas asociadas",
                            icon: "pi pi-unlock",
                            command: () => {
                                Inertia.visit(route("empresas.index"));
                            },
                        },
                        {
                            label: "Países",
                            icon: "pi pi-unlock",
                            command: () => Inertia.visit(route("paises.index")),
                        },
                        {
                            label: "Estados",
                            icon: "pi pi-unlock",
                            command: () => Inertia.visit(route("estados.index")),
                        },
                        {
                            label: "Municipios",
                            icon: "pi pi-unlock",
                            command: () => Inertia.visit(route("municipios.index")),
                        },
                        {
                            label: "Tipos de anuncios",
                            icon: "pi pi-unlock",
                            command: () => Inertia.visit(route("tiposanuncios.index")),
                        },
                        {
                            label: "Anuncios",
                            icon: "pi pi-unlock",
                            command: () => Inertia.visit(route("anuncios.index")),
                        },
                    ],
                },
                {
                    label: "Calendarizaciones",
                    icon: "pi pi-calendar",
                    items: [
                        {
                            label: "Periodos",
                            icon: "bi bi-calendar3",
                            command: () => {
                                this.$inertia.visit(
                                    route("Calendarizaciones.Periodos.index")
                                );
                            },
                        },
                        {
                            label: "Tipos de periodos",
                            icon: "bi bi-calendar2-check",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "Calendarizaciones.TiposPeriodo.index"
                                    )
                                );
                            },
                        },
                        {
                            label: "Tipos de convocatorias",
                            icon: "bi bi-pencil-square",
                            command: () => {
                                this.$inertia.visit(
                                    route("Calendarizaciones.TiposConvocatoria.index")
                                );
                            },
                        },
                        {
                            label: "Convocatorias",
                            icon: "bi bi-files-alt",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "Calendarizaciones.Convocatorias.index"
                                    )
                                );
                            },
                        },
                        {
                            label: "Horarios",
                            icon: "bi bi-clock",
                            command: () => {
                                this.$inertia.visit(
                                    route("Calendarizaciones.Horarios.index")
                                );
                            },
                        },
                    ],
                },
                {
                    label: "Estructura Académica",
                    icon: "bi bi-columns-gap",
                    items: [
                        {
                            label: "Aulas",
                            icon: "bi bi-easel2",
                            command: () => {
                                this.$inertia.visit(
                                    route("EstructuraAcademica.Aulas.index")
                                );
                            },
                        },
                        {
                            label: "Aulas Reservación",
                            icon: "bi bi-calendar-check",
                            command: () => {
                                this.$inertia.visit(
                                    route("EstructuraAcademica.AulasReservacion.index")
                                );
                            },
                        },
                        {
                            label: "Grupos",
                            icon: "bi bi-people",
                            command: () => {
                                this.$inertia.visit(
                                    route("EstructuraAcademica.Grupos.index")
                                );
                            },
                        },
                    ],
                },
                {
                    label:"Gestión Académica",
                    icon: "pi pi-briefcase",
                    items:[
                        {
                            label: "Carreras",
                            icon: "bi bi-mortarboard-fill",
                            command: () => {
                                this.$inertia.visit(
                                    route("GestionAcademica.Carreras.index")
                                );
                            },
                        },
                        {
                            label: "Cuatrimestres",
                            icon: "bi bi-collection",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "GestionAcademica.Cuatrimestres.index"
                                    )
                                );
                            },
                        },
                        {
                            label: "Mapas Curriculares",
                            icon: "bi bi-calendar2-range",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "GestionAcademica.MapasCurriculares.index"
                                    )
                                );
                            },
                        },
                        
                        {
                            label: "Materias",
                            icon: "pi pi-book",
                            command: () => {
                                this.$inertia.visit(
                                    route("GestionAcademica.Materias.index")
                                );
                            },
                        },
                        {
                            label: "Planes de estudio",
                            icon: "bi bi-journal-bookmark",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "GestionAcademica.PlanesEstudios.index"
                                    )
                                );
                            },
                        },
                        {
                            label: "Asesorías",
                            icon: "bi bi-journal-bookmark",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "GestionAcademica.Asesorias.index"
                                    )
                                );
                            },
                        },
                        {
                            label: "Asignar materias",
                            icon: "bi bi-journal-bookmark",
                            command: () => {
                                this.$inertia.visit(
                                    route(
                                        "GestionAcademica.GrupoMateria.index"
                                    )
                                );
                            },
                        }
                    ]
                },
                // {
                //     label: "Anuncios",
                //     icon: "pi pi-bell",
                //     command: () => {
                //         Inertia.visit(route("anuncios.index"));
                //     },
                // },
                // {
                //     label: "Vacantes",
                //     icon: "pi pi-inbox",
                //     command: () => {
                //         Inertia.visit(route("vacantes.index"));
                //     },
                // },
            ],
        };
    },
};
</script>
