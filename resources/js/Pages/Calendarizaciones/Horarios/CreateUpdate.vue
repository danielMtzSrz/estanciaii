<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-2 col-md-6">
                        <Dropdown 
                            :data="dataModal.dataAulas"
                            icon="bi bi-building"
                            label="Aula"
                            textDropdown="nombre"
                            :value="aula"
                            @input="form.aula_id = $event.id, aula=$event"
                            :errors="form.errors.aula_id"
                        />
                    </div>
                    <div class="mt-2 col-md-6">
                        <Dropdown 
                            :data="dataModal.dataDiasSemana"
                            icon="bi bi-calendar-week"
                            label="Día"
                            textDropdown="nombre"
                            :value="diaSemana"
                            @input="form.dia_semana_id = $event.id, diaSemana=$event"
                            :errors="form.errors.dia_semana_id"
                        />
                    </div>
                    <div class="mt-4 col-md-6">
                        <Calendar
                            label="Hora de inicio"
                            name="hora_inicio"
                            icon="pi pi-clock"
                            :value="horaInicio"
                            :errors="form.errors.hora_inicio"
                            @input="form.hora_inicio = $event.valueFormat, horaInicio = $event.valueShow"
                        />
                    </div>
                    <div class="mt-4 col-md-6">
                        <Calendar
                            label="Hora de fin"
                            name="hora_fin"
                            icon="pi pi-clock"
                            :value="horaFin"
                            :errors="form.errors.hora_fin"
                            @input="form.hora_fin = $event.valueFormat, horaFin = $event.valueShow"
                        />
                    </div>
                </div>
                <div class="mt-3 float-end space-x-2">
                    <Button
                        type="button"
                        label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="cerrarModal()"
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

import { ref, watch, computed } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import ColorPicker from 'primevue/colorpicker';
import Checkbox from 'primevue/checkbox';

// Inputs
import InputText from "@/Assets/Components/Forms/InputText.vue";
import Textarea from "@/Assets/Components/Forms/Textarea.vue";
import Dropdown from '@/Assets/Components/Forms/Dropdown.vue';
import Calendar from '@/Components/Forms/CalendarTime.vue';
import Divider from 'primevue/divider';

import GenericModal from '@/Assets/Components/GenericModal.vue';

const aula = ref(null)
const diaSemana = ref(null)
const horaInicio = ref(null)
const horaFin = ref(null)

const form = useForm({
    aula_id : null,
    dia_semana_id: null,
    hora_inicio : null,
    hora_fin: null,
})

const ruta = ref(null)
const titulo = ref(null)

const props = defineProps({
    dataModal: {
        type: Object,
        default: null
    },
})

const emits = defineEmits(['visible'])

const cerrarModal = () => {
    emits("visible", false);
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.post(route(ruta.value), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }else{
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'Calendarizaciones.Horarios.store' : 'Calendarizaciones.Horarios.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo horario' : 'Actualizar horario'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    horaInicio.value = newVal?.hora_inicio ?? null
    horaFin.value = newVal?.hora_fin ?? null
    
    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    aula.value = newVal?.aula ?? null
    diaSemana.value = newVal?.diaSemana ?? null

    // form.aula_id = newVal?.aula.id ?? null
    form.aula_id = newVal?.aula.id ?? null
    form.dia_semana_id = newVal?.diaSemana.id ?? null
    form.hora_inicio = newVal?.hora_inicio ?? null
    form.hora_fin = newVal?.hora_fin ?? null
})
</script>

