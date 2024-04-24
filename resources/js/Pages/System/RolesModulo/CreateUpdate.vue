<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()"
        :header="titulo"
        :style="{ width: '75vw' }"
    >
        <template #content>
            <form @submit.prevent="submit">
                <div class="row p-fluid">
                    <div class="mt-4 col-md-6">
                        <InputText 
                            label="Nombre"
                            icon="bi bi-search"
                            :errors="form.errors.name"
                            v-model="form.name"
                        />
                    </div>

                    <div class="col-sm-12">
                        <Divider align="left">
                            <div class="inline-flex align-items-center">
                                <i class="pi pi-globe mr-2"></i>
                                Seleccionar permisos
                            </div>
                        </Divider>
                        <div class="flex flex-row-reverse flex-wrap card-container yellow-container mb-4">
                            <div class="flex align-items-center justify-content-center w-20rem">
                                <InputText
                                    label="Buscador"
                                    v-model="buscador"
                                />
                            </div>
                        </div>

                        <DataView :value="data_permisosAll" layout="grid" :paginator="true" :rows="24" :rowsPerPageOptions="[8, 12, 20, 24, 40]">
                            <template #grid="slotProps">
                                <div class="col-12 md:col-3">
                                    <div class="field-checkbox d-flex mb-5 mx-3">
                                        <Checkbox
                                            name="permissions[]"
                                            :value="slotProps.data.id"
                                            v-model="form.permissions"
                                            class="mr-2"
                                            :checked="true"
                                        />
                                        <label>{{ slotProps.data.description}}</label>
                                    </div>
                                </div>
                            </template>
                        </DataView>
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

import { computed, ref, watch } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Divider from 'primevue/divider';
import Checkbox from 'primevue/checkbox';
import DataView from 'primevue/dataview'

// Inputs
import InputText from "@/Components/Forms/InputText.vue";

import GenericModal from '@/Components/GenericModal.vue';

const form = useForm({
    id: null,
    name: null,
    permissions: [],
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
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
                emits('success')
            },
        });
    }
}
const buscador = ref(null)
const data_permisosAll = computed(() => {
    return buscador.value 
        ? props.dataModal?.data_permisos.filter(el => el.description.toLowerCase().indexOf(buscador.value.toLowerCase()) >= 0)
        : props.dataModal?.data_permisos
})

watch(() => props.dataModal, (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'role.store' : 'role.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo permiso' : 'Actualizar permiso'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset();

    form.id = newVal?.id ?? null
    form.name = newVal?.name ?? null
    props.dataModal.data_permisos.forEach(permiso => {
        props.dataModal?.dataRegistro?.permisos.find(el => el.id == permiso.id) && form.permissions.push(permiso.id)
    })
})
</script>

