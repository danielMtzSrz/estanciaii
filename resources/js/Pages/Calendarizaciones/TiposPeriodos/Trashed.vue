<template>
    <GenericLayout titleModule="Tipos de periodos eliminados">
        <template #content>
            <GenericTable :data="tipoPeriodo">
                <template #headerContent>
                    <Link :href="route('Calendarizaciones.TiposPeriodos.index')">
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
                    <Column header="Color">
                        <template #body="slotProps">
                            <p :style="{'color': slotProps.data?.color ?? ''}">{{ slotProps.data.color }}</p>
                        </template>
                    </Column>
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
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Restaurar'"
                                @click="modalGenericAlert({
                                    data: slotProps.data, 
                                    display: true, 
                                    proceso: {
                                        'proceso': 'restore',
                                        'ruta': 'Calendarizaciones.TiposPeriodos.restore',
                                    }
                                })"
                            />
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Eliminar definitivamente'"
                                @click="modalGenericAlert({
                                    data: slotProps.data, 
                                    display: true, 
                                    proceso: {
                                        'proceso': 'forceDelete',
                                        'ruta': 'Calendarizaciones.TiposPeriodos.forceDelete',
                                    }
                                })"
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
                    display: display_generic_alert,
                    dataRegistro : dataRegistro,
                    dataProceso : dataProceso
                }"
                @closeModal="modalGenericAlert({display: false, data: null, dataProceso: null})"
            />
        </template>
    </GenericLayout>
</template>

<script setup>
import {ref, onMounted} from 'vue';

// Componentes de primevue
import Column from 'primevue/column';
import Button from "primevue/button";

// Componentes personalizados
import GenericLayout from '@/Layouts/GenericLayout.vue';
import GenericTable from '@/Components/GenericTable.vue';
import GenericAlert from '@/Components/GenericAlert.vue';

import moment from 'moment'

// Variables
const display_generic_alert = ref(null)
const dataProceso = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)

// Propiedades
const props = defineProps({
    tipoPeriodo: {
        type: Object,
        default: null
    },
})

// Métodos
const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    display_generic_alert.value = event.display;
    dataProceso.value = event.proceso;
}

onMounted(() => {
    columns.value = [
        {field: 'id', header: 'ID', sortable: true},
        {field: 'nombre', header: 'Nombre', sortable: true},
        {field: 'descripcion', header: 'Descripción', sortable: true},
    ];
})
</script>