<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">
                    
                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Países"
                            :data="dataPaises"
                            textDropdown="nombre"
                            v-model="paisSeleccionado"
                            :errors="form.errors.pais_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Estado"
                            name="nombre"
                            :errors="form.errors.nombre"
                            v-model="form.nombre"
                        />
                    </div>
                </div>

                <div class="float-end space-x-2 py-4">
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
import { ref, watch } from "vue";

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import Dropdown from "@/Components/Forms/Dropdown.vue";
import InputText from "@/Components/Forms/InputText.vue";

// Pinia
import { useAddressStore } from '@/store/adress';

const { obtenerPaises } = useAddressStore()

// Variables
const dataPaises = ref(null), paisSeleccionado = ref(null)

const form = useForm({
    _method: null,
    pais_id: null,
    nombre: null
});

const ruta = ref(null),
      titulo = ref(null);

// Props
const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

// Emits
const emits = defineEmits(["closeModal"]);

// Methods
const closeModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
};

const submit = () => {

    if (!props.dataModal.dataRegistro) {
        form.transform((data) => ({
            ...data,
            pais_id: paisSeleccionado?.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        form.transform((data) => ({
            ...data,
            pais_id: paisSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'estados.store' : 'estados.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo Estado' : 'Actualizar Estado'

    await obtenerPaises()
    dataPaises.value = useAddressStore().paisesData
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()
    
    form._method = newVal ? "put" : null

    paisSeleccionado.value = newVal?.pais ?? null
    form.nombre = newVal?.nombre ?? null
})
</script>
