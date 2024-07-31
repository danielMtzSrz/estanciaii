<template>
    <div class="mb-5">
        <small :for="name">{{ label }}</small>
        <div class="p-inputgroup">
            <span v-if="icon" class="p-inputgroup-addon">
                <i :class="icon"></i>
            </span>
            <div class="flex flex-column gap-2 w-100">
                <Calendar
                    class="w-100"
                    :class="{'p-invalid': errors}"
                    :name="name"
                    @date-select="selected($event)"
                    hourFormat="24"
                    :timeOnly="true"
                    v-model="inputValue"
                />
            </div>
        </div>
        <small class="p-error" v-if="errors">
            {{ errors }}
        </small>
    </div>
</template>

<script setup>
import { ref } from 'vue';

// Primevue
import Calendar from 'primevue/calendar';

const inputValue = ref(props.value)

const props = defineProps({
    icon: String,
    errors: {
        type: [Object, String],
        default: null
    },
    value: {
        type: [Object, String],
        default: null
    },
    label: {
        type: String,
        default: 'Falta agregar el label',
    },
    name: {
        type: String,
        default: null
    },
    icon: {
        type: String,
        default: null
    }
})

const emits = defineEmits(['input'])

const selected = (event) => {
    inputValue.value = event

    let valorFormateado = null,
        hour = ("0" + (event.getHours())).slice(-2),
        min  = ("0" + (event.getMinutes())).slice(-2),
        seg  = "00"

    valorFormateado = hour + ":" +  min + ":" + seg;

    emits('input', {valueFormat: valorFormateado, valueShow: event});
}
</script> 