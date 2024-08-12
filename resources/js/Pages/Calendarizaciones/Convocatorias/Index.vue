<template>
    <GenericLayout titleModule="Convocatorias">
        <template #content>
            <DynamicTable
                :data="convocatorias"
                :items="items"
                titleModule="Convocatorias"
            >
                <template #header>
                    <Button
                        v-if="hasPermission('Calendarizaciones.Convocatorias.store')"
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                        @click="modalCreateUpdate({display: true})"
                    />
                </template>

                <template #buttons="{ data }">
                    <Button
                        v-if="hasPermission('Calendarizaciones.Convocatorias.update')"
                        type="button"
                        icon="pi pi-pencil"
                        class="p-button-warning p-button-text p-button-raised p-button-rounded"
                        v-tooltip.top="'Actualizar'"
                        @click="modalCreateUpdate({display: true, data: data})"
                    />
                    <Button
                        v-if="hasPermission('Calendarizaciones.Convocatorias.destroy')"
                        type="button"
                        icon="pi pi-trash"
                        class="p-button-danger p-button-text p-button-raised p-button-rounded"
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'Calendarizaciones.Convocatorias.destroy',
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
                    dataRegistro: dataRegistro
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
import CreateUpdate from "@/Pages/Calendarizaciones/Convocatorias/CreateUpdate.vue";

// Variables para los modales
const displayCreateUpdate = ref(false), displayGenericAlert = ref(false);
const dataRegistro = ref(null), dataProceso = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
    displayCreateUpdate.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    displayGenericAlert.value = event.display;
    dataProceso.value = event.proceso;
}

// Propiedades
const props = defineProps({
    convocatorias: {
        type: Object,
        default: null
    }
})

// Array-Object para los items del DataTable
const items = ref([
    {
        dataField: {
            field: 'periodo_nombre',
            header : 'Periodo',
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
            field: 'tipo_convocatoria_nombre',
            header : 'Tipo de convocatoria',
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
            field: 'contenido',
            header : 'Contenido',
            sortable: false,
            type: 'html',
        },
        filters: {
            active: false,
            type: 'text',
        },
    }
])
</script>