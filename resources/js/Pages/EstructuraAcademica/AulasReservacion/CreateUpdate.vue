<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid mb-3">
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataAulas" label="Aula" textDropdown="nombre" :value="aula"
                            @input="form.aula_id = $event.id, aula = $event" :errors="form.errors.aula_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataSolicitantes" label="Solicitante" textDropdown="name"
                            :value="solicitante" @input="form.solicitante_id = $event.id, solicitante = $event"
                            :errors="form.errors.solicitante_id" />
                    </div>
                    <div class="mt-4 col-md-6">
                        <Calendar label="Horario inicio" name="horario_inicio" icon="pi pi-calendar"
                            :value="horarioInicio" :errors="form.errors.horario_inicio"
                            @input="form.horario_inicio = $event.valueFormat, horarioInicio = $event.valueShow" />
                    </div>
                    <div class="mt-4 col-md-6">
                        <Calendar label="Horario fin" name="horario_final" icon="pi pi-calendar" :value="horarioFinal"
                            :errors="form.errors.horario_final"
                            @input="form.horario_final = $event.valueFormat, horarioFinal = $event.valueShow" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <InputText label="Asunto" name="asunto" :errors="form.errors.asunto" :value="form.asunto"
                            @input="form.asunto = $event" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Descripción"
                            name="descripcion"
                            :errors="form.errors.descripcion"
                            :value="form.descripcion"
                            @input="form.descripcion = $event"
                        />
                    </div>
                </div>
                <div class="float-end space-x-2">
                    <Button type="button" label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="cerrarModal()" />
                    <Button type="submit" label="Guardar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="form.processing" />
                </div>
            </form>
        </template>
    </GenericModal>
</template>

<script setup>

import { ref, watch } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Inputs
import Dropdown from '@/Assets/Components/Forms/Dropdown.vue';
import InputText from "@/Assets/Components/Forms/InputText.vue";
import Calendar from '@/Assets/Components/Forms/Calendar.vue';
import Textarea from "@/Assets/Components/Forms/Textarea.vue";

import GenericModal from '@/Assets/Components/GenericModal.vue';

const aula = ref(null)
const solicitante = ref(null)
const horarioInicio = ref(null)
const horarioFinal = ref(null)

const form = useForm({
    aula_id: null,
    solicitante_id: null,
    horario_inicio: null,
    horario_final: null,
    asunto: null,
    descripcion: null
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
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.AulasReservacion.store' : 'EstructuraAcademica.AulasReservacion.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nueva reservacion de aula' : 'Actualizar reservacion de aula'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    aula.value = newVal?.aula ?? null
    solicitante.value = newVal?.solicitante ?? null
    horarioInicio.value = newVal?.horarioInicio ?? null
    horarioFinal.value = newVal?.horarioFinal ?? null

    form.aula_id = newVal?.aula.id ?? null
    form.solicitante_id = newVal?.solicitante.id ?? null
    form.horario_inicio = newVal?.horario_inicio ?? null
    form.horario_final = newVal?.horario_final ?? null
    form.asunto = newVal?.asunto ?? null
    form.descripcion = newVal?.descripcion ?? null
})
</script>

