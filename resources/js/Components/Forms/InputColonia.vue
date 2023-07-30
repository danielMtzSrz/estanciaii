<!-- /*

* ? Esto usa los siguientes atributos

| Propiedad | Tipo   | Valores | Default | Descripción                     |
|-----------|--------|---------|---------|---------------------------------|
| v-model   | object | Object  | null    | El objeto del Modelo de Colonia |
| errors    | string | string  | null    | El string de error del input    |

* ? Fin de la definición de los atributos

* ? EMITS

| Evento        | Tipo   | Valores | Default                  | Descripción                                                          |
|---------------|--------|---------|--------------------------|----------------------------------------------------------------------|
| select        | object | Object  | \Model\Domicilio\Colonia | Retorna el objeto de la colonia seleccionada, con municipio y estado |
| update:errors | string | String  | ""                       | Retorna el mensaje de error(para borrar el error )                   |


* TODO: Ejemplo
* * import InputColonia from "@/Components/Forms/InputColonia.vue";

    // Dentro de un modal al que se le paso un registro con domicilio
    <InputColonia
        v-model="
            props.dataModal?.dataRegistro?.domicilio
                ?.colonia
        "
        :errors="errores.colonia"
        @update:errors="errores.colonia = $event"
        @seleccionado="colonia = $event"
    />
*/ -->
<template>
    <!-- antes de que me veas feo yo del futuro, (et.al) es un hack para funcionar con cualquier tema -->
    <div
        :class="errors ? 'p-dropdown p-invalid p-component' : null"
        class="my-auto"
    >
        <Card class="w-full">
            <template #content>
                <div v-if="!externo" class="w-full">
                    <Button
                        type="button"
                        icon="pi pi-search"
                        :label="`${cp ? 'CP: ' + cp : 'Buscar'}`"
                        @click="togglePanelCp"
                        aria-haspopup="true"
                        aria-controls="overlay_panel"
                    />
                    <OverlayPanel
                        ref="op"
                        :showCloseIcon="true"
                        id="overlay_panel"
                        :breakpoints="{ '960px': '75vw' }"
                        class="vw-75"
                    >
                        <div class="m-auto mb-2 flex">
                            <Dropdown
                                v-model="bySelector"
                                :options="selectores"
                                optionLabel="nombre"
                                placeholder="Seleccionar Por"
                                @select="cpQuery.value = null"
                            />
                            <div v-if="bySelector.by == 'Cp'">
                                <InputNumber
                                    v-model="cpQuery"
                                    mode="decimal"
                                    :useGrouping="false"
                                    :disabled="loading"
                                />
                            </div>
                            <div v-else>
                                <InputText
                                    v-model="cpQuery"
                                    :useGrouping="false"
                                    :disabled="loading"
                                />
                            </div>
                            <Button
                                type="button"
                                icon="pi pi-search"
                                label="Buscar"
                                @click="search"
                                class="h-full"
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
                            <Column
                                field="cp"
                                header="Codigo Postal"
                                sortable
                            ></Column>
                            <Column
                                field="nombre"
                                header="Nombre"
                                sortable
                            ></Column>
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
                                        v-model="coloniaShow"
                                        disabled
                                    />
                                    <label for="coloniaShow">Colonia</label>
                                </span>
                            </div>
                        </div>
                        <div class="md:col-6 col-12 md:my-4 my-2">
                            <div class="p-inputgroup">
                                <span class="p-float-label">
                                    <InputText
                                        id="municipioShow"
                                        v-model="municipioShow"
                                        disabled
                                    />
                                    <label for="municipioShow">Municipio</label>
                                </span>
                            </div>
                        </div>
                        <div class="md:col-6 col-12 md:my-4 my-2">
                            <div class="p-inputgroup">
                                <span class="p-float-label">
                                    <InputText
                                        id="estadoShow"
                                        v-model="estadoShow"
                                        disabled
                                    />
                                    <label for="estadoShow">Estado</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field-checkbox">
                    <Checkbox
                        inputId="ifExterno"
                        v-model="externo"
                        :binary="true"
                    />
                    <label for="ifExterno">¿Externo a México?</label>
                </div>
                <div>
                    <small class="p-error" v-if="errors">
                        {{ errors }}
                    </small>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, onMounted, onUpdated, watch, computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
// PrimeVue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ProgressSpinner from "primevue/progressspinner";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from "primevue/card";
import OverlayPanel from "primevue/overlaypanel";
import InputNumber from "primevue/inputnumber";
import Checkbox from "primevue/checkbox";
import Dropdown from "primevue/dropdown";

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

// manejo externos a México
const externo = ref(false);

const emits = defineEmits(["select", "update:modelValue", "update:errors"]);
const props = defineProps({
    modelValue: {
        type: Object,
        default: {},
    },
    errors: {
        type: [String, Object],
        default: null,
    },
});

// Manejo del v-model
const colonia = computed({
    get: () => props.modelValue,
    set({ data }) {
        showUpdate(data);
        // Emite el resultados
        emits("select", data);
        emits("update:modelValue", data);
        emits("update:errors", "")
    },
});
const showUpdate = (data) => {
    // Actualiza el display
    cp.value = data?.cp ?? null;
    coloniaShow.value = data?.nombre ?? null;
    municipioShow.value = data?.municipio?.nombre ?? null;
    estadoShow.value = data?.municipio?.estado?.nombre ?? null;
};
onUpdated(() => {
    showUpdate(props.modelValue);
});

// Selecciona una colonia
const selectCp = (cpSelected) => {
    togglePanelCp(); // cierra op
    colonia.value = cpSelected;
};

// Manejo de buscadores
const selectores = ref([
    { nombre: "Por Cp", by: "Cp" },
    { nombre: "Por Nombre", by: "Name" },
    { nombre: "Por Municipio", by: "Mun" },
    { nombre: "Por Estado", by: "Est" },
]);
const bySelector = ref({ nombre: "Por Nombre", by: "Name" });
// Buscador
const search = async () => {
    if (!cpQuery.value) return;
    let ruta = "api.domicilios.cp.by" + bySelector.value.by;
    loading.value = true;
    await axios.get(route(ruta, cpQuery.value)).then((query) => {
        loading.value = false;
        queriedCp.value = query.data;
    });
};
watch(bySelector, (newVal, oldVal) => {
    if (oldVal.by == "Cp" || newVal.by == "Cp") cpQuery.value = null;
});

// Manejo de colonias en el extranjero
watch(externo, (newVal) => {
    if (newVal)
        axios
            .get(route("api.domicilios.cp.byName", "Externo"))
            .then(({ data }) => {
                colonia.value = { data: data[0] };
            });
    else colonia.value = { data: null };
});

// Métodos
const togglePanelCp = (event) => {
    op.value.toggle(event);
};
onMounted(() => {
    // Hardcode para que no se buggee al abrirlo
    axios.get(route("api.domicilios.cp.byCp", 760)).then((query) => {
        loading.value = false;
        queriedCp.value = query.data;
    });
});
</script>
