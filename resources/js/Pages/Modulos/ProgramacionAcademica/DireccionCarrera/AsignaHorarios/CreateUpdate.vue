<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="field col-6">
                        <Dropdown label="Aula" :data="dataModal.dataAulas" :value="aula" textDropdown="nombre"
                            :errors="form.errors.aula_id" @input="form.aula_id = $event.id, aula = $event">
                        </Dropdown>
                    </div>
                    <div class="field col-6">
                        <Dropdown label="Día de la semana" :data="dataModal.dataDiasSemana" :value="diaSemana"
                            textDropdown="nombre" :errors="form.errors.dia_semana_id"
                            @input="form.dia_semana_id = $event.id, diaSemana = $event">
                        </Dropdown>
                    </div>
                    <div class="field md:col-6 sm:col-12 inline-block">
                        <CalendarTime label="Hora Inicio" icon="pi pi-clock" name="hora_inicio" :value="horaInicio"
                            :errors="form.errors.hora_inicio"
                            @input="form.hora_inicio = $event.valueFormat, horaInicio = $event.valueShow" />
                    </div>
                    <div class="field md:col-6 sm:col-12 inline-block">
                        <CalendarTime label="Hora Fin" icon="pi pi-clock" name="hora_fin" :value="horaFin"
                            :errors="form.errors.hora_fin"
                            @input="form.hora_fin = $event.valueFormat, horaFin = $event.valueShow" />
                    </div>
                </div>
                <div class="float-end space-x-2">
                    <Button type="button" label="Cancelar" class="p-button-raised p-button-rounded p-button-warning"
                        @click="cerrarModal()" />
                    <Button type="submit" label="Guardar" icon="pi pi-save"
                        class="p-button-raised p-button-rounded p-button-success" :loading="form.processing" />
                </div>
            </form>
        </template>
    </GenericModal>
</template>

<script setup>

import { ref, watch } from 'vue';
import { useForm } from "@inertiajs/inertia-vue3";
import Button from "primevue/button";
import CalendarTime from '@/Assets/Components/Forms/CalendarTime.vue'
import Dropdown from '@/Assets/Components/Forms/Dropdown.vue';
import GenericModal from '@/Assets/Components/GenericModal.vue';

const aula = ref(null)
const diaSemana = ref(null)
const horaFin = ref(null)
const horaInicio = ref(null)

const form = useForm({
    aula_id: null,
    dia_semana_id: null,
    hora_inicio: '17:20',
    hora_fin: '19:00',
    grupo_materia_id: null,
    horario_grupo_materia_id: null
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
    if (!props.dataModal.dataRegistro) {
        form.post(route(ruta.value), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    } else {
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'ProgramacionAcademica.DireccionCarrera.AsignaHorarios.store' : 'ProgramacionAcademica.DireccionCarrera.AsignaHorarios.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo horario' : 'Actualizar horario'
    form.grupo_materia_id = newVal?.dataRegistroParent?.grupo_materia_id ?? null
    form.horario_grupo_materia_id = newVal?.dataRegistroParent?.horario_grupo_materia_id ?? null
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    aula.value = newVal?.horario.aula ?? null
    diaSemana.value = newVal?.horario.dia_semana ?? null
    horaFin.value = newVal?.horario.hora_fin ?? null
    horaInicio.value = newVal?.horario.hora_inicio ?? null


    form.aula_id = newVal?.horario.aula_id ?? null
    form.dia_semana_id = newVal?.horario.dia_semana_id ?? null
    form.hora_inicio = newVal?.horario.hora_inicio ?? null
    form.hora_fin = newVal?.horario.hora_fin ?? null

})
</script>


