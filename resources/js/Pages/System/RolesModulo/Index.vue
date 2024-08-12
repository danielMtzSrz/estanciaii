<template>
    <GenericLayout titleModule="Roles">
        <template #content>
            <DynamicTable
                :data="roles"
                :items="items"
                titleModule="Roles"
            >
                <template #header>
                    <Button
                        v-if="hasPermission('role.store')"
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                        @click="modalCreateUpdate({display: true})"
                    />
                    
                </template>

                <template #columns>
                    <Column header="Permisos" headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="{ data }">
                            <Button
                                icon="pi pi-external-link" 
                                label="Ver permisos"
                                class="p-button-raised p-button-rounded p-button-text p-button-sm p-button-info"
                                @click="verPermisos({data: data.permisos, display: true})"
                            />
                        </template>
                    </Column>
                </template>

                <template #buttons="{ data }">
                    <Button
                        v-if="hasPermission('role.update')"
                        type="button"
                        icon="pi pi-pencil"
                        class="p-button-warning p-button-text p-button-raised p-button-rounded"
                        v-tooltip.top="'Actualizar'"
                        @click="modalCreateUpdate({display: true, data: data})"
                    />

                    <Button
                        v-if="hasPermission('role.destroy')"
                        type="button"
                        icon="pi pi-trash"
                        class="p-button-danger p-button-text p-button-raised p-button-rounded"
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'role.destroy',
                            }
                        })"
                    />
                </template>
            </DynamicTable>

        </template>

        <template #footer>
           <CreateUpdate
                :dataModal="{
                    display: displayCreateUpdate,
                    dataRegistro: dataRegistro,
                    data_permisos: data_permisos
                }"
                @closeModal="modalCreateUpdate({display: false, data: null})"
            />
            
            <GenericAlert
                :dataModal="{
                    display: display_generic_alert,
                    dataRegistro : dataRegistro,
                    dataProceso : dataProceso
                }"
                @closeModal="modalGenericAlert({display: false, data: null, dataProceso: null})"
            />

            <Dialog 
                header="Permisos" 
                v-model:visible="display_ver_permisos"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" 
                :style="{width: '75vw'}"
                :modal="true"
            >
                <DataView :value="data_ver_permisos" layout="grid" :paginator="true" :rows="24" :rowsPerPageOptions="[8, 12, 20, 24, 40]">
                    <template #grid="slotProps">
                        <div class="col-12 md:col-3">
                            <div class="field-checkbox d-flex mb-5 mx-3">
                                <li>{{ slotProps.data.description}}</li>
                            </div>
                        </div>
                    </template>
                </DataView>
            </Dialog>
        </template>
    </GenericLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue';

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/System/RolesModulo/CreateUpdate.vue";

// Primevue
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import DataView from 'primevue/dataview';

// Variables para guardar la respuesta de Axios
const data = ref(null)

// Variables para los modales
const displayCreateUpdate = ref(false), display_generic_alert = ref(false), display_ver_permisos = ref(false);
const dataRegistro = ref(null), dataProceso = ref(null), data_ver_permisos = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
    displayCreateUpdate.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    display_generic_alert.value = event.display;
    dataProceso.value = event.proceso;
}

const verPermisos = (event) => {
    display_ver_permisos.value = event.display
    data_ver_permisos.value = event.data
}

// Propiedades
const props = defineProps({
    dataPage: {
        type: Object,
        default: null
    },
    data_permisos: {
        type: Object,
        default: null
    },
    roles: {
        type: Object,
        default: null
    }
})

// Array-Object para los items del DataTable
const items = ref([
    {
        dataField: {
            field: 'id',
            header : 'ID',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'numeric',
            minFractionDigits: 0,
            maxFractionDigits: 0,
        },
    },
    {
        dataField: {
            field: 'name',
            header : 'Nombre',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'text',
        },
    },
    {
        dataField: {
            field: 'guard_name',
            header : 'guard',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'text',
        },
    },
])

</script>