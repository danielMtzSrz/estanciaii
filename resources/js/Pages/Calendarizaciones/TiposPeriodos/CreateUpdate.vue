<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <!-- Input name -->
                    <div class="mt-4 col-md-6">
                        <InputText 
                            label="Tipo de perodo"
                            name="name"
                            :errors="form.errors.nombre"
                            :value="form.nombre"
                            @input="form.nombre = $event"
                        />
                    </div>
                    <!-- Fin input name -->
                    <div class="mt-4 col-md-3">
                        <label>Color:&nbsp;<span>{{ form.color.toUpperCase() }}</span>&nbsp;</label>
                        <ColorPicker
                            v-model="form.color"
                            
                        />
                    </div>
                    <!-- Input description -->
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Descripción del periodo"
                            name="name"
                            :errors="form.errors.descripcion"
                            :value="form.descripcion"
                            @input="form.descripcion = $event"
                        />
                    </div>
                    <!-- Fin input description -->
                </div>
                <div class="float-end space-x-2 mt-3">
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
import { ref, watch } from 'vue';
// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Tooltip from "primevue/tooltip";

// Inputs
import InputText from "@/Assets/Components/Forms/InputText.vue";
import Textarea from "@/Assets/Components/Forms/Textarea.vue";
import ColorPicker from 'primevue/colorpicker';

import GenericModal from '@/Assets/Components/GenericModal.vue';

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

const cerrarModal = () => {
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
                cerrarModal();
            },
        });
    }else{
        form.transform((data) => ({
            ...data,
            color: data.color.includes("#") ? data.color.toUpperCase() : "#"+data.color.toUpperCase(),
        })).put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
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
