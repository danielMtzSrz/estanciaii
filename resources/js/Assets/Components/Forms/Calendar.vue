<template>
    <div class="p-inputgroup">
        <span v-if="icon" class="p-inputgroup-addon">
            <i :class="icon"></i>
        </span>
        <span class="p-float-label">
            <Calendar
                :class="{'p-invalid': errors}"
                :name="name"
                @date-select="selected($event)"
                dateFormat="yy-mm-dd"
                :showTime="showTime"
                hourFormat="24"
                v-model="value"
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
    },
    showTime: {
        type: Boolean,
        default: true
    }
})

const emits = defineEmits(['input'])

const selected = (event) => {
    inputValue.value = event.toLocaleDateString("en-CA", { hour12: false, hour: 'numeric', minute: 'numeric'})
    emits('input', {valueFormat: inputValue.value, valueShow: event});
}
</script> 