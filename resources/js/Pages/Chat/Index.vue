<template>
    <GenericLayout titleModule="Chat">
        <template #content>
            <!-- conversaciones: -->
            <!-- <pre>{{ conversaciones }}</pre> -->
            <!-- hacer tabla para selecionar conversacion -> recarga conversacio -->

            <div>
                <!-- chat: ponerle front a esta cosa -->
                <InputText type="text" v-model="mensaje" />

                <Button icon="pi pi-check" class="ms-2 p-button-info p-button-raised p-button-text p-button-sm"
                    @click="send" />
            </div>
        </template>
    </GenericLayout>
</template>

<script setup>
import { ref } from "vue";

import InputText from "primevue/inputtext";
import Button from "primevue/button";

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Propiedades
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
});

// Variables
const mensaje = ref(null);
const chat = ref([]);
const conversacion = ref(props.user.conversaciones[0]);

// methods
const send = () => {
    let msg = {
        id: conversacion.value.id,
        mensaje: mensaje.value,
        autor_id: props.user.id,
    };
    axios
        .post(route("api.chat.send"), msg)
        .then(() => {
            chat.value += msg;
            mensaje.value = "";
        })
        .catch((err) => console.error(err));
};

const getConversacion = (id) => {
    axios
        .get(route("api.chat.get.conversacion", id))
        .then(({ data }) => {
            chat.value = data;
        })
        .catch((err) => console.error(err));
};

const getMsg = (id) => {
    axios
        .get(route("api.chat.get.msg", id))
        .then(({ data }) => {
            chat.value += msg;
        })
        .catch((err) => console.error(err));
};

// Connect to websocket
const chatChannel = window.Echo.private("private.chat.1");
chatChannel.listen(".chat-message", (e) => {
    getMsg(e.msg_id);
});
</script>
