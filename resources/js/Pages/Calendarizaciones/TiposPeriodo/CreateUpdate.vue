<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">

                    <div class="col-sm-12">
                        <InputText
                            label="Nombre"
                            v-model="form.nombre"
                            :errors="form.errors.nombre"
                        />
                    </div>

                    <div class="col-sm-12">
                        <Textarea
                            label="Descripción"
                            v-model="form.descripcion"
                            :errors="form.errors.descripcion"
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
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";

const form = useForm({
    _method: null,
    nombre: null,
    descripcion: null
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
        form.post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'Calendarizaciones.TiposPeriodo.store' : 'Calendarizaciones.TiposPeriodo.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo tipo de periodo' : 'Actualizar tipo de periodo'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.nombre = newVal?.nombre ?? null
    form.descripcion = newVal?.descripcion ?? null
})
</script>
