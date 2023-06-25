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
                stripedRows
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                :rowsPerPageOptions="[5, 10, 20, 50]"
                currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} registros"
                removableSort
                ref="dt"
                :exportFilename="titleModule"
                :exportFooter="null"
                :globalFilterFields="Object.keys(filter)"
                filterDisplay="menu"
                v-model:filters="filter"
                v-model:selection="selectedRegister"
                @rowSelect="onRowSelect"
                @rowUnselect="onRowUnselect"
                :selectionMode="selectionModeRow"
                :metaKeySelection="false"
            >
                <!-- Configuración por defecto -->
                <template #empty>
                    <span class="text-red-500">No se encontraron registros</span>
                </template>
                <template #loading>
                    <ProgressSpinner animationDuration="1s" strokeWidth="3" />
                </template>
                <!-- Fin de la configuración por defecto -->
                <template #header>
                    <div class="sm:row md:flex justify-content-between">                    
                        <div class="flex flex-wrap align-items-center">
                            <slot name="headerContent"></slot>
                            <Button
                                icon="bi bi-filetype-csv"
                                label="Exportar"
                                class="ms-2 p-button-rounded p-button-info p-button-raised p-button-text p-button-sm"
                                @click="exportCSV($event)"
                            />
                        </div>
                        <div class="mt-4 md:mt-0 d-flex justify-content-end">
                            <div class="p-inputgroup w-full">
                                <span class="p-float-label">
                                    <InputText
                                        v-model="filter['global'].value"
                                    />
                                    <label class="font-normal">Búsqueda</label>
                                </span>
                                <Button
                                    type="button"
                                    icon="pi pi-filter-slash"
                                    class="p-button-outlined"
                                    @click="initFilter()"
                                    v-tooltip.top="'Eliminar búsqueda'"
                                />
                            </div>
                        </div>
                    </div>
                </template>
                <Column v-if="selectionModeCheck" :selectionMode="selectionModeCheck" headerStyle="width: 3em"></Column>
                <!-- <ColumnGroup type="header">
                    <Row>
                        <Column header="Product" :rowspan="3" />
                        <Column header="Sale Rate" :colspan="4" />
                    </Row>
                    <Row>
                        <Column header="Sales" :colspan="2" />
                        <Column header="Profits" :colspan="2" />
                    </Row>
                    <Row>
                        <Column header="Algo" field="id"></Column>
                        <Column header="Alg2o" field="id1"></Column>
                        <Column header="Algo3" field="id2"></Column>
                        <Column header="Algo4" field="id3"></Column>
                    </Row>
                </ColumnGroup> -->
                <slot name="content"></slot>
            </DataTable>
        </template>
    </Card>
</template>

<script setup>
import { ref, onMounted, watch, onUpdated } from "vue";

import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";

// Componentes de PrimeVue
import Column from "primevue/column";
import ProgressSpinner from "primevue/progressspinner";
import DataTable from "primevue/datatable";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import Card from "primevue/card";
const props = defineProps({
    data: {
        type: Object,
        default: null,
    },
    titleModule: {
        type: String,
        default: "download",
    },
    fields: {
        type: Object,
        default: null,
    },
    selectedRows: {
        type: Boolean,
        default: true,
    },
    selectionModeCheck: {
        type: String,
        default: null
    },
    selectionModeRow: {
        type: String,
        default: null
    },
});

// Variables
const dt = ref(null);
const loading = ref(null);
const initFilt = ref(Object?.keys(props?.fields ?? {}) ?? []);
const selectedRegister = ref(null)
// console.log(initFilt.value);

if (initFilt) {
    let arreglo = initFilt.value.map((col) => ({
        [col]: {
            operator: FilterOperator.AND,
            constraints: [
                {
                    value: null,
                    matchMode:
                        props.fields[col] === 'date'
                            ? FilterMatchMode.DATE_IS
                            : props.fields[col] === 'numeric'
                                ? FilterMatchMode.EQUALS
                                : FilterMatchMode.CONTAINS
                }
            ],
        },
    }));
    initFilt.value = arreglo;
}
// console.log(props.fields)
const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

for (let index = 0; index < initFilt.value.length; index++) {
    filter.value = { ...filter.value, ...initFilt.value[index] };
}
// filter.value.clave.constraints.value = "aaaa";
const initF = { ...filter.value };
// console.log(initF);

// Métodos
const initFilter = () => {
    filter.value = { ...initF };
};

const exportCSV = () => {
    dt.value.exportCSV();
};

onMounted(() => {
    loading.value = true;
    setTimeout(() => (loading.value = false), 1000);
    initFilter();
});

const emits = defineEmits(['selectedRegisters', 'rowSelect', 'rowUnselect'])

watch(selectedRegister, (newVal) => {
    emits('selectedRegisters', newVal);
})

watch(() => props.data, newVal => selectedRegister.value = null)

const onRowSelect = (event) => emits('rowSelect', event)
const onRowUnselect = (event) => emits('rowUnselect', event)
</script>
