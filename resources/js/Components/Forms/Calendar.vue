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
                    @date-select="selected"
                    :showTime="showTime"
                    dateFormat="dd-mm-yy"
                    hourFormat="24"
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
import { ref, watch } from 'vue';
import Calendar from 'primevue/calendar';

const props = defineProps({
    icon: String,
    errors: {
        type: [Object, String],
        default: null
    },
    modelValue: {
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
    showTime: {
        type: Boolean,
        default: true
    }
});

const emits = defineEmits(['update:modelValue', 'input']);

const inputValue = ref(props.modelValue ? new Date(props.modelValue) : null);

watch(() => props.modelValue, (newValue) => {
    inputValue.value = new Date(newValue);
});

const selected = (event) => {
    inputValue.value = event;
    let valorFormateado = null;
    if (props.showTime) {
        let month = ("0" + (event.getMonth() + 1)).slice(-2);
        let day  = ("0" + (event.getDate())).slice(-2);
        let year = event.getFullYear();
        let hour = ("0" + (event.getHours())).slice(-2);
        let min = ("0" + (event.getMinutes())).slice(-2);
        let seg = "59";
        valorFormateado = `${year}-${month}-${day} ${hour}:${min}:${seg}`;
    } else {
        valorFormateado = event.toLocaleDateString("en-CA");
    }
    emits('update:modelValue', valorFormateado);
    emits('input', { valueFormat: valorFormateado, valueShow: event });
};
</script>
