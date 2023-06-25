<template>
    <AppLayout title="Direccion Carrera">
        <Panel :header="`Grupo ${grupoMateria.grupo.nombre} - ${grupoMateria.materia.nombre}`" class="mb-3">
            <GenericTable :data="grupoMateria.horario_grupo_materia">
                <template #headerContent>
                    <Button type="button" label="Nuevo horario" icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm"
                        @click="modalCreateUpdate(null, true, { grupo_materia_id: grupoMateria.id })" />
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"
                        :sortable="col.sortable"></Column>
                    <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="{data}">
                            <Button type="button" icon="pi pi-pencil"
                                class="p-button-warning p-button-raised p-button-rounded me-2" @click="modalCreateUpdate(data, true, {
                                    grupo_materia_id: grupoMateria.id,
                                    horario_grupo_materia_id: data.id
                                })" />
                            <Button type="button" icon="pi pi-trash"
                                class="p-button-danger p-button-raised p-button-rounded" @click="modalGenericAlert(data, true,
                                    {
                                        'proceso': 'destroy',
                                        'ruta': 'ProgramacionAcademica.DireccionCarrera.AsignaHorarios.destroy',
                                        'registro': `${data.horario.dia_semana.nombre} ${data.horario.hora_inicio} - ${data.horario.hora_fin}  `
                                    }
                                )" />
                        </template>
                    </Column>
                </template>
            </GenericTable>
            <FormCreateUpdate :dataModal="{
                display: displayCreateUpdate,
                dataRegistro: dataRegistro,
                dataRegistroParent: dataRegistroParent,
                dataAulas: aulas,
                dataDiasSemana: diasSemana
            }" v-on:visible="(visible) => modalCreateUpdate(null, visible, {})" />
            <GenericAlert :dataModal="{
                display: displayAlert,
                dataRegistro: dataRegistro,
                dataProceso: dataProceso
            }" v-on:visible="(visible) => modalGenericAlert(null, visible, null)" />
        </Panel>
        <Panel :header="`Horario ${grupoMateria.materia.nombre}`" class="mb-3">m
            <TimeTable :events="events"></TimeTable>
        </Panel>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from 'primevue/button';
import Column from 'primevue/column';
import Panel from 'primevue/panel';
import TimeTable from "@/Components/TimeTable.vue"

import FormCreateUpdate from '@/Pages/Modulos/ProgramacionAcademica/DireccionCarrera/AsignaHorarios/CreateUpdate.vue';
import GenericAlert from '@/Components/GenericAlert.vue';
import GenericTable from '@/Components/GenericTable.vue';

const props = defineProps({
    grupoMateria: {
        type: Object,
        required: true
    },
    aulas: Array,
    diasSemana: Array,
    events: Array
})
const columns = ref(null)
const displayAlert = ref(null)
const displayCreateUpdate = ref(null)
const dataProceso = ref(null)
const dataRegistro = ref(null)
const dataRegistroParent = ref(null)

const modalCreateUpdate = (data, show, parentData) => {
    dataRegistro.value = data
    displayCreateUpdate.value = show
    dataRegistroParent.value = parentData
}

const modalGenericAlert = (data, show, dataProcess) => {
    dataRegistro.value = data
    displayAlert.value = show
    dataProceso.value = dataProcess
}

onMounted(() => {
    columns.value = [
        { field: 'horario.aula.nombre', header: 'Aula', sortable: true },
        { field: 'horario.dia_semana.nombre', header: 'Día de la semana', sortable: true },
        { field: 'horario.hora_inicio', header: 'Hora Inicio', sortable: true },
        { field: 'horario.hora_fin', header: 'Hora Fin', sortable: true },
    ];
})
</script>