<template>
    <GenericLayout titleModule="Usuarios">
        <template #content>
            <DynamicTable
                :data="users"
                :items="items"
                titleModule="Usuarios"
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
                        v-tooltip.top="'Actualizar'"
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
                                'ruta': 'permission.destroy',
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
                    data_generos: generos,
                    data_tipos_sangre: tipos_sangre,
                    data_estados_civiles: estados_civiles
                }"
                @closeModal="modalCreateUpdate({display: false, data: null})"
            />
            <GenericAlert
                :dataModal="{
                    display: display_generic_alert,
                    dataRegistro : dataRegistro,
                    data_proceso : data_proceso
                }"
                @closeModal="modalGenericAlert({display: false, data: null, data_proceso: null})"
            />
        </template>
    </GenericLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue';

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/System/Usuario/CreateUpdate.vue";

// Variables para los modales
const display_create_update = ref(false), display_generic_alert = ref(false);
const dataRegistro = ref(null), data_proceso = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
    display_create_update.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
    dataRegistro.value = event.data;
    display_generic_alert.value = event.display;
    data_proceso.value = event.proceso;
}

// Propiedades
const props = defineProps({
    users: {
        type: Object,
        default: null
    },
    generos: {
        type: Object,
        default: null,
    },
    tipos_sangre: {
        type: Object,
        default: null,
    },
    estados_civiles: {
        type: Object,
        default: null,
    }
})

// Array-Object para los items del DataTable
const items = ref([
    {
        dataField: {
            field: 'id',
            header : 'ID',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'numeric',
            minFractionDigits: 0,
            maxFractionDigits: 0,
        },
    },
    {
        dataField: {
            field: 'name',
            header : 'Nombre',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'text',
        },
    },
    {
        dataField: {
            field: 'email',
            header : 'Correo electrónico',
            sortable: true,
            type: 'text',
        },
        filters: {
            active: true,
            type: 'text',
        },
    },
])

</script>