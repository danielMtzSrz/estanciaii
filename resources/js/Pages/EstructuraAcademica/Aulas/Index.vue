<template>
    <GenericLayout titleModule="Aulas">
        <template #content>
            <DynamicTable
                :data="aulas"
                :items="items"
                titleModule="Aulas"
            >
                <template #header>
                    <Button
                        v-if="hasPermission('EstructuraAcademica.Aulas.store')"
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                        @click="modalCreateUpdate({display: true})"
                    />
                </template>

                <template #buttons="{ data }">
                    <Button
                        v-if="hasPermission('EstructuraAcademica.Aulas.update')"
                        type="button"
                        icon="pi pi-pencil"
                        class="p-button-warning p-button-text p-button-raised p-button-rounded"
                        v-tooltip.top="'Actualizar'"
                        @click="modalCreateUpdate({display: true, data: data})"
                    />
                    <Button
                        v-if="hasPermission('EstructuraAcademica.Aulas.destroy')"
                        type="button"
                        icon="pi pi-trash"
                        class="p-button-danger p-button-text p-button-raised p-button-rounded"
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'EstructuraAcademica.Aulas.destroy',
                            }
                        })"
                    />
                    <Button
                        type="button"
                        icon="bi bi-file-earmark-excel"
                        class="p-button-success p-button-text p-button-raised p-button-rounded"
                        @click="modalGenerarExcel({display: true, data: data})"
                    />
                </template>
            </DynamicTable>
        </template>

        <template #footer>
            <CreateUpdate
                :dataModal="{
                    display: displayCreateUpdate,
                    dataRegistro: dataRegistro,
                    dataEdificios: edificios,
                    dataTiposAula: tipos_aula
                }"
                @closeModal="modalCreateUpdate({display: false, data: null})"
            />
            <GenericAlert
                :dataModal="{
                    display: displayGenericAlert,
                    dataRegistro : dataRegistro,
                    dataProceso : dataProceso
                }"
                @closeModal="modalGenericAlert({display: false, data: null, dataProceso: null})"
            />
            <GenerarExcel
                :dataModal="{
                    display: displayGenerarExcel,
                    dataRegistro: dataRegistro,
                }"
                @closeModal="modalGenerarExcel({display: false, data: null})"
            />
            
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
import CreateUpdate from "@/Pages/EstructuraAcademica/Aulas/CreateUpdate.vue";
import GenerarExcel from "@/Pages/EstructuraAcademica/Aulas/GenerarExcel.vue";

// Variables para los modales
const displayCreateUpdate = ref(false), displayGenerarExcel = ref(false), displayGenericAlert = ref(false);
const dataRegistro = ref(null), dataProceso = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
    displayCreateUpdate.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenerarExcel = (event) => {
    displayGenerarExcel.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    displayGenericAlert.value = event.display;
    dataProceso.value = event.proceso;
}

// Propiedades
const props = defineProps({
    aulas: {
        type: Object,
        default: null
    },
    tipos_aula: {
        type: Object,
        default: null
    },
    edificios: {
        type: Object,
        default: null
    }
})

// Array-Object para los items del DataTable
const items = ref([
    {
        dataField: {
            field: 'edificio_nombre',
            header : 'Edificio',
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
            field: 'tipo_aula_nombre',
            header : 'Tipo de aula',
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
            field: 'nombre',
            header : 'Aula',
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
            field: 'capacidad',
            header : 'Capacidad',
            sortable: false,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'numeric',
        },
    },
    {
        dataField: {
            field: 'estatus_label',
            header : 'Estatus',
            sortable: false,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'text',
        },
    },
])
</script>