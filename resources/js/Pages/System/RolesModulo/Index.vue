<template>
    <Head title="Usuarios"></Head>
    <app-layout>
        <h1 class="display-6 text-center my-2">Roles</h1>
        <div class="card mb-4">
            <DataTable
                class="p-datatable-sm mt-4 mb-4"
                :value="roles"
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
                            <Link :href="route('role.create')">
                                <Button
                                    type="button"
                                    label="Nuevo"
                                    icon="pi pi-plus"
                                    class="p-button-raised p-button-rounded p-button-success p-button-sm"
                                />
                            </Link>
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
                <Column field="id" header="ID" :sortable="true"></Column>
                <Column field="name" header="Nombre" :sortable="true"></Column>
                <Column header="Permisos">
                    <template #body="slotProps">
                        <Button 
                                type="button" 
                                class="p-button-text p-button-raised p-button-rounded"
                                icon="pi pi-eye" label="Mostrar"
                                @click="toggle"
                                v-on:click="asignarData(slotProps.data.id)"
                                aria:haspopup="true"
                                :aria-controls="'overlay_panel_'+slotProps.data.id"
                                :dataRolesOverlay="slotProps.data" />
                        <OverlayPanel ref="op" appendTo="body" :showCloseIcon="true" :id="'overlay_panel_'+slotProps.data.id" style="width: 450px" :breakpoints="{'960px': '75vw'}">
                            
                            <ol v-for="permiso in permisos" :key="permiso">
                                <div v-for="permisoAsignado in dataPermisosAsignados" :key="permisoAsignado">
                                    <li v-if="permisoAsignado == permiso.id">{{ permiso.description }}</li>
                                </div>
                            </ol>
                            <p v-if="dataPermisosAsignados == 0" class="text-red-400">El rol no tiene permisos asignados</p>
                        </OverlayPanel>
                    </template>
                </Column>
                <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                    <template #body="slotProps">
                        <Link :href="route('role.edit', slotProps.data)">
                            <Button
                                type="button"
                                icon="pi pi-pencil"
                                class="p-button-warning p-button-text p-button-raised p-button-rounded"
                            />
                        </Link>
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
                        Total de registros: {{ roles ? roles.length : 0 }}
                    </div>
                </template>
            </DataTable>
        </div>

        <!-- Modal eliminar -->
        <modal-borrar
            :dataModal="{ display: displayEliminar, dataRol : usuarioData }"
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
import OverlayPanel from 'primevue/overlaypanel';

// Componentes para los modales de los CRUD
import ModalCrear from "@/Pages/System/Usuario/Create.vue";
import ModalActualizar from "@/Pages/System/Usuario/Update.vue";
import ModalBorrar from "@/Pages/System/RolesModulo/Delete.vue";

export default {
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading : null,
            displayEliminar : null,
            usuarioData : null,
            filter : null,
            dataRolesOverlay : null,
            dataPermisosAsignados: null,
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
        OverlayPanel,
        ModalBorrar,
    },
    props: {
        title: String,
        roles: Object,
        permisos: Object,
        role_has_permission: Object,
    },
    created() {
        this.initFilter();
    },
    updated(){
        this.displayActualizar = false;
    },
    mounted() {
        this.loading = true;
        setTimeout((this.loading = false), 2000);
    },
    methods: {
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
        asignarData(id){
            let role_has_permission = this.role_has_permission
            let permisosAsinadosRol = role_has_permission.map(function(el) {
                if(el.role_id == id){
                    return el.permission_id;
                }
            });
            this.dataPermisosAsignados = permisosAsinadosRol.filter((el) => el != undefined);
        },
        toggle(event) {
            this.$refs.op.toggle(event);
        }
    },
};
</script>
