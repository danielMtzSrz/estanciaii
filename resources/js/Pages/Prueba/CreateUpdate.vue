<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Descripción"
                            name="descripcion"
                            :errors="form.errors.descripcion"
                            v-model="form.descripcion"
                        />
                    </div>

                    <!-- <div class="col-sm-12 col-md-12">
                        <Textarea
                            label="Razon Social"
                            name="razon_social"
                            :errors="form.errors.razon_social"
                            v-model="form.razon_social"
                        />
                    </div> -->

                    <!-- <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Países"
                            :data="data_paises"
                            textDropdown="nombre"
                            v-model="pais_seleccionado"
                        />
                    </div> -->

                    <!-- <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="N° Exterior"
                            name="numero_exterior"
                            v-model="form.numero_exterior"
                            :errors="form.errors.numero_exterior"
                            :useGrouping="false"
                        />
                    </div> -->

                    <div class="mt-4 col-md-12">
                        <FileUpload
                            dropText="Arrastre aquí la imagen."
                            :imagenActual="imagenActual"
                            v-model="form.imagen"
                            :errors="form.errors.imagen"
                        />
                    </div>
                </div>

                <pre>{{ form }}</pre>

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
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";

// Variables
const data_paises = ref(null), pais_seleccionado = ref(null)

const imagenActual = ref(null)

const form = useForm({
    _method: null,
    descripcion: null,
    imagen: null
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

const cargarArchivo = (event) => {
    form.imagen = event.target.files[0];
}

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
            // colonia_id: colonia_seleccionada.value?.id
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.post(route(ruta.value, props.dataModal?.dataRegistro?._id), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'prueba.store' : 'prueba.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva Prueba' : 'Actualizar Prueba'

    console.log(props.dataModal?.dataRegistro)

    // const { data } = await axios.get(`/api/domicilio/paises`);
    // data_paises.value = data
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()
    
    form._method = newVal ? "put" : null

    form.descripcion = newVal?.descripcion ?? null
    imagenActual.value = newVal?.imagen ?? null
    form.imagen = newVal?.imagen ?? null

    // pais_seleccionado.value = newVal?.colonia?.municipio?.estado?.pais
})

// watch(() => pais_seleccionado.value, async (newVal) => {
//     const { data } = await axios.get(`/api/domicilio/estados/${newVal?.id}`)
//     data_estados.value = data
// })
</script>
