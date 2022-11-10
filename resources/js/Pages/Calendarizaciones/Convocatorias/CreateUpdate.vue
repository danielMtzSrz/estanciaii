<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
            <h3 class="font-bold">{{ titulo }}</h3>
        </template>
        <template #content>
            <form @submit.prevent="submit(false)">
                <div class="row p-fluid">
                    <div class="mt-2 col-md-12">
                        <Dropdown 
                            :data="dataModal.dataTiposConvocatorias"
                            label="Tipo de convocatoria"
                            textDropdown="nombre"
                            :value="tipoConvocatoria"
                            @input="form.tipo_convocatoria_id = $event.id, tipoConvocatoria=$event"
                            :errors="form.errors.tipo_convocatoria_id"
                        />
                    </div>
                    <div class="mt-2 col-md-12">
                        <Dropdown 
                            :data="dataModal.dataPeriodos"
                            label="Periodo"
                            textDropdown="titulo"
                            :value="periodo"
                            @input="form.periodo_id = $event.id, periodo=$event"
                            :errors="form.errors.periodo_id"
                        />
                    </div>
                    <div class="mt-2 col-md-12">
                        <Dropdown 
                            :data="dataModal.dataServicios"
                            label="Servicios"
                            textDropdown="concepto"
                            :value="servicio"
                            @input="form.servicio_id = $event.id, servicio=$event"
                            :errors="form.errors.servicio_id"
                        />
                    </div>
                    <div class="mt-4 col-md-12">
                        <Textarea
                            label="Contenido"
                            name="contenido"
                            :value="form.contenido"
                            @input="form.contenido = $event"
                            :errors="form.errors.contenido"
                        />
                    </div>
                </div>
                <div class="float-end space-x-2">
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

import { ref, watch, computed } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import ColorPicker from 'primevue/colorpicker';
import Checkbox from 'primevue/checkbox';

// Inputs
import InputText from "@/Assets/Components/Forms/InputText.vue";
import Textarea from "@/Assets/Components/Forms/Textarea.vue";
import Dropdown from '@/Assets/Components/Forms/Dropdown.vue';
import Calendar from '@/Assets/Components/Forms/Calendar.vue';
import Divider from 'primevue/divider';

import GenericModal from '@/Assets/Components/GenericModal.vue';

const periodo = ref(null)
const tipoConvocatoria = ref(null)
const servicio = ref(null)
const mostrarFechaInicio = ref(null)
const mostrarFechaFin = ref(null)

const form = useForm({
    tipo_convocatoria_id : null,
    periodo_id: null,
    servicio_id : null,
    contenido: null,
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

const cerrarModal = () => {
    emits("visible", false);
    form.reset();
    form.errors = {}
}

// Métodos
const submit = () => {
    if(!props.dataModal.dataRegistro){
        form.post(route(ruta.value), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }else{
        form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
}

watch(() => props.dataModal, (newVal, oldVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'Calendarizaciones.Convocatorias.store' : 'Calendarizaciones.Convocatorias.update'
    titulo.value = !props.dataModal.dataRegistro ? 'Nueva convocatoria' : 'Actualizar convocatoria'
})

watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
    form.reset();

    mostrarFechaInicio.value = newVal?.fecha_inicio ?? null
    mostrarFechaFin.value = newVal?.fecha_fin ?? null
    
    // En caso de que se modifique el registro se llenarán estos campos correspondientes al form.
    tipoConvocatoria.value = newVal?.tipoConvocatoria ?? null
    periodo.value = newVal?.periodo ?? null
    servicio.value = newVal?.servicio ?? null

    form.tipo_convocatoria_id = newVal?.tipoConvocatoria.id ?? null
    form.periodo_id = newVal?.periodo.id ?? null
    form.servicio_id = newVal?.servicio.id ?? null
    form.contenido = newVal?.contenido ?? null
})
</script>

