<template>
    <Dialog
        v-model:visible="dataModal.display"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="false"
        :modal="true"
        :showHeader="false"
    >
        <div class="flex justify-between mt-4">
            <slot name="header"/>
            <button
                @click="emits('cerrarModal')"
                class="rounded-full px-2 py-1 shadow-md transition-all transform hover:shadow-xl hover:shadow-gray-700"
            >
                <span class="p-dialog-header-close-icon pi pi-times"></span>
            </button>
        </div>
        <slot name="content"/>
    </Dialog>
</template>

<script setup>
import { ref } from 'vue'
// Primevue
import Dialog from "primevue/dialog";

const display =  ref(null)
    
const props = defineProps({
    dataModal: Object,
})

const emits = defineEmits(['cerrarModal'])
</script>
