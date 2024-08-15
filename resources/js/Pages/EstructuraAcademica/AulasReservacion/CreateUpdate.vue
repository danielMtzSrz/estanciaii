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
                            label="Solicitante"
                            :data="dataUsuarios"
                            textDropdown="nombre"
                            imageDropdown="profile_photo_path"
                            v-model="usuarioSeleccionado"
                            :errors="form.errors.aula_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Aula"
                            :data="dataAulas"
                            textDropdown="nombre"
                            v-model="aulaSeleccionada"
                            :errors="form.errors.solicitante_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Calendar 
                            label="Horario inicio"
                            icon="pi pi-calendar"
                            v-model="form.horario_inicio"
                            :errors="form.errors.horario_inicio"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Calendar 
                            label="Horario inicio"
                            icon="pi pi-calendar"
                            v-model="form.horario_final"
                            :errors="form.errors.horario_final"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <InputText
                            label="Asunto"
                            v-model="form.asunto"
                            :errors="form.errors.asunto"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <Textarea
                            label="Nombre"
                            v-model="form.descripcion"
                            :errors="form.errors.descripcion"
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
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import Calendar from "@/Components/Forms/Calendar.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";

// Variables
const usuarioSeleccionado = ref(null), aulaSeleccionada = ref(null)
const dataAulas = ref(null), dataUsuarios = ref(null)
const horarioInicio = ref(null), horarioFinal = ref(null)

const form = useForm({
    _method : null,
    aula_id : null,
    solicitante_id : null,
    horario_inicio : null,
    horario_final : null,
    asunto : null,
    descripcion : null
});

const ruta = ref(null),
      titulo = ref(null);

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
            solicitante_id :  usuarioSeleccionado.value?.id ?? null,
            aula_id : aulaSeleccionada.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            solicitante_id : usuarioSeleccionado.value?.id ?? null,
            aula_id : aulaSeleccionada.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.AulasReservacion.store' : 'EstructuraAcademica.AulasReservacion.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva reservación de aula' : 'Actualizar reservación de aula'

    const dataUsuariosAxios = await axios.get(`/api/usuarios`);
    dataUsuarios.value = dataUsuariosAxios.data;

    const dataAulasAxios = await axios.get(`/api/aulas`);
    dataAulas.value = dataAulasAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.aula_id = newVal?.aula?.id ?? null
    form.solicitante_id = newVal?.solicitante?.id ?? null
    form.horario_inicio = newVal?.horario_inicio ?? null
    form.horario_final = newVal?.horario_final ?? null
    form.asunto = newVal?.asunto ?? null
    form.descripcion = newVal?.descripcion ?? null

    usuarioSeleccionado.value = newVal?.solicitante ?? null
    aulaSeleccionada.value = newVal?.aula ?? null

    horarioInicio.value = newVal?.horario_inicio
    horarioFinal.value = newVal?.horario_final
})
</script>
