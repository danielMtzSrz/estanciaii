<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()"
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit">
                <div class="row p-fluid">
                    <!-- Input name -->
                    <div class="col-md-12 mt-4">
                        <InputText 
                            label="Tipo de perodo"
                            name="name"
                            v-model="form.nombre"
                            :errors="form.errors.nombre"
                        />
                    </div>

                    <!-- Input description -->
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Descripción del periodo"
                            name="name"
                            v-model="form.contenido"
                            :errors="form.errors.contenido"
                        />
                    </div>
                </div>
                <div class="float-end space-x-2 mt-3">
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
import { ref, watch } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import GenericModal from '@/Components/GenericModal.vue';

const form = useForm({
    id: null,
    nombre: null,
    contenido: null
})

const ruta = ref(null)
const titulo = ref(null)

const props = defineProps({
    dataModal: {
        type: Object,
        default: null
    },
})

const emits = defineEmits(['closeModal', 'success'])

const closeModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
                emits('success')
            },
        });
    }else{
        form.put(route(ruta.value, props.dataModal?.dataRegistro?._id), {
            onSuccess: () => {
                closeModal();
                emits('success')
            },
        });
    }
}

watch(() => props.dataModal, (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'Calendarizaciones.TiposPeriodos.store' : 'Calendarizaciones.TiposPeriodos.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo tipo de periodo' : 'Actualizar tipo de periodo'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset();

    form.id = newVal?.id ?? null
    form.nombre = newVal?.nombre ?? null
    form.contenido = newVal?.contenido ?? null
})
</script>

