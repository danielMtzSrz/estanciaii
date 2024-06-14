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
                            label="Aula"
                            :data="dataAulas"
                            textDropdown="nombre"
                            v-model="aulaSeleccionada"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Día de la semana"
                            :data="dataDiasSemana"
                            textDropdown="nombre"
                            v-model="diaSemanaSeleccionado"
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

                <!-- <pre>{{ form }}</pre> -->

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
import CalendarTime from "@/Components/Forms/CalendarTime.vue";

// Variables
const dataAulas = ref(null), aulaSeleccionada = ref(null)
const dataDiasSemana = ref(null), diaSemanaSeleccionado = ref(null)

const horaInicio = ref(null), horaFin = ref(null)

const form = useForm({
    _method: null,
    aula_id: null,
    dia_semana_id: null,
    hora_inicio: null,
    hora_fin: null
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
            aula_id: aulaSeleccionada.value?.id ?? null,
            dia_semana_id: diaSemanaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            aula_id: aulaSeleccionada.value?.id ?? null,
            dia_semana_id: diaSemanaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'Calendarizaciones.Horarios.store' : 'Calendarizaciones.Horarios.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo horario' : 'Actualizar horario'

    const dataAulasAxios = await axios.get(`/api/aulas`);
    dataAulas.value = dataAulasAxios.data;

    dataDiasSemana.value = props.dataModal.dataDiasSemana;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.aula_id = newVal?.aula_id ?? null
    form.dia_semana_id = newVal?.dia_semana_id ?? null
    form.hora_inicio = newVal?.hora_inicio ?? null
    form.hora_fin = newVal?.hora_fin ?? null

    horaInicio.value = newVal?.hora_inicio ?? null
    horaFin.value = newVal?.hora_fin ?? null

    aulaSeleccionada.value = newVal?.aula ?? null
    diaSemanaSeleccionado.value = newVal?.dia_semana ?? null
})
</script>
