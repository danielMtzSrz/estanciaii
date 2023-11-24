<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-4 col-md-12">
                        <Dropdown 
                            label="Tipo de periodo"
                            :data="dataModal.dataTipoPeriodo"
                            :value="tipoPeriodo"
                            :errors="form.errors.tipo_periodo_id"
                            textDropdown="nombre"
                            @input="form.tipo_periodo_id = $event.id, tipoPeriodo=$event"
                        />
                    </div>
                    <!-- Input name -->
                    <div class="mt-4 col-md-12">
                        <InputText 
                            label="Título"
                            name="titulo"
                            :errors="form.errors.titulo"
                            :value="form.titulo"
                            @input="form.titulo = $event"
                        />
                    </div>
                    <!-- Fin input name -->
                    <!-- Input description -->
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Descripción del periodo"
                            name="descripcion"
                            :errors="form.errors.descripcion"
                            :value="form.descripcion"
                            @input="form.descripcion = $event"
                        />
                    </div>
                    <!-- Fin input description -->
                    <div class="mt-4 col-md-6">
                        <Calendar 
                            label="Fecha de inicio"
                            name="fecha_inicio"
                            icon="pi pi-calendar"
                            :value="mostrarFechaInicio"
                            :errors="form.errors.fecha_inicio"
                            @input="form.fecha_inicio = $event.valueFormat, mostrarFechaInicio = $event.valueShow"
                        />
                    </div>
                    <div class="mt-4 col-md-6">
                        <Calendar 
                            label="Fecha final"
                            name="fecha_fin"
                            icon="pi pi-calendar"
                            :value="mostrarFechaFin"
                            :errors="form.errors.fecha_fin"
                            @input="form.fecha_fin = $event.valueFormat, mostrarFechaFin = $event.valueShow"
                        />
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="field-checkbox">
                            <div class="d-flex align-content-center">
                                <Checkbox v-model="form.periodo_activo" :binary="true" />
                                <label>&nbsp;{{ form.periodo_activo ? 'Periodo activo' : 'Periodo inactivo' }}</label>
                            </div>
                        </div>
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

import { ref, watch, computed } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import ColorPicker from 'primevue/colorpicker';
import Checkbox from 'primevue/checkbox';

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Textarea from "@/Components/Forms/Textarea.vue";
import Dropdown from '@/Components/Forms/Dropdown.vue';
import Calendar from '@/Components/Forms/Calendar.vue';

import GenericModal from '@/Components/GenericModal.vue';

const tipoPeriodo = ref(null)
const mostrarFechaInicio = ref(null)
const mostrarFechaFin = ref(null)

const form = useForm({
    tipo_periodo_id: null,
    titulo: null,
    descripcion: null,
    fecha_inicio : null,
    fecha_fin: null,
    periodo_activo: null
})

const ruta = ref(null)
const titulo = ref(null)

const props = defineProps({
    dataModal: {
        type: Object,
        default: null
    },
})

const emits = defineEmits(['visible'])

const closeModal = () => {
    emits("visible", false);
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.transform((data) => ({
            ...data,
            periodo_activo: data.periodo_activo ? 1 : 0,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
    }else{
        form.transform((data) => ({
            ...data,
            periodo_activo: data.periodo_activo ? 1 : 0,
        })).put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'Calendarizaciones.Periodos.store' : 'Calendarizaciones.Periodos.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nuevo periodo' : 'Actualizar periodo'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    mostrarFechaInicio.value = newVal?.fecha_inicio ?? null
    mostrarFechaFin.value = newVal?.fecha_fin ?? null
    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    tipoPeriodo.value = newVal?.tipoPeriodo ?? null
    form.tipo_periodo_id = newVal?.tipoPeriodo.id ?? null
    form.titulo = newVal?.titulo ?? null
    form.descripcion = newVal?.descripcion ?? null
    form.fecha_inicio = newVal?.fecha_inicio ?? null
    form.fecha_fin = newVal?.fecha_fin ?? null
    form.periodo_activo = (newVal?.periodo_activo ? true : false)
})
</script>

