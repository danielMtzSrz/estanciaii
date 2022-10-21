<template>
    <Head title="Usuarios"></Head>
    <app-layout>
        <h1 class="display-6 text-center my-2">Módulo de usuarios</h1>
        <div class="card mb-4">
            <DataTable
                class="p-datatable-sm mt-4 mb-4"
                :value="userData"
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
                        <div class="d-flex align-items-center">
                            <div v-if="slotProps.data.profile_photo_path">
                                <Avatar
                                    class="p-avatar-image p-avatar-circle p-avatar-lg"
                                    :image="
                                        '/storage/' + slotProps?.data?.profile_photo_path ?? ''
                                    "
                                />
                            </div>
                            <div v-else>
                                <p class="text-red-400">Sin imagen</p>
                            </div>
                        </div>
                    </template>
                </Column>
                <Column field="name" header="Nombre" :sortable="true"></Column>
                <Column field="email" header="Correo" :sortable="true"></Column>
                <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                    <template #body="slotProps">
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
                        Total de registros: {{ userData ? userData.length : 0 }}
                    </div>
                </template>
            </DataTable>
        </div>

        <!-- Modal crear -->
        <modal-crear
            :dataModal="{
                display: displayCrear,
                roles: roles,
                rolesAsignados: rolesAsignados,
            }"
            v-on:visible="(visible) => modalNuevo(visible)"
        ></modal-crear>
        <!-- Fin modal crear -->

        <!-- Modal actualizar -->
        <modal-actualizar
            :dataModal="{
                display: displayActualizar,
                dataUsuario: usuarioData,
                roles: roles,
                rolesAsignados: rolesAsignados,
            }"
            v-on:visible="(visible) => modalActualizar(visible)"
            v-if="displayActualizar"
        ></modal-actualizar>
        <!-- Fin modal actualizar -->

        <!-- Modal eliminar -->
        <modal-borrar
            :dataModal="{ display: displayEliminar, dataUsuario: usuarioData }"
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
import ModalCrear from "@/Pages/System/Usuario/Create.vue";
import ModalActualizar from "@/Pages/System/Usuario/Update.vue";
import ModalBorrar from "@/Pages/System/Usuario/Delete.vue";

export default {
    setup() {
        const prueba2 = computed(() => usePage().props.value.prueba);
        return { prueba2 };
    },
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading: null,
            displayCrear: null,
            displayActualizar: null,
            displayEliminar: null,
            usuarioData: null,
            filter: null,
            rolesAsignados: [],
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
        userData: Object,
        roles: Object,
        model_has_roles: Object,
    },
    created() {
        this.initFilter();
    },
    updated() {
        this.displayActualizar = false;
    },
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
            const role_id = this.model_has_roles.map((element) => {
                if (element.model_id == data.id) {
                    return element.role_id;
                }
            });
            this.rolesAsignados = role_id.filter((el) => el != null);
            this.usuarioData = data;

            return (this.displayActualizar = show);
        },
        modalEliminar(data, show) {
            this.usuarioData = data;
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
