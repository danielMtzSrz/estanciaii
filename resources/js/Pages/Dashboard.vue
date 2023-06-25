<template>
    <AppLayout>
        <!-- Code -->
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'

// Primevue
import { Inertia } from '@inertiajs/inertia'

// Layout padre
import AppLayout from "@/Layouts/AppLayout.vue";

const displayCreateUpdate = ref(null)

const modalCreateUpdate = (show) => {
    displayCreateUpdate.value = show
}

const detalleMateria = (dataMateria) => {
    Inertia.visit(route("materiaUsuario.show", dataMateria));
}

const props = defineProps({
    materiasUsuarios:{
        type: Object,
        default: null
    }
})

</script>