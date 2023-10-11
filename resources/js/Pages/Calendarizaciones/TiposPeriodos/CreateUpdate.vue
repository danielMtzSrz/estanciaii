<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :header="titulo">
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid pt-4">
                    <!-- Input name -->
                    <div class="col-md-12">
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
                            v-model="form.descripcion"
                            :errors="form.errors.descripcion"
                        />
                    </div>
                    <!-- Fin input description -->
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
import { ref, watch } from 'vue';
// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Tooltip from "primevue/tooltip";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import ColorPicker from 'primevue/colorpicker';

import GenericModal from '@/Components/GenericModal.vue';

const loading = ref(null)
const display = ref(null)
const form = useForm({
    nombre: "",
    descripcion: "",
    color: "255599"
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
}
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.transform((data) => ({
            ...data,
            color: "#"+data.color.toUpperCase(),
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    }else{
        form.transform((data) => ({
            ...data,
            color: data.color.includes("#") ? data.color.toUpperCase() : "#"+data.color.toUpperCase(),
        })).put(route(ruta.value, props.dataModal?.dataRegistro?._id), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    form.reset();
        
    ruta.value = !props.dataModal.dataRegistro ? 'Calendarizaciones.TiposPeriodos.store' : 'Calendarizaciones.TiposPeriodos.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo tipo de periodo' : 'Actualizar tipo de periodo'

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    form.nombre = newVal.dataRegistro?.nombre ?? ""
    form.descripcion = newVal.dataRegistro?.descripcion ?? ""
    form.color = newVal.dataRegistro?.color ?? ""
})
</script>
