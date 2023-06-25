<template>
    <GenericModal
        :dataModal="dataModal"
        @cerrarModal="cerrarModal"
        :title="titulo"
    >
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="row">
                            <!-- Input Nombre -->
                            <div class="mt-4 col-12">
                                <InputText
                                    label="Nombre"
                                    name="nombre"
                                    :errors="form.errors.nombre"
                                    :value="form.nombre"
                                    @input="form.nombre = $event"
                                />
                            </div>
                            <!-- Input Razon Social -->
                            <div class="col--12">
                                <InputText
                                    label="Razon Social"
                                    name="razon_social"
                                    :errors="form.errors.razon_social"
                                    :value="form.razon_social"
                                    @input="form.razon_social = $event"
                                />
                            </div>
                            <!-- Input RFC -->
                            <div class="m-auto col-12 w-75">
                                <InputText
                                    label="RFC"
                                    name="rfc"
                                    :errors="form.errors.rfc"
                                    :value="form.rfc"
                                    @input="form.rfc = $event"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="row">
                            <!-- Input Domicilio -->
                            <InputColonia
                                class="col-12"
                                :data="
                                    props.dataModal?.dataRegistro?.domicilio
                                        ?.colonia
                                "
                                @seleccionado="colonia = $event"
                            />
                        </div>
                    </div>
                    <div class="row ml-1">
                        <div class="m-auto col-12">
                            <InputText
                                label="Calle"
                                name="calle"
                                :errors="form.errors.calle"
                                :value="form.calle"
                                @input="form.calle = $event"
                            />
                        </div>
                        <div class="col-6 col-sm-12">
                            <InputNumber
                                label="Numero Exterior"
                                name="numero_interior"
                                :errors="form.errors.numero_exterior"
                                :value="form.numero_exterior"
                                @input="form.numero_exterior = $event"
                            />
                        </div>
                        <div class="col-6 col-sm-12">
                            <InputNumber
                                label="Numero Interior"
                                name="numero_interior"
                                :errors="form.errors.numero_interior"
                                :value="form.numero_interior"
                                @input="form.numero_interior = $event"
                            />
                        </div>
                    </div>
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
import { ref, watch } from "vue";
// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Tooltip from "primevue/tooltip";

import GenericModal from "@/Components/GenericModal.vue";
// Inputs
import InputColonia from "@/Components/Forms/InputColonia.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import InputText from "@/Components/Forms/InputText.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";

const loading = ref(null);
const display = ref(null);
const colonia = ref();
const form = useForm({
    nombre: "",
    razon_social: "",
    rfc: "",
    colonia: "",
    calle: "",
    numero_exterior: null,
    numero_interior: null,
});
const ruta = ref(null);
const titulo = ref(null);

const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

const emits = defineEmits(["visible"]);

const cerrarModal = () => {
    emits("visible", false);
    form.reset();
};
const submit = () => {
    if (!props.dataModal.dataRegistro) {
        form.post(route(ruta.value), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    } else {
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
};

watch(colonia, (newVal) => {
    form.colonia = newVal.id;
});

watch(
    () => props.dataModal,
    (newVal, oldVal) => {
        form.reset();

        console.log();
        ruta.value = !props.dataModal.dataRegistro
            ? "empresas.store"
            : "empresas.update";
        titulo.value = !props.dataModal.dataRegistro
            ? "Nueva Empresa"
            : "Actualizar Empresa";

        // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
        form.nombre = newVal.dataRegistro?.nombre ?? "";
        form.razon_social = newVal.dataRegistro?.razon_social ?? "";
        form.rfc = newVal.dataRegistro?.razon_social ?? "";
        form.colonia = newVal.dataRegistro?.domicilio?.colonia ?? "";
        form.calle = newVal.dataRegistro?.domicilio?.calle ?? "";
        // para clardidad
        let numeroExterior = newVal.dataRegistro?.domicilio?.numero_exterior;
        form.numero_exterior = numeroExterior ? `${numeroExterior}` : null;
        let numeroInterior = newVal.dataRegistro?.domicilio?.numero_interior;
        form.numero_interior = numeroInterior ? parseInt(numeroInterior) : null;
    }
);
</script>
