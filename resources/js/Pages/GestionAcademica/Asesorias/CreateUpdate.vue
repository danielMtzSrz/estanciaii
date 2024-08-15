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
                            label="Usuario"
                            :data="dataUsuarios"
                            imageDropdown="profile_photo_path"
                            textDropdown="nombre"
                            v-model="usuarioSeleccionado"
                            :errors="form.errors.user_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Materia"
                            :data="dataMaterias"
                            textDropdown="nombre"
                            v-model="materiaSeleccionada"
                            :errors="form.errors.materia_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <Textarea
                            label="Descripción"
                            v-model="form.descripcion"
                            :errors="form.errors.descripcion"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <Textarea
                            label="Ubicación"
                            v-model="form.ubicacion"
                            :errors="form.errors.ubicacion"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <CalendarTime
                            label="Hora de inicio"
                            name="hora_inicio"
                            icon="pi pi-clock"
                            :value="horaInicio"
                            :errors="form.errors.hora_inicio"
                            @input="form.hora_inicio = $event.valueFormat, horaInicio = $event.valueShow"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <CalendarTime
                            label="Hora de fin"
                            name="hora_fin"
                            icon="pi pi-clock"
                            :value="horaFin"
                            :errors="form.errors.hora_fin"
                            @input="form.hora_fin = $event.valueFormat, horaFin = $event.valueShow"
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
import Textarea from "@/Components/Forms/Textarea.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import CalendarTime from "@/Components/Forms/CalendarTime.vue";

// Variables
const dataMaterias = ref(null), dataUsuarios = ref(null)
const materiaSeleccionada = ref(null), usuarioSeleccionado = ref(null)
const horaInicio = ref(null), horaFin = ref(null)

const form = useForm({
    _method : null,
    materia_id : null,
    user_id : null,
    descripcion : null,
    ubicacion : null,
    hora_inicio : null,
    hora_fin : null
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
            materia_id : materiaSeleccionada.value?.id ?? null,
            user_id : usuarioSeleccionado.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            materia_id : materiaSeleccionada.value?.id ?? null,
            user_id : usuarioSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.Asesorias.store' : 'GestionAcademica.Asesorias.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva asesoria' : 'Actualizar asesoria'

    const dataUsuariosAxios = await axios.get(`/api/usuarios`);
    dataUsuarios.value = dataUsuariosAxios.data;

    const dataMateriasAxios = await axios.get(`/api/materias`);
    dataMaterias.value = dataMateriasAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.materia_id = newVal?.materia.id ?? null
    form.user_id = newVal?.user.id ?? null
    form.descripcion = newVal?.descripcion ?? null
    form.ubicacion = newVal?.ubicacion ?? null
    form.hora_inicio = newVal?.hora_inicio ?? null
    form.hora_fin = newVal?.hora_fin ?? null

    horaInicio.value = newVal?.hora_inicio
    horaFin.value = newVal?.hora_fin

    materiaSeleccionada.value = newVal?.materia
    usuarioSeleccionado.value = newVal?.user
})
</script>
