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
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Estados"
                            :data="dataEstados"
                            textDropdown="nombre"
                            v-model="estadoSeleccionado"
                            :disabled="!dataEstados"
                            :errors="form.errors.estado_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-12">
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

const { obtenerPaises, obtenerEstados } = useAddressStore()

// Variables
const dataPaises = ref(null), paisSeleccionado = ref(null),
      dataEstados = ref(null), estadoSeleccionado = ref(null)

const form = useForm({
    _method: null,
    estado_id: null,
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
            estado_id: estadoSeleccionado?.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    } else {
        form.transform((data) => ({
            ...data,
            estado_id: estadoSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'municipios.store' : 'municipios.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo Municipio' : 'Actualizar Municipio'

    await obtenerPaises()
    dataPaises.value = useAddressStore().paisesData
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()
    
    form._method = newVal ? "put" : null

    paisSeleccionado.value = newVal?.pais ?? null
    estadoSeleccionado.value = newVal?.estado ?? null
    form.nombre = newVal?.nombre ?? null
})

watch(() => paisSeleccionado.value, async (newVal) => {
    await obtenerEstados(newVal?.id)
    dataEstados.value = useAddressStore().estadosData
})
</script>
