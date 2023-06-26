<template>
    <Dialog
        v-model:visible="dataModal.display"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :header="header"
        :closable="true"
        :modal="true"
        :showHeader="header && true"
        :maximizable="maximizable"
        v-on:update:visible="close"
    >
    <template #header v-if="header">
        <h3 class="font-bold py-0 mt-0">{{ header }}</h3>
    </template>
    <template v-if="!header">
        <div class="mt-2 pt-1 flex justify-content-between flex-wrap">
                <slot name="header"/>
                <Button 
                    icon="pi pi-times"
                    class="p-button-danger p-button-text p-button-secondary p-button-rounded"
                    @click="emits('cerrarModal')"
                />
            </div>
        </template>
        <Divider class="mt-0"></Divider>
        <slot name="content"/>
    </Dialog>
</template>

<script setup>
import { ref } from 'vue'
// Primevue
import Dialog from "primevue/dialog";
import Divider from 'primevue/divider'
import Button from 'primevue/button';

const display =  ref(null)
    
const props = defineProps({
    dataModal: Object,
    maximizable: {
        type: Boolean,
        default: false
    },
    header: {
        type: String,
        default: null
    }
})

const close = () => {
    emits('cerrarModal')
}

const emits = defineEmits(['cerrarModal'])
</script>
