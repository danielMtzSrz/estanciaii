<template>
    <Divider align="left">
        <div class="inline-flex align-items-center">
            <i class="pi pi-clock mr-2"></i>
            <b>Horarios</b>
        </div>
    </Divider>
    <div v-for="(dia, index) in dias_semana" :key="index" class="row mb-5">
        <div :class="horarios[dia.key] ? 'col-md-4' : 'col-sm-12'">
            <div class="field-checkbox">
                <div class="flex align-items-end">
                    <Checkbox
                        v-model="horarios[dia.key]"
                        :binary="true"
                    />
                    <label>&nbsp;{{ dia.nombre }}</label>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-4" v-if="horarios[dia.key]">
            <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                    <i class="pi pi-clock"/>
                </span>
                <span class="p-float-label">
                    <Calendar
                        :class="{ 'p-invalid': errors }"
                        icon="pi pi-clock"
                        hourFormat="24"
                        timeOnly
                        v-model="horarios[dia.key+'_hora_inicio']"
                    />
                    <label class="mb-2">Hora de inicio</label>
                </span>
            </div>
        </div>

        <div class="col-sm-12 col-md-4" v-if="horarios[dia.key]">
            <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                    <i class="pi pi-clock"/>
                </span>
                <span class="p-float-label">
                    <Calendar
                        :class="{ 'p-invalid': errors }"
                        icon="pi pi-clock"
                        hourFormat="24"
                        timeOnly
                        v-model="horarios[dia.key+'_hora_fin']"
                    />
                    <label class="mb-2">Hora de fin</label>
                </span>
            </div>
        </div>
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
});

const emit = defineEmits(["update:modelValue"]);

// Reactive state
const horarios = ref({...props.modelValue});

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
</script>
