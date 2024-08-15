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
                        <Dropdown 
                            label="Tipo de periodo"
                            :data="dataTiposPeriodo"
                            textDropdown="nombre"
                            v-model="tipoPeriodoSeleccionado"
                            :errors="form.errors.tipo_periodo_id"
                        />
                    </div>

                    <div class="col-sm-12">
                        <InputText
                            label="Nombre"
                            v-model="form.titulo"
                            :errors="form.errors.titulo"
                        />
                    </div>

                    <div class="col-sm-12">
                        <Textarea
                            label="Descripción"
                            v-model="form.descripcion"
                            :errors="form.errors.descripcion"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Calendar 
                            label="Fecha inicio"
                            icon="pi pi-calendar"
                            v-model="form.fecha_inicio"
                            :errors="form.errors.fecha_inicio"
                            :showTime="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Calendar 
                            label="Fecha fin"
                            icon="pi pi-calendar"
                            v-model="form.fecha_fin"
                            :errors="form.errors.fecha_fin"
                            :showTime="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label for="estatus" class="flex ms-1">Estatus</label>
                        <InputSwitch
                            inputId="estatus"
                            v-model="form.periodo_activo"
                            class="mt-3 ms-2"
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
import InputSwitch from "primevue/inputswitch";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import Calendar from "@/Components/Forms/Calendar.vue";

// Variables
const dataTiposPeriodo = ref(null), tipoPeriodoSeleccionado = ref(null)

const fechaInicio = ref(null), fechaFin = ref(null)

const form = useForm({
    _method: null,
    tipo_periodo_id: null,
    titulo: null,
    descripcion: null,
    fecha_inicio: null,
    fecha_fin: null,
    periodo_activo: null
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
            tipo_periodo_id: tipoPeriodoSeleccionado.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            tipo_periodo_id: tipoPeriodoSeleccionado.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'Calendarizaciones.Periodos.store' : 'Calendarizaciones.Periodos.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo periodo' : 'Actualizar periodo'

    const dataTiposPeriodoAxios = await axios.get(`/api/tipos_periodo`);
    dataTiposPeriodo.value = dataTiposPeriodoAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.nombre = newVal?.nombre ?? null
    form.contenido = newVal?.contenido ?? null

    form.tipo_periodo_id = newVal?.tipo_periodo_id ?? null
    form.titulo = newVal?.titulo ?? null
    form.descripcion = newVal?.descripcion ?? null
    form.fecha_inicio = newVal?.fecha_inicio_format ?? null
    form.fecha_fin = newVal?.fecha_fin_format ?? null
    form.periodo_activo = newVal?.periodo_activo ?? null

    fechaInicio.value = newVal?.fecha_inicio ?? null
    fechaFin.value = newVal?.fecha_fin ?? null
    tipoPeriodoSeleccionado.value = newVal?.tipo_periodo ?? null
})
</script>
