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
                        @click="modalGenericAlert({
                            data: data, 
                            display: true, 
                            proceso: {
                                'proceso': 'delete',
                                'ruta': 'empresas.destroy',
                                'exta_info': `${data?.nombre_empresa}, ${data?.direccion}`
                            }
                        })"
                    />
                </template>
            </DynamicTable>
        </template>

        <template #footer>
            <CreateUpdate
                :data_modal="{
                    display: display_create_update,
                    data_registro: data_registro,
                }"
                @closeModal="modalCreateUpdate({display: false, data: null})"
            />
            
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
import { ref } from "vue";

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/System/Empresas/CreateUpdate.vue";

// Variables
const display_create_update = ref(false);
const data_proceso = ref(null);
const data_registro = ref(null);
const display_generic_alert = ref(null)

// Propiedades
const props = defineProps({
    empresas: {
        type: Object,
        default: {},
    },
});

// Métodos
const modalCreateUpdate = (event) => {
    display_create_update.value = event.display;
    data_registro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    data_registro.value = event.data;
    display_generic_alert.value = event.display;
    data_proceso.value = event.proceso;
}
</script>
