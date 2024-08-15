<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">

                    <div class="col-sm-12 col-md-8">
                        <Dropdown 
                            label="Carrera"
                            :data="dataCarreras"
                            textDropdown="nombre"
                            v-model="carreraSeleccionada"
                            :errors="form.errors.carrera_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Periodo"
                            :data="dataPeriodos"
                            textDropdown="titulo"
                            v-model="periodoSeleccionado"
                            :errors="form.errors.periodo_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Aula"
                            :data="dataAulas"
                            textDropdown="nombre"
                            v-model="aulaSeleccionada"
                            :errors="form.errors.aula_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Nombre"
                            v-model="form.nombre"
                            :errors="form.errors.nombre"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Turno"
                            :data="dataTurnos"
                            textDropdown="nombre"
                            v-model="turnoSeleccionado"
                            :errors="form.errors.turno"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <Dropdown 
                            label="Tutor"
                            :data="dataUsuarios"
                            textDropdown="nombre"
                            imageDropdown="profile_photo_path"
                            v-model="usuarioSeleccionado"
                            :errors="form.errors.tutor_id"
                        />
                    </div>

                    <Schedules
                        v-model="form.horarios"
                        :errors="form.errors.horarios"
                    />

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
import InputText from "@/Components/Forms/InputText.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import Schedules from "@/Components/Forms/Schedules.vue";

// Variables
const dataUsuarios = ref(null), dataAulas = ref(null), dataCarreras = ref(null), dataTurnos = ref(null), dataPeriodos = ref(null)
const usuarioSeleccionado = ref(null), aulaSeleccionada = ref(null), carreraSeleccionada = ref(null), turnoSeleccionado = ref(null), periodoSeleccionado = ref(null)

const form = useForm({
    _method : null,
    carrera_id : null,
    aula_id : null,
    tutor_id : null,
    nombre : null,
    turno : null,
    horarios : null
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
            carrera_id : carreraSeleccionada.value?.id ?? null,
            aula_id : aulaSeleccionada.value?.id ?? null,
            tutor_id : usuarioSeleccionado.value?.id ?? null,
            turno : turnoSeleccionado.value?.id ?? null,
            periodo_id : periodoSeleccionado.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            carrera_id : carreraSeleccionada.value?.id ?? null,
            aula_id : aulaSeleccionada.value?.id ?? null,
            tutor_id : usuarioSeleccionado.value?.id ?? null,
            turno : turnoSeleccionado.value?.id ?? null,
            periodo_id : periodoSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.Grupos.store' : 'EstructuraAcademica.Grupos.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo grupo' : 'Actualizar grupo'

    const dataUsuariosAxios = await axios.get(`/api/usuarios`);
    dataUsuarios.value = dataUsuariosAxios.data;

    const dataAulasAxios = await axios.get(`/api/aulas`);
    dataAulas.value = dataAulasAxios.data;

    const dataCarrerasAxios = await axios.get(`/api/carreras`);
    dataCarreras.value = dataCarrerasAxios.data;

    const dataTurnosAxios = await axios.get(`/api/turnos`);
    dataTurnos.value = dataTurnosAxios.data;

    const dataPeriodosAxios = await axios.get(`/api/periodos`);
    dataPeriodos.value = dataPeriodosAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.carrera_id = newVal?.carrera.id ?? null
    form.aula_id = newVal?.aula.id ?? null
    form.tutor_id = newVal?.tutor.id ?? null
    form.periodo_id = newVal?.periodo.id ?? null
    form.nombre = newVal?.nombre ?? null
    form.turno = newVal?.turno.id ?? null

    form.horarios = newVal?.horarios ?? null

    usuarioSeleccionado.value = newVal?.tutor
    carreraSeleccionada.value = newVal?.carrera
    aulaSeleccionada.value = newVal?.aula
    turnoSeleccionado.value = newVal?.turno
    periodoSeleccionado.value = newVal?.periodo ?? null
})
</script>
