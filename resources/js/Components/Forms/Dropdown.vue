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
    :value="tipoPeriodo"
    :errors="form.errors.tipo_periodo_id"
    textDropdown="nombre"
    @input="form.tipo_periodo_id = $event.id, tipoPeriodo=$event"
/> 
-->

<template>
    <label class="mb-2"> {{ label }}</label>
    <div class="p-inputgroup">
        <span v-if="icon" class="p-inputgroup-addon">
            <i :class="icon"></i>
        </span>
        <span class="p-float-label">
            <Dropdown
                :class="{'p-invalid': errors}"
                :options="data"
                :optionLabel="textDropdown"
                placeholder="Seleccionar..."
                :filter="true"
                filterPlaceholder="Buscar..."
                v-model="inputValue"
                @change="selected($event)" 
            >
                <template #value="slotProps">
                    <div class="p-dropdown-car-value" v-if="slotProps.value">
                        <div class="flex p-dropdown-car-option">
                            <Avatar
                                v-if="slotProps.value[imageDropdown] && imageDropdown" 
                                :alt="slotProps.value[textDropdown]"
                                :image="'/storage/'+slotProps.value[imageDropdown]"
                                class="p-avatar-image p-avatar-circle"
                            />
                            <span class="ms-2">{{slotProps.value[textDropdown]}}</span>
                        </div>
                    </div>
                    <span v-else>
                        {{slotProps.placeholder}}
                    </span>
                </template>
                <template #option="slotProps" @click="selectId">
                    <div class="flex p-dropdown-car-option">
                        <Avatar 
                            v-if="slotProps.option[imageDropdown]"
                            :alt="slotProps.option[textDropdown]"
                            :image="'/storage/'+slotProps.option[imageDropdown]"
                            class="p-avatar-image p-avatar-circle"
                        />
                        <span class="ms-2">{{slotProps.option[textDropdown]}}</span>
                    </div>
                </template>
            </Dropdown>
        </span>
    </div>
    <small class="p-error" v-if="errors">
        {{errors}}
    </small>
</template>

<script setup>
import { ref, watch } from 'vue';
// Primevue
import Dropdown from 'primevue/dropdown'
import Avatar from 'primevue/avatar'
import Tooltip from "primevue/tooltip";

const inputValue = ref(props.value)

const props = defineProps({
    icon: String,
    errors: {
        type: [Object, String],
        default: null
    },
    data: {
        type: Object,
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
    }
})

const selected = (event) => {
    inputValue.value = event?.value ?? null
    emits('input', inputValue.value);
}

const emits = defineEmits(['input'])
</script> 