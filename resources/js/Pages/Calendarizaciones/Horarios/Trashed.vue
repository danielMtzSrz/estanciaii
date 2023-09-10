<template>
    <GenericLayout titleModule="Horarios eliminados">
        <template #content>
            <GenericTable :data="horarios">
                <template #headerContent>
                    <Link :href="route('Calendarizaciones.Horarios.index')">
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
                                    'ruta': 'Calendarizaciones.Horarios.restore',
                                    'registro': `del aula ${slotProps.data.aula.nombre} el día ${slotProps.data.diaSemana.nombre} con horario de ${slotProps.data.hora_inicio} a ${slotProps.data.hora_fin}`
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
                                    'ruta': 'Calendarizaciones.Horarios.forceDelete',
                                    'registro': `del aula ${slotProps.data.aula.nombre} el día ${slotProps.data.diaSemana.nombre} con horario de ${slotProps.data.hora_inicio} a ${slotProps.data.hora_fin}`
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
                    data_proceso : data_proceso
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

// Componentes de los modales
import moment from 'moment'

// Variables
const displayAlert = ref(null)
const data_proceso = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)

// Propiedades
const props = defineProps({
    horarios: {
        type: Object,
        default: null
    },
    diasSemana: {
        type: Object,
        default: null
    },
    aulas: {
        type: Object,
        default: null
    },
})

// Métodos
const modalGenericAlert = (data, show, dataProcess) => {
    dataRegistro.value = data
    displayAlert.value = show
    data_proceso.value = dataProcess
}

onMounted(() => {
    columns.value = [
        {field: 'id', header: 'ID', sortable: true},
        {field: 'aula.nombre', header: 'Aula', sortable: true},
        {field: 'diaSemana.nombre', header: 'Día', sortable: true},
        {field: 'hora_inicio', header: 'Hora inicio', sortable: true},
        {field: 'hora_fin', header: 'Hora fin', sortable: true},
    ];
})
</script>