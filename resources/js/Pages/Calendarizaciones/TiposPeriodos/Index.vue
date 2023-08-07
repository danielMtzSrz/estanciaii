<template>
    <GenericLayout titleModule="Tipos de periodos">
        <template #content>
            <GenericTable :data="tiposPeriodos">
                <template #headerContent>
                    <Button
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
                        @click="modalCreateUpdate(null, true)"
                    />
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" :sortable="col.sortable"></Column>
                    <Column header="Color">
                        <template #body="slotProps">
                            <p :style="{'color': slotProps.data?.color ?? ''}">{{ slotProps.data.color }}</p>
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
                                @click="modalCreateUpdate(slotProps.data, true)"
                            />
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                @click="modalGenericAlert({
                                    data: slotProps.data, 
                                    display: true, 
                                    proceso: {
                                        'proceso': 'delete',
                                        'ruta': 'Calendarizaciones.TiposPeriodos.destroy',
                                    }
                                })"
                            />
                        </template>
                    </Column>
                </template>
            </GenericTable>
        </template>

        <template #footer>
            <!-- Modal crear - actualizar -->
            <form-create-update
                :data_modal="{
                    display: display_create_update,
                    data_registro: data_registro
                }"
                v-on:visible="(visible) => modalCreateUpdate(null, visible)"
            />
            <!-- Modal eliminar -->
            <GenericAlert
                :data_modal="{
                    display: display_generic_alert,
                    data_registro : data_registro,
                    data_proceso : data_proceso
                }"
                @closeModal="modalGenericAlert({display: false, data: null, data_proceso: null})"
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
import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import FormCreateUpdate from '@/Pages/Calendarizaciones/TiposPeriodos/CreateUpdate.vue';

// Variables
const display_create_update = ref(null)
const display_generic_alert = ref(null)
const data_registro = ref(null)
const data_proceso = ref(null);
const columns = ref(null)

// Propiedades
const props = defineProps({
    tiposPeriodos: {
        type: Object,
        default: {}
    }
})

// Métodos
const modalCreateUpdate = (data, show) => {
    data_registro.value = data
    display_create_update.value = show
}

const modalGenericAlert = (event) => {
    data_registro.value = event.data;
    display_generic_alert.value = event.display;
    data_proceso.value = event.proceso;
}

onMounted(() => {
    columns.value = [
        {field: 'id', header: 'ID', sortable: true},
        {field: 'nombre', header: 'Nombre', sortable: true},
        {field: 'descripcion', header: 'Descripción', sortable: true},
    ];
})
</script>