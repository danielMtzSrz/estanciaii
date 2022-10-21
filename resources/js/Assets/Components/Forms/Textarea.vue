<template>
    <div class="p-inputgroup">
        <span v-if="icon" class="p-inputgroup-addon">
            <i :class="icon"></i>
        </span>
        <span class="p-float-label">
            <Textarea
                :id="id"
                :name="name"
                :class="{'p-invalid': errors}"
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
        {{errors}}
    </small>
</template>

<script setup>
import { ref, watch } from 'vue';
// Primevue
import Textarea from "primevue/textarea";
import Tooltip from "primevue/tooltip";

const inputValue = ref(props.value)

const props = defineProps({
    icon: String,
    errors: {
        type: Object,
        default: null
    },
    label: {
        type: String,
        default: "Falta agregar el label"
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