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
                            label="Plan de estudio"
                            :data="dataPlanesEstudio"
                            textDropdown="mapa_curricular_clave_mapa_curricular"
                            v-model="planEstudioSeleccionado"
                            :errors="form.errors.plan_estudios_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Cuatrimestre"
                            :data="dataCuatrimestres"
                            textDropdown="nombre"
                            v-model="cuatrimestreSeleccionado"
                            :errors="form.errors.cuatrimestre_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <InputText
                            label="Nombre"
                            v-model="form.nombre"
                            :errors="form.errors.nombre"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4 d-flex flex-col mb-5 gap-2">
                        <small>Color: <span :style='{color : "#"+form.color}'>#{{ form.color }}</span></small>
                        <ColorPicker v-model="form.color"/>
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
import ColorPicker from "primevue/colorpicker";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";

// Variables
const dataPlanesEstudio = ref(null), dataCuatrimestres = ref(null)
const planEstudioSeleccionado = ref(null), cuatrimestreSeleccionado = ref(null)

const form = useForm({
    _method : null,
    plan_estudios_id : null,
    cuatrimestre_id : null,
    nombre : null,
    color : '6466f1',
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

    if(!props.dataModal.dataRegistro){
        form.transform((data) => ({
            ...data,
            plan_estudios_id : planEstudioSeleccionado.value?.id ?? null,
            cuatrimestre_id : cuatrimestreSeleccionado.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    }else{
        form.transform((data) => ({
            ...data,
            plan_estudios_id : planEstudioSeleccionado.value?.id ?? null,
            cuatrimestre_id : cuatrimestreSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.Materias.store' : 'GestionAcademica.Materias.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva materia' : 'Actualizar materia'

    const dataCuatrimestresAxios = await axios.get(`/api/cuatrimestres`);
    dataCuatrimestres.value = dataCuatrimestresAxios.data;

    const dataPlanesEstudioAxios = await axios.get(`/api/planes_estudio`);
    dataPlanesEstudio.value = dataPlanesEstudioAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.plan_estudios_id = newVal?.plan_estudios.id ?? null
    form.cuatrimestre_id = newVal?.cuatrimestre.id ?? null
    form.nombre = newVal?.nombre ?? null
    form.color = newVal?.color ?? null

    planEstudioSeleccionado.value = newVal?.plan_estudios
    cuatrimestreSeleccionado.value = newVal?.cuatrimestre
})
</script>
