<template>
    <label class="mb-2"> {{ label }}</label>
    <Dropdown
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
        type: Object,
        default: null
    },
    data: {
        type: Object,
        default: null
    },
    value: {
        type: Object,
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
    }
})

const selected = (event) => {
    inputValue.value = event?.value ?? null
    emits('input', inputValue.value);
}

const emits = defineEmits(['input'])
</script> 