<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">
                    
                    <div class="col-sm-12 col-md-8">
                        <InputText
                            label="Nombre"
                            name="nombre"
                            :errors="form.errors.nombre_empresa"
                            v-model="form.nombre_empresa"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="RFC"
                            name="rfc"
                            :errors="form.errors.rfc"
                            v-model="form.rfc"
                        />
                    </div>

                     <div class="col-sm-12 col-md-12">
                        <Textarea
                            label="Razon Social"
                            name="razon_social"
                            :errors="form.errors.razon_social"
                            v-model="form.razon_social"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Países"
                            :data="data_paises"
                            textDropdown="nombre"
                            v-model="pais_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estados"
                            :data="data_estados"
                            textDropdown="nombre"
                            v-model="estado_seleccionado"
                            :disabled="!data_estados"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estados"
                            :data="data_municipios"
                            textDropdown="nombre"
                            v-model="municipio_seleccionado"
                            :disabled="!data_municipios"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Colonias"
                            :data="data_colonias"
                            textDropdown="nombre"
                            v-model="colonia_seleccionada"
                            :errors="form.errors.colonia_id"
                            :disabled="!data_colonias"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Calle"
                            name="calle"
                            v-model="form.calle"
                            :errors="form.errors.calle"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="N° Exterior"
                            name="numero_exterior"
                            v-model="form.numero_exterior"
                            :errors="form.errors.numero_exterior"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="N° Interior"
                            name="numero_interior"
                            v-model="form.numero_interior"
                            :errors="form.errors.numero_interior"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Código Postal"
                            name="codigo_postal"
                            v-model="form.codigo_postal"
                            :errors="form.errors.codigo_postal"
                        />
                    </div>

                    <div class="mt-4 col-md-12">
                        <FileUpload
                            dropText="Arrastre aquí el logo de la empresa."
                            :imagenActual="imagenActual"
                            v-model="form.imagen"
                            :errors="form.errors.imagen"
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
import Textarea from "@/Components/Forms/Textarea.vue";
import InputText from "@/Components/Forms/InputText.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";

// Variables
const data_paises = ref(null), pais_seleccionado = ref(null),
      data_estados = ref(null), estado_seleccionado = ref(null),
      data_municipios = ref(null), municipio_seleccionado = ref(null),
      data_colonias = ref(null), colonia_seleccionada = ref(null)

const imagenActual = ref(null)

const form = useForm({
    _method: null,
    colonia_id: null,
    calle: null,
    numero_exterior: null,
    numero_interior: null,
    codigo_postal: null,
    nombre_empresa: null,
    razon_social: null,
    rfc: null,
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
            colonia_id: colonia_seleccionada.value?.id
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            colonia_id: colonia_seleccionada.value?.id
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'empresas.store' : 'empresas.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva Empresa' : 'Actualizar Empresa'
    
    const { data } = await axios.get(`/api/domicilio/paises`);
    data_paises.value = data
    
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()
    
    form._method = newVal ? "put" : null

    form.colonia_id = newVal?.colonia_id ?? null
    form.calle = newVal?.calle ?? null
    form.numero_exterior = newVal?.numero_exterior ?? null
    form.numero_interior = newVal?.numero_interior ?? null
    form.codigo_postal = newVal?.codigo_postal ?? null
    form.nombre_empresa = newVal?.nombre_empresa ?? null
    form.razon_social = newVal?.razon_social ?? null
    form.rfc = newVal?.rfc ?? null
    imagenActual.value = newVal?.imagen ?? null
    form.imagen = newVal?.imagen ?? null

    pais_seleccionado.value = newVal?.colonia?.municipio?.estado?.pais
    estado_seleccionado.value = newVal?.colonia?.municipio?.estado
    municipio_seleccionado.value = newVal?.colonia?.municipio
    colonia_seleccionada.value = newVal?.colonia
})

watch(() => pais_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/estados/${newVal?.id}`)
    data_estados.value = data
})

watch(() => estado_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/municipios/${newVal?.id}`)
    data_municipios.value = data
})

watch(() => municipio_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/colonias/${newVal?.id}`)
    data_colonias.value = data
})

// Para obtener todo lo anterior a través de la colonia
// watch(() => form.codigo_postal, async (newVal) => {
//     if(form.codigo_postal.length === 5){
//         const { data } = await axios.get(`/api/domicilio/cp/${newVal}`)
//         console.log(data)
//     }
// })
</script>
