<template>
    <GenericModal 
        :dataModal="dataModal" 
        :header="titulo"
        @closeModal="closeModal()" 
    >
        <template #content>
            <form @submit.prevent="submit()">
                <div class="row p-fluid pt-4">
                    <div class="col-md-6">
                        <InputText 
                            label="Nombre del módulo"
                            v-model="form.module_name"
                            :errors="form.errors.module_name"
                        />
                    </div>
                    <div class="col-md-6">
                        <InputText 
                            label="Nombre"
                            v-model="form.name"
                            :errors="form.errors.name"
                        />
                    </div>
                    <div class="col-md-12">
                        <Textarea 
                            label="Descripción"
                            v-model="form.description"
                            :errors="form.errors.description"
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

import GenericModal from '@/Components/GenericModal.vue';

const form = useForm({
    id: null,
    module_name: null,
    name: null,
    description: null
})

const ruta = ref(null),
      titulo = ref(null)

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

watch(() => props.dataModal, (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'permission.store' : 'permission.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo permiso' : 'Actualizar permiso'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset();

    form.id = newVal?.id ?? null
    form.module_name = newVal?.module_name ?? null
    form.name = newVal?.name ?? null
    form.description = newVal?.description ?? null
})
</script>

