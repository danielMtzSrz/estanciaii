<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :header="titulo">
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <!-- Input name -->
                    <div class="mt-4 col-md-12">
                        <InputText 
                            label="Tipo de convocatoria"
                            name="nombre"
                            :errors="form.errors.nombre"
                            v-model="form.nombre"
                        />
                    </div>
                    <!-- Fin input name -->
                    <!-- Input description -->
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Plantilla"
                            name="plantilla"
                            :errors="form.errors.plantilla"
                            v-model="form.plantilla"
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
    nombre: null,
    plantilla: null,
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
        form.post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    }else{
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    form.reset();
        
    ruta.value = !props.dataModal.dataRegistro ? 'Calendarizaciones.TipoConv.store' : 'Calendarizaciones.TipoConv.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo tipo de convocatoria' : 'Actualizar tipo de convocatoria'

    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    form.nombre = newVal.dataRegistro?.nombre ?? ""
    form.plantilla = newVal.dataRegistro?.plantilla ?? ""
})
</script>
