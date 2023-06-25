<template>
    <GenericLayout titleModule="Materias eliminadas">
        <template #content>
            <GenericTable :data="materias">
                <template #headerContent>
                    <Link :href="route('GestionAcademica.Materias.index')">
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
                        <template #body="{data}" v-if="data===null"><p>Nulo</p></template>   
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
                                    'ruta': 'GestionAcademica.Materias.restore',
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
                                    'ruta': 'GestionAcademica.Materias.forceDelete',
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
                    dataProceso : dataProceso
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
    const dataProceso = ref(null)
    const dataRegistro = ref(null)
    const columns = ref(null)
    
    const props = defineProps({
        materias: {
            type: Object,
            default: null
        },
    })
    
    const modalGenericAlert = (data, show, dataProcess) => {
        dataRegistro.value = data
        displayAlert.value = show
        dataProceso.value = dataProcess
    }
    
    onMounted(() => {
        columns.value = [
            {field: 'id', header: 'ID', sortable: true},
            {field: 'cuatrimestre.nombre', header: 'Cuatrimestre', sortable: true},
            {field: 'nombre', header: 'Nombre', sortable: true},
            {field: 'planEstudio.carrera.nombre', header: 'Plan de Estudios', sortable: true},
            {field: 'deleted_at', header: 'Fecha de eliminación', sortable: true},
        ];
    })
</script>