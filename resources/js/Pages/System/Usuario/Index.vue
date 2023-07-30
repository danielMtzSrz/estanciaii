<template>
    <GenericLayout titleModule="Usuarios">
        <template #content>
            <DynamicTable
                :data="userData"
                titleModule="Usuarios"
                :items="[
                    {
                        dataField: {
                            field: 'empresaImagen',
                            avatarText : 'empresaNombre',
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
                            field : 'name',
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
                            field : 'email',
                            header : 'Correo electrónico',
                            sortable: true,
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
                        @click="modalEliminar({display: true, data: data})"
                    />
                </template>
            </DynamicTable>
        </template>
 
        <!-- :errors="item.data_field?.errors ?? null"
        :disabled="item.data_field?.disabled ?? false"
        :tooltip="item.data_field.tooltip ?? null" -->

        <template #footer>
            <FormCreateUpdate
                :dataModal="{
                    display: displayCreateUpdate
                }"
                :fields="[
                    {
                        data_field: {
                            field : 'name',
                            label : 'Nombre',
                            icon: 'pi pi-plus',
                            type: 'text',
                            value: 'Hola',
                            sm: '12',
                            md: '6',
                            lg: '6',
                        },
                    },
                    {
                        data_field: {
                            field : 'dropdown_prueba',
                            label : 'Prueba del Dropdown',
                            textDropdown: 'text',
                            type: 'dropdown',
                            value: {
                                id: 1,
                                text: 'Texto 1'
                            },
                            data: [
                                {
                                    id: 1,
                                    text: 'Texto 1',
                                },
                                {
                                    id: 2,
                                    text: 'Texto 2',
                                }
                            ],
                            sm: '6',
                            md: '6',
                            lg: '6',
                        },
                    },
                    {
                        data_field: {
                            field : 'number',
                            label : 'Input de number',
                            id: 'input_number',
                            name: 'input_number',
                            type: 'number',
                            disabled: false,
                            tooltip: 'Tooltip de prueba',
                            value: 12234.34,
                            sm: '6',
                            md: '6',
                            lg: '6',
                        },
                    }
                ]"
                @closeModal="modalCreateUpdate({display: false, data: null})"
            />
        </template>
   </GenericLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue'

// PrimeVue
import Button from 'primevue/button'

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";

// Componentes personalizados
import DynamicTable from "@/Components/DynamicTable.vue";

// Componentes para los modales de los CRUD
import FormCreateUpdate from "@/Pages/System/Usuario/CreateUpdate.vue";

const props = defineProps({
    title: String,
    userData: Object,
    roles: Object,
    model_has_roles: Object,
})

const displayCreateUpdate = ref(null),
    displayActualizar = ref(null),
    displayEliminar = ref(null),
    usuarioData = ref(null),
    rolesAsignados = ref([])

// Methods
const modalCreateUpdate = (event) => {
    return displayCreateUpdate.value = event.display
}
const modalActualizar = (data, show) => {
    const role_id = props.model_has_roles.map((element) => {
        if (element.model_id == data.id) {
            return element.role_id;
        }
    });
    rolesAsignados.value = role_id.filter((el) => el != null);
    usuarioData.value = data;

    return displayActualizar.value = show;
}
const modalEliminar = (data, show) => {
    usuarioData.value = data;
    return displayEliminar.value = show;
}
</script>
