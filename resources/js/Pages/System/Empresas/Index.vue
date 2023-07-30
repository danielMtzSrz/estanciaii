<template>
    <GenericLayout titleModule="Empresas">
        <template #content>
            <DynamicTable
                :data="empresas"
                titleModule="Empresas"
                :items="[
                    {
                        dataField: {
                            field: 'imagen',
                            avatarText : 'nombre_empresa',
                            header : 'Empresa',
                            sortable: true,
                            type: 'avatar',
                        },
                        filters: {
                            active: true,
                            type: 'text',
                        },
                    },
                    {
                        dataField: {
                            field : 'razon_social',
                            header : 'Razón social',
                            sortable: false,
                            type: 'html',
                            headerStyle: 'width: 20em'
                        },
                        filters: {
                            active: false,
                            type: 'text',
                        },
                    },
                    {
                        dataField: {
                            field : 'direccion',
                            header : 'Dirección',
                            sortable: true,
                            type: 'text',
                            headerStyle: 'width: 20em'
                        },
                        filters: {
                            active: true,
                            type: 'text',
                        },
                    },
                    {
                        dataField: {
                            field : 'rfc',
                            header : 'RFC',
                            sortable: true,
                            type: 'text',
                            headerStyle: 'width: 20em'
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
                        @click="modalEliminar({display: true, data: data})"
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
                v-on:visible="(visible) => modalGenericAlert({display: false})"
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
import CreateUpdate from "@/Pages/System/Empresas/CreateUpdate.vue";

// Variables
const displayCreateUpdate = ref(false);
const dataProceso = ref(null);
const dataRegistro = ref(null);
const displayGenericAlert = ref(null)

// Propiedades
const props = defineProps({
    empresas: {
        type: Object,
        default: {},
    },
});

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
</script>
