<template>
    <app-layout>
        <div class="text-center mt-3">
            <p class="display-6">Bienvenido</p>
        </div>

    </app-layout>
</template>

<script setup>
import { ref } from 'vue'

// Primevue
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Avatar from "primevue/avatar";
import Card from 'primevue/card';
import Image from 'primevue/image';
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