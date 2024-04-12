<template>
    <Divider align="left">
        <div class="inline-flex align-items-center">
            <i class="pi pi-clock mr-2"></i>
            <b>Horarios</b>
        </div>
    </Divider>
    <div v-for="(dia, index) in dias_semana" :key="index" class="row">
        <div :class="horarios[dia.key] ? 'col-md-4' : 'col-sm-12'">
            <div class="field-checkbox" :class="horarios[dia.key] || !errorsParse ? 'my-3' : ''">
                <div class="flex align-items-end">
                    <Checkbox
                        :class="{ 'p-invalid': errorsParse && errorsParse[dia.key] }"
                        v-model="horarios[dia.key]"
                        :binary="true"
                    />
                    <label>&nbsp;{{ dia.nombre }}</label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 my-3" v-if="horarios[dia.key]">
            <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                    <i class="pi pi-clock"/>
                </span>
                <span class="p-float-label">
                    <Calendar
                        :class="{ 'p-invalid': errorsParse && errorsParse[dia.key] }"
                        icon="pi pi-clock"
                        hourFormat="24"
                        timeOnly
                        v-model="horarios[dia.key+'_hora_inicio']"
                    />
                    <label class="mb-2">Hora de inicio</label>
                </span>
            </div>
        </div>

        <div class="col-sm-12 col-md-4 my-3" v-if="horarios[dia.key]">
            <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                    <i class="pi pi-clock"/>
                </span>
                <span class="p-float-label">
                    <Calendar
                        :class="{ 'p-invalid': errorsParse && errorsParse[dia.key] }"
                        icon="pi pi-clock"
                        hourFormat="24"
                        timeOnly
                        v-model="horarios[dia.key+'_hora_fin']"
                    />
                    <label class="mb-2">Hora de fin</label>
                </span>
            </div>
        </div>
        <div class="col-sm-12 p-error mb-5" v-if="errorsParse" v-html="errorsParse[dia.key]"></div>
    </div>
</template>

<script setup>
// Vue
import { ref, watch } from "vue";

// Primevue
import Checkbox from "primevue/checkbox";
import Calendar from "primevue/calendar";
import Divider from 'primevue/divider';

// Props y Emits
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    errors: null
});

const emit = defineEmits(["update:modelValue"]);

// Reactive state
const horarios = ref({...props.modelValue});
const errorsParse = ref(null)

const dias_semana = ref([
    { key: "lunes", nombre: "Lunes" },
    { key: "martes", nombre: "Martes" },
    { key: "miercoles", nombre: "Miércoles" },
    { key: "jueves", nombre: "Jueves" },
    { key: "viernes", nombre: "Viernes" },
    { key: "sabado", nombre: "Sábado" },
    { key: "domingo", nombre: "Domingo" },
]);

// Watcher para horarios
watch(horarios, (newValue) => {
        emit("update:modelValue", newValue);
    },
    { deep: true }
);

watch(() => props.errors, (newVal) => {
    if (newVal && typeof newVal === 'string') {
        // Asumiendo que props.errors es una string JSON como producida por Laravel
        errorsParse.value = JSON.parse(newVal);
    } else {
        errorsParse.value = newVal; // Si ya es un objeto, úsalo directamente
    }
}, { immediate: true, deep: true });
</script>
