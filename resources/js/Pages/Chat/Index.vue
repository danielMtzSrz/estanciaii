<template>
    <GenericLayout titleModule="Chat">
        <template #content>
            chat:
            <pre>{{ mensajes }}</pre>
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
// const props = defineProps({});

const mensajes = ref([]);

const chatChannel = window.Echo.private("private.chat.1");

chatChannel
    .subscribed(() => {
        console.log("subscribed");
    })
    .listen(".chat-message", (e) => {
        mensajes.value.push(e);
    });

// Métodos
</script>
