<template>
    <div class="p-inputgroup">
        <span v-if="icon" class="p-inputgroup-addon">
            <i :class="icon"></i>
        </span>
        <span class="p-float-label">
            <Calendar
                :class="{'p-invalid': errors}"
                :name="name"
                @date-select="selected"
                :showTime="showTime"
                dateFormat="dd-mm-yy"
                hourFormat="24"
                v-model="inputValue"
            />
            <label class="mb-2"> {{ label }}</label>
        </span>
    </div>
    <small class="p-error" v-if="errors">
        {{errors}}
    </small>
</template>

<script setup>
import { ref } from 'vue';

// Primevue
import Calendar from 'primevue/calendar';

const inputValue = ref(props.value ? new Date(props.value) : null)

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
    },
    showTime: {
        type: Boolean,
        default: true
    },
    modelValue: null
})

const emits = defineEmits(['input'])

const selected = (event) => {
    inputValue.value = event
    let valorFormateado = null
    if(props.showTime){
        let month = ("0" + (event.getMonth() + 1)).slice(-2);
        let day  = ("0" + (event.getDate())).slice(-2);
        let year = event.getFullYear();
        let hour =  ("0" + (event.getHours())).slice(-2);
        let min =  ("0" + (event.getMinutes())).slice(-2);
        let seg = "59";
        valorFormateado = year + "-" + month + "-" + day + " " + hour + ":" +  min + ":" + seg;
    }else{
        valorFormateado = event.toLocaleDateString("en-CA")
    }
    emits('input', {valueFormat: valorFormateado, valueShow: event});
}
</script> 