<template>
    <div class="mb-5">
        <div class="p-inputgroup">
            <span v-if="icon" class="p-inputgroup-addon">
                <i :class="icon"></i>
            </span>
            <span class="p-float-label">
                <Textarea
                    :id="id"
                    :name="name"
                    :class="{ 'p-invalid': errors }"
                    v-model="inputValue"
                    :autoResize="true"
                    rows="5"
                    cols="30"
                    v-tooltip.top="tooltip"
                />
                <label>{{ label }}</label>
            </span>
        </div>
        <small class="p-error" v-if="errors">
            {{ errors }}
        </small>
    </div>
</template>

<script setup>
// Vue
import { computed } from "vue";

// Primevue
import Textarea from "primevue/textarea";

const props = defineProps({
    icon: String,
    errors: {
        type: [Object, String],
        default: null,
    },
    label: {
        type: String,
        default: "Falta agregar el label",
    },
    formModel: {
        type: Object,
        default: null,
    },
    tooltip: {
        default: String,
        default: null,
    },
    value: {
        type: String,
        default: null,
    },
    name: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null,
    },
    modelValue: String,
});

const emits = defineEmits(["update:modelValue"]);

const inputValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emits('update:modelValue', value)
  }
})
</script>
