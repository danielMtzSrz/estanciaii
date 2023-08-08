<template>
    <GenericLayout titleModule="Chat">
        <template #content>
            Soy un chat
        </template>
    </GenericLayout>
</template>

<script setup>
import { ref } from "vue";

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/System/Empresas/CreateUpdate.vue";

// Variables

// Propiedades
const props = defineProps({ });

// Métodos
</script>
