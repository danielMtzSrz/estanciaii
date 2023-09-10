<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataEdificios" label="Edificio" textDropdown="nombre"
                            :value="edificio" @input="form.edificio_id = $event.id, edificio = $event"
                            :errors="form.errors.edificio_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Dropdown :data="dataModal.dataTiposAulas" label="Tipo de aula" textDropdown="nombre"
                            :value="tipoAula" @input="form.tipo_aula_id = $event.id, tipoAula = $event"
                            :errors="form.errors.tipo_aula_id" />
                    </div>
                    <div class="mt-4 col-md-12">
                        <InputText label="Nombre" name="nombre" :errors="form.errors.nombre" :value="form.nombre"
                            @input="form.nombre = $event" />
                    </div>
                    <div class="mt-5 col-md-6">
                        <span class="p-float-label">
                            <InputNumber inputId="capacidad" v-model="form.capacidad" mode="decimal" showButtons
                                :min="1" :max="50" :class="{ 'p-invalid': form.errors.capacidad }" />
                            <label for="capacidad">Capacidad</label>
                        </span>
                        <small class="p-error" v-if="form.errors.capacidad">
                            {{ form.errors.capacidad }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <label for="estatus" class="flex ms-1">Estatus</label>
                        <InputSwitch inputId="estatus" v-model="form.estatus"
                            class="mt-3 ms-2" />
                    </div>
                </div>
                <div class="float-end space-x-2">
                    <Button type="button" label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="closeModal()" />
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
import InputNumber from 'primevue/inputnumber';
import InputSwitch from 'primevue/inputswitch';
import Checkbox from 'primevue/checkbox';

import GenericModal from '@/Components/GenericModal.vue';

const edificio = ref(null)
const tipoAula = ref(null)

const form = useForm({
    edificio_id: null,
    tipo_aula_id: null,
    nombre: null,
    estatus: null,
    capacidad: null
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

const closeModal = () => {
    emits("visible", false);
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if (!props.dataModal.dataRegistro) {
        form.transform((data) => ({
            ...data,
            estatus: data.estatus ? 1 : 0,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        form.transform((data) => ({
            ...data,
            estatus: data.estatus ? 1 : 0,
        })).put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'EstructuraAcademica.Aulas.store' : 'EstructuraAcademica.Aulas.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nueva aula' : 'Actualizar aula'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    edificio.value = newVal?.edificio ?? null
    tipoAula.value = newVal?.tipo_aula ?? null

    form.edificio_id = newVal?.edificio.id ?? null
    form.tipo_aula_id = newVal?.tipo_aula.id ?? null
    form.nombre = newVal?.nombre ?? null
    form.estatus = (newVal?.estatus ? true : false)
    form.capacidad = newVal?.capacidad ?? null
})
</script>

