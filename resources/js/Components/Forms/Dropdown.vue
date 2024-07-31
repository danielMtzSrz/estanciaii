<!-- 
| Nombre        | Descripción                                                                   | Type             | Ejemplo                                                  |
| ------------- | ----------------------------------------------------------------------------- | ---------------- | -------------------------------------------------------- |
| icon          | Es el ícono que aparecerá a la izquierda del dropdown                         | String           | icon="pi pi-user"                                        |
| label         | Es el texto que aparecerá sobre el dropdown                                   | String           | label='Texto informativo'                                |
| data          | Es la colección de datos que contiene la información para los datos a mostrar | Object           | :data="[{id: 1, name: 'Hola'}, {id: 2, name: 'Hola 2'}]" |
| value         | Es el objeto que se seleccionó o se está recuperando de un registro           | Object           | :value="{id: 1, name: 'Hola'}"                           |
| errors        | Es el Objeto o String que contiene los errores del request                    | [Object, String] | :errors="[{required: "El campo es requerido"}]"          |
| imageDropdown | Es el nombre de la columna de la BD que contiene la dirección de la imagen    | String           | imageDropdown="profile_photo_path"                       |
| textDropdown  | Es el nombre de la columna de la BD que contiene el texto a mostrar           | String           | textDropdown="name"                                      |

Ejemplo: 
<Dropdown 
    label="Tipo de periodo"
    :data="dataModal.dataTipoPeriodo"
    textDropdown="nombre"
    v-model="tipoPeriodo"
    :errors="form.errors.tipo_periodo_id"
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
                <Dropdown
                    class="w-100"
                    :class="{'p-invalid': errors}"
                    :options="data"
                    :optionLabel="textDropdown"
                    :placeholder="placeholder"
                    :filter="true"
                    filterPlaceholder="Buscar..."
                    v-model="inputValue"
                    :disabled="disabled"
                >
                    <template #value="slotProps">
                        <div class="p-dropdown-car-value" v-if="slotProps.value">
                            <div class="flex p-dropdown-car-option align-items-center">
                                <Image
                                    v-if="slotProps.value[imageDropdown] && imageDropdown" 
                                    :alt="slotProps.value[textDropdown]"
                                    :src="'/storage/'+slotProps.value[imageDropdown]"
                                    width="30"
                                    class="p-avatar-image p-avatar-circle"
                                />
                                <span class="ms-2">{{ slotProps.value[textDropdown] }}</span>
                            </div>
                        </div>
                        <span v-else>
                            {{ slotProps.placeholder }}
                        </span>
                    </template>
                    <template #option="slotProps">
                        <div class="flex p-dropdown-car-option align-items-center">
                            <Image 
                                v-if="slotProps.option[imageDropdown]"
                                :alt="slotProps.option[textDropdown]"
                                :src="'/storage/'+slotProps.option[imageDropdown]"
                                width="30"
                                class="p-avatar-image p-avatar-circle"
                            />
                            <span class="ms-2">{{ slotProps.option[textDropdown] }}</span>
                        </div>
                    </template>
                </Dropdown>
            </div>
        </div>
        <small class="p-error" v-if="errors">
            {{ errors }}
        </small>
    </div>
</template>

<script setup>
// Vue
import { computed } from 'vue';

// Primevue
import Dropdown from 'primevue/dropdown'
import Image from 'primevue/image'

const props = defineProps({
    icon: String,
    errors: {
        type: [Object, String],
        default: null
    },
    data: {
        type: [Object, Promise],
        default: null
    },
    name: {
        type: String,
        default: null
    },
    value: {
        type: [Object, String],
        default: null
    },
    imageDropdown: {
        type: String,
        default: null
    },
    textDropdown: {
        type: String,
        default: null
    },
    label: {
        type: String,
        default: 'Falta agregar el label',
    },
    icon: {
        type: String,
        default: null
    },
    disabled: {
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        default: "Seleccionar "
    },
    modelValue: Object,
})

const placeholder = computed(() => {
    return `${props.placeholder} ${props.label.toLowerCase()}`
})

const inputValue = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emits('update:modelValue', value)
    }
})

const emits = defineEmits(['update:modelValue'])

</script> 