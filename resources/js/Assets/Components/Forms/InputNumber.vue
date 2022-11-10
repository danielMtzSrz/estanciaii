<template>
    <div class="p-inputgroup">
        <span v-if="icon" class="p-inputgroup-addon">
            <i :class="icon"></i>
        </span>
        <span class="p-float-label my-3">
            <InputNumber
                :class="{'p-invalid': errors}"
                :name="name"
                :id="id"
                :mode="mode"
                v-model="inputValue"
                v-tooltip.top="tooltip"
                :disabled="disabled"
            />
            <label>{{ label }}</label>
        </span>
    </div>
    <small class="p-error" v-if="errors">
        {{errors}}
    </small>
</template>

<script setup>
import { ref, watch } from 'vue';

import InputNumber from "primevue/inputnumber";
import Tooltip from "primevue/tooltip";

const inputValue = ref(props.value)

const props = defineProps({
    icon: String,
    disabled:{
        type: Boolean,
        default: false
    },
    errors: {
        type: Object,
        default: null
    },
    label: {
        type: String,
        default: "Number"
    },
    formModel : {
        type : Object,
        default: null
    },
    tooltip : {
        default: String,
        default: null
    },
    value : {
        type: String,
        default: null
    },
    name: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null
    },
    mode:{
        type: String,
        default: "decimal"
    }
})

const emits = defineEmits(['input'])

watch(inputValue, (newVal, oldVal) => {
    inputValue.value = newVal
    emits('input', inputValue);
})

</script> 

<script>
export default {
    directives: {
        tooltip: Tooltip,
    },
}
</script>