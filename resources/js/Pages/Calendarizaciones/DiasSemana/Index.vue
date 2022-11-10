<template>
    <GenericLayout titleModule="Días de la semana">
        <template #content>
            <GenericTable :data="diasSemana">
                <template #headerContent>
                    <Button
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
                        @click="modalCreateUpdate(null, true)"
                    />
                    <Link :href="route('Calendarizaciones.DiasSemana.trashed')">
                        <Button 
                            type="button"
                            label="Papelera"
                            icon="pi pi-trash"
                            class="p-button-raised p-button-rounded p-button-text p-button-help p-button-sm" 
                        />
                    </Link>
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" :sortable="col.sortable"></Column>
                    <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="slotProps">
                            
                            <!-- <Button
                                v-permission="'CalendarizacionesDiasSemana.update'" -->
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
                                @click="modalEliminar(slotProps.data, true)"
                            />
                        </template>
                    </Column>
                </template>
            </GenericTable>
        </template>

        <template #footer>
            <!-- Modal crear - actualizar -->
            <form-create-update
                :dataModal="{
                    display: displayCreateUpdate,
                    dataRegistro: dataRegistro
                }"
                v-on:visible="(visible) => modalCreateUpdate(null, visible)"
            />
            <!-- Modal eliminar -->
            <form-delete
                :dataModal="{
                    display: displayEliminar,
                    dataRegistro : dataRegistro
                }"
                v-on:visible="(visible) => modalEliminar(null, visible)"
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
import GenericLayout from '@/Components/GenericLayout.vue';
import GenericTable from '@/Components/GenericTable.vue';

// Componentes de los modales
import FormCreateUpdate from '@/Pages/Calendarizaciones/DiasSemana/CreateUpdate.vue';
import FormDelete from '@/Pages/Calendarizaciones/DiasSemana/Delete.vue';

// Variables
const displayCreateUpdate = ref(null)
const displayEliminar = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)

// Propiedades
const props = defineProps({
    diasSemana: {
        type: Object,
        default: {}
    }
})

// Métodos
const modalCreateUpdate = (data, show) => {
    dataRegistro.value = data
    displayCreateUpdate.value = show
}
const modalEliminar = (data, show) => {
    dataRegistro.value = data;
    displayEliminar.value = show;
}

onMounted(() => {
    columns.value = [
        {field: 'id', header: 'ID', sortable: true},
        {field: 'nombre', header: 'Nombre', sortable: true}
    ];
})
</script>