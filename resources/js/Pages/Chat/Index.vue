<template>
    <GenericLayout titleModule="Chat">
        <template #content>
            <div class="grid">
                <!-- hacer tabla para selecionar conversacion -> recarga conversacio -->
                <!-- manejanuvea conversacion, selecciona usuario -->
                <div class="col-4 h-full">
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h2>Conversaciones</h2>
                        <Button
                            @click="getConversaciones"
                            icon="pi pi-refresh"
                            rounded
                            raised
                        />
                        <Button
                            @click="data_modal.display = true"
                            icon="pi pi-plus"
                            rounded
                            raised
                        />
                    </div>

                    <Listbox
                        v-model="conversacion"
                        :options="conversaciones"
                        filter
                        optionLabel="nombre"
                        class="mt-4 h-full w-full"
                        listStyle="max-height:250px"
                    />
                </div>
                <div class="col-8 h-full">
                    <Card class="h-full">
                        <template #title>
                            {{
                                conversacion?.nombre ??
                                "Seleccione una conversacion"
                            }}
                        </template>
                        <template #content>
                            <pre>{{ chat }}</pre>
                            <p>Esto es lo que no jala...</p>
                            <!-- Tambien es checar si es el usuario o no para decidir el estilo -->
                            <VirtualScroller
                                :items="chat"
                                :itemSize="100"
                                class="border-1 surface-border border-round w-full h-full"
                                style="width: 200px; height: 200px"
                            >
                                <template v-slot:item="{ item }">
                                    {{ { item } }}
                                </template>
                            </VirtualScroller>
                        </template>
                        <template #footer>
                            <InputText
                                class="col-10"
                                type="text"
                                v-model="mensaje"
                            />
                            <Button
                                icon="pi pi-check"
                                class="ms-2 p-button-info p-button-raised p-button-text p-button-sm"
                                @click="send"
                                :loading="!subscribed"
                            />
                        </template>
                    </Card>
                </div>
            </div>
        </template>
        <template #footer>
            <Dialog
                :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
                :style="{ width: '50vw' }"
                :closable="true"
                :modal="true"
                :showHeader="true"
                header="Nueva Conversacion"
                :maximizable="true"
                v-model:visible="data_modal.display"
            >
                <div class="row p-fluid pt-4">
                    <div class="col-md-12">
                        <Dropdown
                            label="Destinatario"
                            :data="contacts"
                            textDropdown="name"
                            v-model="destinatario"
                        />
                    </div>
                    <div class="col-md-12">
                        <InputText label="Mensaje" v-model="newMessage" />
                    </div>
                </div>
                <div class="float-end space-x-2 mt-3">
                    <Button
                        type="button"
                        label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="data_modal.display = false"
                    />
                    <Button
                        type="button"
                        label="Mandar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="processNewConv"
                        @click="newConversacion"
                    />
                </div>
            </Dialog>
        </template>
    </GenericLayout>
</template>

<script setup>
import { ref, watch } from "vue";

import InputText from "primevue/inputtext";
import Button from "primevue/button";

import Listbox from "primevue/listbox";
import Card from "primevue/card";
import VirtualScroller from "primevue/virtualscroller";
import Dialog from "primevue/dialog";

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
// Propiedades
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    contacts: {
        type: Object,
        default: null,
    },
});

// Variables
const chatChannel = window.Echo;
const mensaje = ref(null);
const chat = ref([]);
const subscribed = ref(false);
// Yo se no me veas feo...
const cleanConvs = (convs) =>
    convs.map((conv) => {
        let usrs = conv.usuarios.filter((user) => props.user.id != user.id);
        if (usrs.length > 1) return { ...conv, nombre: "grupo:" };
        return { ...conv, nombre: `${usrs[0].name}` };
    });
const conversaciones = ref(cleanConvs(props.user.conversaciones));
const conversacion = ref();
// Nueva Conv
const newMessage = ref("");
const destinatario = ref();
const processNewConv = ref(false);
const data_modal = ref({
    display: false,
});

// methods
const send = () => {
    let msg = {
        id: conversacion.value.id,
        mensaje: mensaje.value,
        autor_id: props.user.id,
    };
    return axios
        .post(route("api.chat.send"), msg)
        .then(() => {
            chat.value.push(msg);
            mensaje.value = "";
        })
        .catch((err) => console.error(err));
};

const newConversacion = async () => {
    let msg = {
        mensaje: newMessage.value,
        autor_id: props.user.id,
        destinatario_id: destinatario.value.id,
    };
    return axios
        .post(route("api.chat.create"), msg)
        .then(async () => {
            conversacion.value = null;
            await getConversaciones();
            data_modal.value.display = false;
        })
        .catch((err) => console.error(err));
};

const getConversaciones = async () => {
    return axios
        .post(route("api.chat.index"), { id: props.user.id })
        .then(({ data }) => {
            conversaciones.value = cleanConvs(data);
        })
        .catch((err) => console.error(err));
};

const getMsg = async (id, conversacion_id) => {
    return axios
        .get(route("api.chat.get.msg", id))
        .then(({ data }) => {
            chat.value.push(data);
        })
        .catch((err) => console.error(err));
};

watch(
    () => conversacion.value,
    async () => {
        // Connect to websocket
        let id = conversacion.value?.id;
        if (!id) return; // caso deselect | empty
        // Escucha las notificaciones de los mensajes -> actualiza mensajes
        chatChannel
            .private(`private.chat.${id}`)
            .subscribed(() => {
                subscribed.value = true;
            })
            .listen(".chat-message", (e) => {
                getMsg(e.msg_id, e.conversacion_id);
            });
        // Pide los mensajes
        axios
            .post(route("api.chat.show"), { id })
            .then(({ data }) => {
                chat.value = data;
            })
            .catch((err) => console.error(err));
    }
);
</script>
