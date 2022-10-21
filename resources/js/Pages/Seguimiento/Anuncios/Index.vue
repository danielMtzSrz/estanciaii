<template>
    <Head title="Usuarios"></Head>
    <app-layout>
        <h1 class="display-6 text-center my-2">Anuncios</h1>
        <div class="card mb-4">
            <DataTable
                class="p-datatable-sm mt-4 mb-4"
                :value="anuncios"
                :paginator="true"
                :rows="10"
                :resizableColumns="true"
                columnResizeMode="fit | expand"
                :loading="loading"
                responsiveLayout="scroll"
                v-model:filters="filter"
            >
                <!-- Configuración por defecto -->
                <template #empty>
                    <span class="text-red-500"
                        >No se encontraron registros</span
                    >
                </template>
                <template #loading> Cargando... </template>
                <!-- Fin de la configuración por defecto -->
                <template #header>
                    <div class="row">
                        <div class="col-sm-6">
                            <Button
                                type="button"
                                label="Nuevo"
                                icon="pi pi-plus"
                                class="p-button-raised p-button-rounded p-button-success p-button-sm"
                                @click="modalNuevo(true)"
                            />
                        </div>
                        <div class="col-sm-6 flex justify-end my-2">
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="filter['global'].value"
                                    placeholder="Busqueda"
                                />
                            </span>
                            <Button
                                type="button"
                                icon="pi pi-filter-slash"
                                label=""
                                class="p-button-outlined"
                                @click="clearFilter()"
                                v-tooltip.bottom="'Limpiar búsqueda'"
                            />
                        </div>
                    </div>
                </template>
                <Column>
                    <template #body="slotProps">
                        <div v-if="slotProps.data.empresa.imagen">
                            <Avatar
                                class="p-avatar-image p-avatar-circle p-avatar-lg"
                                :image="
                                    '/storage/' +
                                        slotProps?.data?.empresa.imagen ?? ''
                                "
                            />
                        </div>
                        <div v-else>
                            <p class="text-red-400">No tiene imagen</p>
                        </div>
                    </template>
                </Column>
                <Column
                    field="empresa.name"
                    header="Empresa"
                    :sortable="true"
                ></Column>
                <Column field="name" header="Nombre" :sortable="true"></Column>
                <Column field="contenido" header="Contenido">
                    <template #body="slotProps">
                        Contenido
                    </template>
                </Column>
                <Column header="Imagen">
                    <template #body="slotProps">
                        <div v-if="slotProps.data.imagen">
                            <Avatar
                                class="p-avatar-image p-avatar-circle p-avatar-lg"
                                :image="
                                    '/storage/' + slotProps?.data?.imagen ?? ''
                                "
                            />
                        </div>
                        <div v-else>
                            <p class="text-red-400">No tiene imagen</p>
                        </div>
                    </template>
                </Column>
                <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                    <template #body="slotProps">
                        <!-- <Button
                        v-permission="'permission.update'" -->
                        <Button
                            type="button"
                            icon="pi pi-pencil"
                            class="p-button-warning p-button-text p-button-raised p-button-rounded"
                            @click="modalActualizar(slotProps.data, true)"
                        />
                        <Button
                            type="button"
                            icon="pi pi-trash"
                            class="p-button-danger p-button-text p-button-raised p-button-rounded"
                            @click="modalEliminar(slotProps.data, true)"
                        />
                    </template>
                </Column>
                <template #footer>
                    <div>
                        Total de registros: {{ anuncios ? anuncios.length : 0 }}
                    </div>
                </template>
            </DataTable>
        </div>

        <!-- Modal crear -->
        <modal-crear
            :dataModal="{ display: displayCrear, dataEmpresas: empresas }"
            v-on:visible="(visible) => modalNuevo(visible)"
        ></modal-crear>
        <!-- Fin modal crear -->

        <!-- Modal actualizar -->
        <modal-actualizar
            v-if="displayActualizar"
            :dataModal="{
                display: displayActualizar,
                dataRegistro: permisoData,
                dataEmpresas: empresas,
            }"
            v-on:visible="(visible) => modalActualizar(visible)"
        ></modal-actualizar>
        <!-- Fin modal actualizar -->

        <!-- Modal eliminar -->
        <modal-borrar
            :dataModal="{ display: displayEliminar, dataRegistro: permisoData }"
            v-on:visible="(visible) => modalEliminar(visible)"
        ></modal-borrar>
        <!-- Fin modal eliminar -->
    </app-layout>
</template>

<script>
// Layout padre
import AppLayout from "@/Layouts/AppLayout.vue";

// Inertia
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

// Primevue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import Tooltip from "primevue/tooltip";
import Avatar from "primevue/avatar";

// Componentes para los modales de los CRUD
import ModalCrear from "@/Pages/Seguimiento/Anuncios/Create.vue";
import ModalActualizar from "@/Pages/Seguimiento/Anuncios/Update.vue";
import ModalBorrar from "@/Pages/Seguimiento/Anuncios/Delete.vue";

export default {
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading: null,
            displayCrear: null,
            displayActualizar: null,
            displayEliminar: null,
            permisoData: null,
            filter: null,
            imagen: null,
        };
    },
    components: {
        AppLayout,
        Head,
        Link,
        DataTable,
        Column,
        Button,
        InputText,
        Avatar,
        ModalCrear,
        ModalActualizar,
        ModalBorrar,
    },
    props: {
        title: String,
        anuncios: Object,
        empresas: Object,
    },
    created() {
        this.initFilter();
    },
    updated() {},
    mounted() {
        this.loading = true;
        setTimeout((this.loading = false), 2000);
    },
    methods: {
        // Cargar modales
        modalNuevo(show) {
            return (this.displayCrear = show);
        },
        modalActualizar(data, show) {
            this.permisoData = data;
            return (this.displayActualizar = show);
        },
        modalEliminar(data, show) {
            this.permisoData = data;
            return (this.displayEliminar = show);
        },
        // Filtros del dataTable
        clearFilter() {
            this.initFilter();
        },
        initFilter() {
            this.filter = {
                global: {
                    value: null,
                    matchMode: FilterMatchMode.CONTAINS,
                },
            };
        },
    },
};
</script>
