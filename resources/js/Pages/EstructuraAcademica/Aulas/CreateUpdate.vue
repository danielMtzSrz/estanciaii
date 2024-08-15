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
                            label="Edificio"
                            :data="dataModal.dataEdificios"
                            textDropdown="nombre"
                            v-model="edificioSeleccionado"
                            :errors="form.errors.edificio_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Tipo de aula"
                            :data="dataModal.dataTiposAula"
                            textDropdown="nombre"
                            v-model="tipoAulaSeleccionado"
                            :errors="form.errors.tipo_aula_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Nombre"
                            v-model="form.nombre"
                            :errors="form.errors.nombre"
                        />
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <InputNumber
                            label="Capacidad"
                            :errors="form.errors.capacidad"
                            v-model="form.capacidad"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="field-checkbox">
                            <div class="flex align-items-end">
                                <Checkbox v-model="form.estatus" :binary="true"/>
                                <label>&nbsp;{{ form.estatus ? 'Activo' : 'Inactivo' }}</label>
                            </div>
                        </div>
                    </div>

                    <Schedules
                        v-model="form.horarios"
                        :errors="form.errors.horarios"
                    />

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
import Checkbox from 'primevue/checkbox'

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import Schedules from "@/Components/Forms/Schedules.vue";

// Variables
const edificioSeleccionado = ref(null), tipoAulaSeleccionado = ref(null)

const form = useForm({
    _method: null,
    edificio_id: null,
    tipo_aula_id: null,
    nombre: null,
    capacidad: null,
    estatus: null,
    horarios : {}
})

const ruta = ref(null), titulo = ref(null)

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
            edificio_id : edificioSeleccionado.value?.id ?? null,
            tipo_aula_id : tipoAulaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            edificio_id : edificioSeleccionado.value?.id ?? null,
            tipo_aula_id : tipoAulaSeleccionado.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'EstructuraAcademica.Aulas.store' : 'EstructuraAcademica.Aulas.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva aula' : 'Actualizar aula'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.edificio_id = newVal?.edificio_id ?? null
    form.tipo_aula_id = newVal?.tipo_aula_id ?? null
    form.nombre = newVal?.nombre ?? null
    form.capacidad = newVal?.capacidad ?? null
    form.estatus = (newVal?.estatus ? true : false)

    form.horarios = newVal?.horarios ?? null

    edificioSeleccionado.value = newVal?.edificio ?? null
    tipoAulaSeleccionado.value = newVal?.tipo_aula ?? null
})
</script>
