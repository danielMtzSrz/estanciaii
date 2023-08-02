<template>
    <Dialog
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="true"
        :modal="true"
        :showHeader="true"
        :header="header"
        :maximizable="maximizable"
        v-model:visible="data_modal.display"
        v-on:update:visible="close"
    >
        <slot name="content"/>

    </Dialog>
</template>

<script setup>

// Primevue
import Dialog from "primevue/dialog";
    
const props = defineProps({
    data_modal: Object,
    maximizable: {
        type: Boolean,
        default: false
    },
    header: {
        type: String,
        default: null
    }
})

const close = () => emits('closeModal')

const emits = defineEmits(['closeModal'])
</script>
