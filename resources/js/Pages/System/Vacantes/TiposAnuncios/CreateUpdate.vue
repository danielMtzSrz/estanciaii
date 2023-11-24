<template>
    <GenericModal 
        :dataModal="dataModal" 
        :header="titulo"
        @closeModal="closeModal()" 
    >
        <template #content>
            <form @submit.prevent="submit()">
                <div class="row p-fluid pt-4">
                    
                    <div class="col-sm-12">
                        <Dropdown 
                            label="Empresas"
                            :data="dataEmpresas"
                            imageDropdown="imagen"
                            textDropdown="nombre_empresa"
                            v-model="empresaSeleccionada"
                        />
                    </div>

                    <div class="col-sm-12">
                        <InputText 
                            label="Título del anuncio"
                            v-model="form.titulo"
                            :errors="form.errors.titulo"
                        />
                    </div>
                    <div class="col-sm-12">
                        <Textarea 
                            label="Contenido"
                            v-model="form.contenido"
                            :errors="form.errors.contenido"
                        />
                    </div>

                    <div class="mt-4 col-md-12">
                        <FileUpload
                            dropText="Arrastre aquí la imagen del anuncio."
                            :imagenActual="imagenActual"
                            v-model="form.imagen"
                            :errors="form.errors.imagen"
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

import { ref, watch } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";

import GenericModal from '@/Components/GenericModal.vue';

// Variables
const dataEmpresas = ref(null), empresaSeleccionada = ref(null)

const imagenActual = ref(null)

const form = useForm({
    empresaasociada_id : null,
    titulo : null,
    contenido : null,
    imagen : null
})

const ruta = ref(null), titulo = ref(null)

const props = defineProps({
    dataModal: {
        type: Object,
        default: null
    },
})

const emits = defineEmits(['closeModal'])

const closeModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.transform((data) => ({
            ...data,
            empresaasociada_id: empresaSeleccionada.value?.id
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    }else{
        form.transform((data) => ({
            ...data,
            empresaasociada_id: empresaSeleccionada.value?.id
        })).put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
}

watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'tiposanuncios.store' : 'tiposanuncios.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo tipo de anuncio' : 'Actualizar tipo de anuncio'

    const { data } = await axios.get(`/api/empresas`);
    dataEmpresas.value = data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset();

    form.empresaasociada_id = newVal?.empresaasociada_id ?? null
    form.titulo = newVal?.titulo ?? null
    form.contenido = newVal?.contenido ?? null
    form.imagen = newVal?.imagen ?? null
    imagenActual.value = newVal?.imagen ?? null
})
</script>

