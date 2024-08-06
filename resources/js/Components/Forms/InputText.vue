<!-- 
import InputText from "@/Assets/Components/Forms/InputText.vue";
<InputText
    icon="pi pi-user"
    label="Nombre"
    name="name"
    :errors="form.errors.name"
    v-model="value"
/>
 -->

 <template>
    <div class="mb-5">
        <small :for="name">{{ label }}</small>
        <div class="p-inputgroup">
            <span v-if="icon" class="p-inputgroup-addon">
                <i :class="icon"></i>
            </span>
            <div class="flex flex-column gap-2 w-100">
                <InputText
                    class="w-100"
                    :class="{ 'p-invalid': errors }"
                    :name="name"
                    :id="id"
                    type="text"
                    v-model="inputValue"
                    v-tooltip.top="tooltip"
                    :disabled="disabled"
                />
            </div>
        </div>
        <small class="p-error mb-2" v-if="errors">
            {{ errors }}
        </small>
    </div>
</template>

<script setup>
// Vue
import { computed } from "vue";

// Primevue
import InputText from "primevue/inputtext";


const props = defineProps({
    icon: String,
    errors: null,
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
    disabled: {
        type: Boolean,
        default: false,
    },
    modelValue: null,
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