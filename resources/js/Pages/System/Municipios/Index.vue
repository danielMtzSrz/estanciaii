<template>
    <GenericLayout titleModule="Municipios">
        <template #content>
            <DynamicTable
                :data="municipios"
                titleModule="Municipios"
                :items="[
                    {
                        dataField: {
                            field : 'pais_nombre',
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
                            field : 'estado_nombre',
                            header : 'Estado',
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
                            field : 'nombre',
                            header : 'Municipio',
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
                        v-if="hasPermission('municipios.store')"
                        type="button"
                        label="Nuevo"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                        @click="modalCreateUpdate({display: true})"
                    />
                </template>
                <template #buttons="{ data }">
                    <Button
                        v-if="hasPermission('municipios.update')"
                        type="button"
                        icon="pi pi-pencil"
                        class="p-button-warning p-button-text p-button-raised p-button-rounded"
                        @click="modalCreateUpdate({display: true, data: data})"
                    />
                    <Button
                        v-if="hasPermission('municipios.destroy')"
                        type="button"
                        icon="pi pi-trash"
                        class="p-button-danger p-button-text p-button-raised p-button-rounded"
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'municipios.destroy',
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
import CreateUpdate from "@/Pages/System/Municipios/CreateUpdate.vue";

// Variables
const displayCreateUpdate = ref(false);
const dataProceso = ref(null);
const dataRegistro = ref(null);
const displayGenericAlert = ref(null)

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
    municipios: {
        type: Object,
        default: {},
    },
});
</script>
