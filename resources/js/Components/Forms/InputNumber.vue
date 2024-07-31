<template>
    <div class="mb-5">
        <small :for="name">{{ label }}</small>
        <div class="p-inputgroup">
            <span v-if="icon" class="p-inputgroup-addon">
                <i :class="icon"></i>
            </span>
            <div class="flex flex-column gap-2 w-100">
                <InputNumber
                    class="w-100"
                    :class="{'p-invalid': errors}"
                    :name="name"
                    :id="id"
                    :mode="mode"
                    v-model="inputValue"
                    v-tooltip.top="tooltip"
                    :disabled="disabled"
                    :useGrouping="useGrouping"
                />
            </div>
        </div>
        <small class="p-error mb-2" v-if="errors">
            {{errors}}
        </small>
    </div>
</template>

<script setup>
// Vue
import { computed } from 'vue';

// Primevue
import InputNumber from "primevue/inputnumber";

const props = defineProps({
    icon: String,
    disabled:{
        type: Boolean,
        default: false
    },
    errors: {
        type: [Object, String],
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
    },
    useGrouping: {
        type: Boolean,
        default: true
    },
    modelValue: Number
})

const emits = defineEmits(['input', 'update:modelValue'])

const inputValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emits('update:modelValue', value)
  }
})
</script>