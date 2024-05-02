<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Periodo"
                            :data="dataPeriodos"
                            textDropdown="titulo"
                            v-model="periodoSeleccionado"
                            :errors="form.errors.periodo_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Tipo de convocatoria"
                            :data="dataTiposConvocatoria"
                            textDropdown="nombre"
                            v-model="tipoConvocatoriaSeleccionado"
                            :errors="form.errors.tipo_convocatoria_id"
                        />
                    </div>
                    

                    <div class="col-sm-12">
                        <Textarea
                            label="Contenido"
                            v-model="form.contenido"
                            :errors="form.errors.contenido"
                        />
                    </div>

                </div>

                <div class="float-end space-x-2 py-4">
                    <Button
                        type="button"
                        label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="closeModal()"
                    />
                    <Button
                        type="submit"
                        label="Guardar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="form.processing"
                    />
                </div>
            </form>
        </template>
    </GenericModal>
</template>

<script setup>

// Vue
import { ref, watch } from "vue";

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import Dropdown from "@/Components/Forms/Dropdown.vue";
import Textarea from "@/Components/Forms/Textarea.vue";

// Variables

const dataTiposConvocatoria = ref(null), tipoConvocatoriaSeleccionado = ref(null)
const dataPeriodos = ref(null), periodoSeleccionado = ref(null)


const form = useForm({
    _method: null,
    periodo_id: null,
    tipo_convocatoria_id: null,
    contenido: null
});

const ruta = ref(null), titulo = ref(null);

// Props
const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

// Emits
const emits = defineEmits(["closeModal"]);

// Methods
const closeModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
};

const submit = () => {

    if (!props.dataModal.dataRegistro) {
        form.transform((data) => ({
            ...data,
            periodo_id: periodoSeleccionado.value?.id ?? null,
            tipo_convocatoria_id: tipoConvocatoriaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            periodo_id: periodoSeleccionado.value?.id ?? null,
            tipo_convocatoria_id: tipoConvocatoriaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'Calendarizaciones.Convocatorias.store' : 'Calendarizaciones.Convocatorias.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva convocatoria' : 'Actualizar convocatoria'

    const dataTiposConvocatoriaAxios = await axios.get(`/api/tipos_convocatoria`);
    dataTiposConvocatoria.value = dataTiposConvocatoriaAxios.data;

    const dataPeriodosAxios = await axios.get(`/api/periodos`);
    dataPeriodos.value = dataPeriodosAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.periodo_id = newVal?.periodo_id ?? null,
    form.tipo_convocatoria_id = newVal?.tipo_convocatoria_id ?? null,
    form.contenido = newVal?.contenido ?? null

    tipoConvocatoriaSeleccionado.value = newVal?.tipo_convocatoria ?? null,
    periodoSeleccionado.value = newVal?.periodo ?? null
})
</script>
