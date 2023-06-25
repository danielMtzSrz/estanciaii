<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataCarreras" label="Carrera" textDropdown="nombre"
                            :value="carrera" @input="form.carrera_id = $event.id, carrera = $event"
                            :errors="form.errors.carrera_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataAulas" label="Aula" textDropdown="nombre"
                            :value="aula" @input="form.aula_id = $event.id, aula = $event"
                            :errors="form.errors.aula_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataTutores" label="Tutor" textDropdown="name"
                            :value="tutor" @input="form.tutor_id = $event.id, tutor = $event"
                            :errors="form.errors.tutor_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <InputText label="Nombre" name="nombre" :errors="form.errors.nombre" :value="form.nombre"
                            @input="form.nombre = $event" />
                    </div>
                    <div class="col-md-6">
                        <label for="turno" class="flex ms-1">{{ form.turno ? 'Turno vespertino' : 'Turno matutino' }}</label>
                        <InputSwitch inputId="turno" v-model="form.turno" class="mt-3 ms-2" />
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
import Dropdown from '@/Components/Forms/Dropdown.vue';
import InputText from "@/Components/Forms/InputText.vue";
import InputSwitch from 'primevue/inputswitch';

import GenericModal from '@/Components/GenericModal.vue';

const carrera = ref(null)
const aula = ref(null)
const tutor = ref(null)

const form = useForm({
    carrera_id: null,
    aula_id: null,
    tutor_id: null,
    nombre: null,
    turno: null,
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
        form.transform((data) => ({
            ...data,
            turno: data.turno ? 1 : 0,
        })).post(route(ruta.value), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    } else {
        form.transform((data) => ({
            ...data,
            turno: data.turno ? 1 : 0,
        })).put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.Grupos.store' : 'EstructuraAcademica.Grupos.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo grupo' : 'Actualizar grupo'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    carrera.value = newVal?.carrera ?? null
    aula.value = newVal?.aula ?? null
    tutor.value = newVal?.tutor ?? null

    form.carrera_id = newVal?.carrera.id ?? null
    form.aula_id = newVal?.aula.id ?? null
    form.tutor_id = newVal?.tutor.id ?? null
    form.nombre = newVal?.nombre ?? null
    form.turno = (newVal?.turno ? true : false)
})
</script>

