<template>
    <Card>
        <template #content>
            <DataTable
                class="p-datatable-sm mb-4"
                :value="data"
                :paginator="true"
                :rows="10"
                :resizableColumns="true"
                columnResizeMode="fit | expand"
                :loading="loading"
                responsiveLayout="scroll"
                v-model:filters="filter"
                stripedRows
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                :rowsPerPageOptions="[10,20,50]"
                currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
                removableSort
            >
                <!-- Configuración por defecto -->
                <template #empty>
                    <span class="text-red-500">No se encontraron registros</span>
                </template>
                <template #loading>
                    <ProgressSpinner animationDuration="1s" strokeWidth="3"/>
                </template>
                <!-- Fin de la configuración por defecto -->
                <template #header>
                    <div class="row">
                        <div class="col-sm-6">
                            <slot name="headerContent"></slot>
                        </div>
                        <div class="d-flex justify-content-end col-sm-6">
                            <div class="p-inputgroup w-auto">
                                <span  span class="p-float-label">
                                <InputText
                                        v-model="filter['global'].value"
                                        placeholder="Búsqueda"
                                    />
                                </span>
                                <Button
                                    type="button"
                                    icon="pi pi-filter-slash"
                                    class="p-button-outlined"
                                    @click="initFilter()"
                                />
                            </div>
                        </div>
                    </div>
                </template>
                <slot name="content"></slot>
            </DataTable>
            
        </template>
    </Card>
</template>

<script setup>
import {ref, onMounted} from 'vue';
// Componentes de PrimeVue
import ProgressSpinner from 'primevue/progressspinner';
import DataTable from 'primevue/datatable';
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import { FilterMatchMode } from "primevue/api";
import Card from "primevue/card"

// Variables
const loading = ref(null)          
const filter = ref({'global': {value: null, matchMode: FilterMatchMode.CONTAINS}})

const props = defineProps({
    data : {
        type: Object,
        default : {}
    }
});

// Métodos
const initFilter = () => {
    filter.value = {
        'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
    };
}

onMounted(() => {
    loading.value = true;
    setTimeout(() => loading.value = false, 1000);
    initFilter();
})
</script>