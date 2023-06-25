<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-4 col-md-12">
                        <InputText label="Nombre" name="nombre" icon="pi pi-align-center" :errors="form.errors.nombre" :value="form.nombre"
                            @input="form.nombre = $event" />
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
import InputText from "@/Components/Forms/InputText.vue";

import GenericModal from '@/Components/GenericModal.vue';

const form = useForm({
    nombre: null
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
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.Edificios.store' : 'EstructuraAcademica.Edificios.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo edificio' : 'Actualizar edificio'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    form.nombre = newVal?.nombre ?? null
})
</script>

