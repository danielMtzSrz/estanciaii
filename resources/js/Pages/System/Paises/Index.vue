<template>
    <GenericLayout titleModule="Paises">
        <template #content>
            <DynamicTable
                :data="paises"
                titleModule="Paises"
                :items="[
                    {
                        dataField: {
                            field : 'nombre',
                            header : 'País',
                            sortable: false,
                            type: 'text',
                        },
                        filters: {
                            active: true,
                            type: 'text',
                        },
                    },
                    {
                        dataField: {
                            field : 'nacionalidad',
                            header : 'Nacionalidad',
                            sortable: false,
                            type: 'text',
                        },
                        filters: {
                            active: true,
                            type: 'text',
                        },
                    },
                ]"
            >
                <template #header>
                    <Button
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                        @click="modalCreateUpdate({display: true})"
                    />
                </template>
                <template #buttons="{ data }">
                    <Button
                        type="button"
                        icon="pi pi-pencil"
                        class="p-button-warning p-button-text p-button-raised p-button-rounded"
                        @click="modalCreateUpdate({display: true, data: data})"
                    />
                    <Button
                        type="button"
                        icon="pi pi-trash"
                        class="p-button-danger p-button-text p-button-raised p-button-rounded"
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'paises.destroy',
                            }
                        })"
                    />
                </template>
            </DynamicTable>
        </template>

        <template #footer>
            <CreateUpdate
                :dataModal="{
                    display: display_create_update,
                    dataRegistro: dataRegistro,
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
import { ref } from "vue";

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";
import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/System/Paises/CreateUpdate.vue";

// Variables
const display_create_update = ref(false);
const dataProceso = ref(null);
const dataRegistro = ref(null);
const displayGenericAlert = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
    display_create_update.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    displayGenericAlert.value = event.display;
    dataProceso.value = event.proceso;
}

// Propiedades
const props = defineProps({
    paises: {
        type: Object,
        default: {},
    },
});
</script>
