<template>
    <GenericLayout titleModule="Grupos">
        <template #content>
            <GenericTable :data="grupos">
                <template #headerContent>
                    <Button type="button" label="Nuevo" icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
                        @click="modalCreateUpdate(null, true)" />
                    <Link :href="route('EstructuraAcademica.Grupos.trashed')">
                    <Button type="button" label="Papelera" icon="pi pi-trash"
                        class="p-button-raised p-button-rounded p-button-text p-button-help p-button-sm" />
                    </Link>
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"
                        :sortable="col.sortable"></Column>
                    <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="slotProps">
                            <Button type="button" icon="pi pi-pencil"
                                class="p-button-warning p-button-text p-button-raised p-button-rounded"
                                @click="modalCreateUpdate(slotProps.data, true)" />
                            <Button type="button" icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded" @click="modalGenericAlert(slotProps.data, true,
                                    {
                                        'proceso': 'destroy',
                                        'ruta': 'EstructuraAcademica.Grupos.destroy',
                                        'registro': `del grupo ${slotProps.data.nombre}`
                                    }
                                )" />
                        </template>
                    </Column>
                </template>
            </GenericTable>
        </template>
        <template #footer>
            <!-- Modal crear - actualizar -->
            <form-create-update :dataModal="{
                display: displayCreateUpdate,
                dataRegistro: dataRegistro,
                dataCarreras: carreras,
                dataAulas: aulas,
                dataTutores: tutores
            }" v-on:visible="(visible) => modalCreateUpdate(null, visible)" />
            <!-- Modal eliminar -->
            <GenericAlert :dataModal="{
                display: displayAlert,
                dataRegistro: dataRegistro,
                data_proceso: data_proceso
            }" v-on:visible="(visible) => modalGenericAlert(null, visible, null)" />
        </template>
    </GenericLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Componentes de primevue
import Column from 'primevue/column';
import Button from "primevue/button";

// Componentes personalizados
import GenericLayout from '@/Layouts/GenericLayout.vue';
import GenericTable from '@/Components/GenericTable.vue';

// Componentes de los modales
import FormCreateUpdate from '@/Pages/EstructuraAcademica/Grupos/CreateUpdate.vue';
import GenericAlert from '@/Components/GenericAlert.vue';

// Variables
const displayCreateUpdate = ref(null)
const displayAlert = ref(null)
const data_proceso = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)

// Propiedades
const props = defineProps({
    grupos: {
        type: Array,
        default: null
    },
    carreras: {
        type: Array,
        default: null
    },
    aulas: {
        type: Array,
        default: null
    },
    tutores: {
        type: Array,
        default: null
    }
})

// Métodos
const modalCreateUpdate = (data, show) => {
    dataRegistro.value = data
    displayCreateUpdate.value = show
}

const modalGenericAlert = (data, show, dataProcess) => {
    dataRegistro.value = data
    displayAlert.value = show
    data_proceso.value = dataProcess
}

onMounted(() => {
    columns.value = [
        { field: 'id', header: 'ID', sortable: true },
        { field: 'carrera.nombre', header: 'Carrera', sortable: true },
        { field: 'aula.nombre', header: 'Aula', sortable: true },
        { field: 'tutor.name', header: 'Tutor', sortable: true },
        { field: 'nombre', header: 'Nombre', sortable: true },
        { field: 'turno', header: 'Turno', sortable: true },
        { field: 'created_at', header: 'Fecha de creación', sortable: true },
        { field: 'updated_at', header: 'Fecha de actualización', sortable: true }
    ];
})
</script>