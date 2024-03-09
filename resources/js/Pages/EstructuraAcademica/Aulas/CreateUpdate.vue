<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">
                    
                    <div class="flex-auto">
                        <label for="templatedisplay" class="font-bold block mb-2"> Custom Icon </label>
                        <Calendar v-model="form.templatedisplay" showIcon iconDisplay="input" timeOnly inputId="templatedisplay">
                            <template #inputicon="{ clickCallback }">
                                <InputIcon class="pi pi-clock cursor-pointer" @click="clickCallback" />
                            </template>
                        </Calendar>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Edificio"
                            :data="dataModal.dataEdificios"
                            textDropdown="nombre"
                            v-model="edificioSeleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Tipo de aula"
                            :data="dataModal.dataTiposAula"
                            textDropdown="nombre"
                            v-model="tipoAulaSeleccionado"
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

                    <!-- Componente horario -->

                    <div v-for="(dia_semana, index) in dias_semana" class="row" :key="index">
                        <div class="col-sm-12 m-auto" :class="form.horarios[`${dia_semana.key}`] ? 'col-md-4' : 'col-md-12'">
                            <div class="field-checkbox">
                                <div class="flex align-items-end">
                                    <Checkbox v-model="form.horarios[`${dia_semana.key}`]" :binary="true"/>
                                    <label>&nbsp;{{ dia_semana.nombre }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4" v-if="form.horarios[`${dia_semana.key}`]">
                            <CalendarTime
                                label="Hora de inicio"
                                name="hora_inicio"
                                icon="pi pi-clock"
                                :value="form.horarios[dia_semana.key + '_hora_inicio']"
                                @input="form.horarios[`${dia_semana.key}_hora_inicio`] = $event.valueFormat"
                            />
                        </div>

                        <div class="col-sm-12 col-md-4" v-if="form.horarios[`${dia_semana.key}`]">
                            <CalendarTime
                                label="Hora de fin"
                                name="hora_fin"
                                icon="pi pi-clock"
                                :value="form.horarios[dia_semana.key + '_hora_fin']"
                                @input="form.horarios[`${dia_semana.key}_hora_fin`] = $event.valueFormat"
                            />
                        </div>
                        
                    </div>

                    <!-- Componente horario fin -->

                    
                    <pre>{{ form }}</pre>

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
import Calendar from 'primevue/calendar'

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import CalendarTime from "@/Components/Forms/CalendarTime.vue";

// Variables
const edificioSeleccionado = ref(null), tipoAulaSeleccionado = ref(null)

const form = useForm({
    _method: null,
    edificio_id: null,
    tipo_aula_id: null,
    nombre: null,
    capacidad: null,
    estatus: null,
    horarios : {},
    templatedisplay: null
})

const ruta = ref(null), titulo = ref(null)

const dias_semana = ref([
    {key : "lunes", nombre : "Lunes"},
    {key : "martes", nombre : "Martes"},
    {key : "miercoles", nombre : "Miércoles"},
    {key : "jueves", nombre : "Jueves"},
    {key : "viernes", nombre : "Viernes"},
    {key : "sabado", nombre : "Sábado"},
    {key : "domingo", nombre : "Domingo"}
]);

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
            edificio_id     : edificioSeleccionado.value?.id,
            tipo_aula_id    : tipoAulaSeleccionado.value?.id,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            edificio_id      : edificioSeleccionado.value?.id,
            tipo_aula_id    : tipoAulaSeleccionado.value?.id,
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

    edificioSeleccionado.value = newVal?.edificio ?? null
    tipoAulaSeleccionado.value = newVal?.tipo_aula ?? null
})
</script>
