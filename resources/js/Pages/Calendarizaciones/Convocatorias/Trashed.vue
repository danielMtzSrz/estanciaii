<template>
    <GenericLayout titleModule="Convocatorias eliminadas">
        <template #content>
            <GenericTable :data="convocatorias">
                <template #headerContent>
                    <Link :href="route('Calendarizaciones.Convocatorias.index')">
                        <Button
                            type="button"
                            label="Regresar"
                            icon="bi bi-arrow-return-left"
                            class="p-button-raised p-button-rounded p-button-text p-button-warning p-button-sm"
                        />
                    </Link>
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" :sortable="col.sortable"></Column>
                    <Column header="Fecha de eliminación">
                        <template #body="slotProps">
                            {{ moment(slotProps.data.deleted_at).format("DD-MM-YYYY") }}
                        </template>
                    </Column>
                    <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="slotProps">
                            <!-- <Button
                            v-permission="'permission.update'" -->
                            <Button
                                type="button"
                                icon="bi bi-arrow-counterclockwise"
                                class="p-button-success p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Restaurar'"
                                @click="modalGenericAlert(slotProps.data, true, 
                                    {
                                    'proceso': 'restore',
                                    'ruta': 'Calendarizaciones.Convocatorias.restore',
                                    'registro': `${slotProps.data.contenido}`
                                    }
                                )"
                            />
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Eliminar definitivamente'"
                                @click="modalGenericAlert(slotProps.data, true, 
                                    {
                                    'proceso': 'forceDelete',
                                    'ruta': 'Calendarizaciones.Convocatorias.forceDelete',
                                    'registro': `${slotProps.data.contenido}`
                                    }
                                )"
                            />
                        </template>
                    </Column>
                </template>
            </GenericTable>
        </template>

        <template #footer>
            <!-- Modal eliminar -->
            <GenericAlert
                :dataModal="{
                    display: displayAlert,
                    dataRegistro : dataRegistro,
                    dataProceso : dataProceso
                }"
                v-on:visible="(visible) => modalGenericAlert(null, visible, null)"
            />
        </template>
    </GenericLayout>
</template>

<script setup>
import {ref, onMounted} from 'vue';

// Componentes de primevue
import Column from 'primevue/column';
import Button from "primevue/button";
import InputText from "primevue/inputtext";

// Componentes personalizados
import GenericLayout from '@/Layouts/GenericLayout.vue';
import GenericTable from '@/Components/GenericTable.vue';
import GenericAlert from '@/Components/GenericAlert.vue';

import moment from 'moment'

// Variables
const displayAlert = ref(null)
const dataProceso = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)

// Propiedades
const props = defineProps({
    convocatorias: {
        type: Object,
        default: null
    },
})

// Métodos
const modalGenericAlert = (data, show, dataProcess) => {
    dataRegistro.value = data
    displayAlert.value = show
    dataProceso.value = dataProcess
}

onMounted(() => {
    columns.value = [
        {field: 'id', header: 'ID', sortable: true},
        {field: 'tipoConvocatoria.nombre', header: 'Tipo de convocatoria', sortable: true},
        {field: 'periodo.titulo', header: 'Periodo', sortable: true},
        {field: 'servicio.concepto', header: 'Servicio', sortable: true},
        {field: 'contenido', header: 'Contenido', sortable: true},
    ];
})
</script>