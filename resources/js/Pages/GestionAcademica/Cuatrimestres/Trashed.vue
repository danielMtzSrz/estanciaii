<template>
    <GenericLayout titleModule="Cuatrimestres eliminados">
        <template #content>
            <GenericTable :data="cuatrimestres">
                <template #headerContent>
                    <Link :href="route('GestionAcademica.Cuatrimestres.index')">
                        <Button
                            type="button"
                            label="Regresar"
                            icon="bi bi-arrow-return-left"
                            class="p-button-raised p-button-rounded p-button-text p-button-warning p-button-sm"
                        />
                    </Link>
                </template>
                <template #content>
                    <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" :sortable="col.sortable">
                        <template #body="{data}" v-if="data===null">Nulo</template> 
                        <template  #body="{ data }" v-else-if="col.field == 'deleted_at'">{{ moment( new Date(data.deleted_at)).calendar() }}</template>
                    </Column>
                    <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                        <template #body="slotProps">
                            <!-- <Button
                            v-permission="'permission.update'" -->
                            <Button
                                type="button"
                                icon="bi bi-arrow-counterclockwise"
                                class="p-button-success p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Restaurar'"
                                @click="modalGenericAlert(slotProps.data, true, 
                                    {
                                    'proceso': 'restore',
                                    'ruta': 'GestionAcademica.Cuatrimestres.restore',
                                    'registro': `${slotProps.data.nombre}`
                                    }
                                )"
                            />
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                v-tooltip.top="'Eliminar definitivamente'"
                                @click="modalGenericAlert(slotProps.data, true, 
                                    {
                                    'proceso': 'forceDelete',
                                    'ruta': 'GestionAcademica.Cuatrimestres.forceDelete',
                                    'registro': `${slotProps.data.nombre}`
                                    }
                                )"
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
                    display: displayAlert,
                    dataRegistro : dataRegistro,
                    data_proceso : data_proceso
                }"
                v-on:visible="(visible) => modalGenericAlert(null, visible, null)"
            />
        </template>
    </GenericLayout>
</template>
<script setup>
    import {ref, onMounted} from 'vue';
    
    import Column from 'primevue/column';
    import Button from "primevue/button";
    import InputText from "primevue/inputtext";
    
    import GenericLayout from '@/Layouts/GenericLayout.vue';
    import GenericTable from '@/Components/GenericTable.vue';
    import GenericAlert from '@/Components/GenericAlert.vue';
    
    import moment from 'moment'
    
    const displayAlert = ref(null)
    const data_proceso = ref(null)
    const dataRegistro = ref(null)
    const columns = ref(null)
    
    const props = defineProps({
        cuatrimestres: {
            type: Object,
            default: null
        },
    })
    
    const modalGenericAlert = (data, show, dataProcess) => {
        dataRegistro.value = data
        displayAlert.value = show
        data_proceso.value = dataProcess
    }
    
    onMounted(() => {
        columns.value = [
            {field: 'id', header: 'Id', sortable: true},
            {field: 'nombre', header: 'Nombre', sortable: true},
            {field: 'deleted_at', header: 'Fecha de eliminación', sortable: true},
        ];
    })
    </script>