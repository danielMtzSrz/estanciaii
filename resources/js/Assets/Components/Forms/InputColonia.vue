/* */

<template>
    <Card>
        <template #content>
            <Button
                type="button"
                icon="pi pi-search"
                :label="`${cp ? 'CP: ' + cp : 'Busca con Codigo Postal'}`"
                @click="togglePanelCp"
                aria-haspopup="true"
                aria-controls="overlay_panel"
            />
            <OverlayPanel
                ref="op"
                appendTo="body"
                :showCloseIcon="true"
                id="overlay_panel"
                :breakpoints="{ '960px': '75vw' }"
                class="vw-75"
            >
                <div class="m-auto mb-2">
                    <InputNumber
                        id="cpSearchBar"
                        v-model="cpQuery"
                        mode="decimal"
                        :useGrouping="false"
                    />
                </div>
                <DataTable
                    :value="queriedCp"
                    selectionMode="single"
                    :paginator="true"
                    :rows="5"
                    @rowSelect="selectCp($event)"
                    responsiveLayout="scroll"
                    :loading="loading"
                >
                    <Column field="cp" header="Codigo Postal" sortable></Column>
                    <Column field="nombre" header="Nombre" sortable></Column>
                    <Column
                        field="municipio.nombre"
                        header="Municipio"
                        sortable
                    ></Column>
                    <Column
                        field="municipio.estado.nombre"
                        header="Estado"
                        sortable
                    ></Column>
                </DataTable>
            </OverlayPanel>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-map"></i>
                        </span>
                        <span class="p-float-label">
                            <InputText
                                id="coloniaShow"
                                :value="coloniaShow"
                                v-model="coloniaShow"
                                disabled
                            />
                            <label for="coloniaShow">Colonia</label>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-inputgroup">
                        <span class="p-float-label">
                            <InputText
                                id="municipioShow"
                                :value="municipioShow"
                                v-model="municipioShow"
                                disabled
                            />
                            <label for="municipioShow">Municipio</label>
                        </span>
                    </div>
                </div>
                <div class="col-md-6 mt-sm-4">
                    <div class="p-inputgroup">
                        <span class="p-float-label">
                            <InputText
                                id="estadoShow"
                                :value="estadoShow"
                                v-model="estadoShow"
                                disabled
                            />
                            <label for="estadoShow">Estado</label>
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </Card>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
// Componentes de PrimeVue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ProgressSpinner from "primevue/progressspinner";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from "primevue/card";
import OverlayPanel from "primevue/overlaypanel";
import InputNumber from "primevue/inputnumber";

// Componentes internos

// Variables
const op = ref();
const loading = ref(true);
// Domicilio
const cp = ref();
const cpQuery = ref();
const queriedCp = ref();
// SHow la informacion de la colonia seleccionada
const estadoShow = ref();
const municipioShow = ref();
const coloniaShow = ref();

const props = defineProps({
    data: {
        type: Object,
        default: {},
    },
});

// Buscador
watch(cpQuery, async () => {
    loading.value = true;
    await axios.get(route("api.domicilio.cp", cpQuery.value)).then((query) => {
        loading.value = false;
        queriedCp.value = query.data;
    });
});

const emits = defineEmits(["sleccionado"]);
const selectCp = (cpSelected) => {
    // cierra op
    togglePanelCp();
    console.log(cpSelected.data);
    // Muestra seleccionado
    cp.value = cpSelected.data.cp;
    coloniaShow.value = cpSelected.data.nombre;
    municipioShow.value = cpSelected.data.municipio.nombre;
    estadoShow.value = cpSelected.data.municipio.estado.nombre;

    // Emite el resultado
    emits("seleccionado", cpSelected.data);
};

// Métodos
const togglePanelCp = (event) => {
    op.value.toggle(event);
};
onMounted(() => {
    cpQuery.value = props?.data?.cp
    cp.value = props?.data?.cp;
    coloniaShow.value = props?.data?.nombre;
    municipioShow.value = props?.data?.municipio?.nombre;
    estadoShow.value = props?.data?.municipio?.estado?.nombre;
    // Hardcode para que no se buggee al abrirlo
    axios.get(route("api.domicilio.cp", 760)).then((query) => {
        loading.value = false;
        queriedCp.value = query.data;
    });
});
</script>
