<template>
    <Dialog v-model:visible="dataModal.display" :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }" :closable="false">
        <div class="flex justify-between mt-0 mb-2">
            <h3 class="font-bold">Eliminar anuncio</h3>
            <button @click="closeModal()"
                class="rounded-full px-2 py-1 shadow-md  transition-all transform hover:shadow-xl hover:shadow-gray-700">
                <span class="p-dialog-header-close-icon pi pi-times"></span>
            </button>
        </div>
        ¿Seguro que desea eliminar el anuncio <strong>{{ dataModal.dataRegistro.name }}</strong>?
        <div class="float-end space-x-2 mt-3">
            <Button type="button" label="Cancelar"
                    class="p-button-text p-button-raised p-button-rounded p-button-warning" @click="closeModal()" />
            <Button type="submit" label="Eliminar"
                class="p-button-text p-button-raised p-button-rounded p-button-danger"
                @click="eliminarUsuario()" :loading="form.processing" />
        </div>
    </Dialog>
</template>

<script>
// Inertia
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    data() {
        return {
            loading: false,
            display : false,
            form: useForm({
                name: "",
                email: "",
                password: "",
            }),
        };
    },
    components: {
        Button,
        Dialog,
    },
    props: {
        dataModal: Object,
    },
    methods: {
        // Cargar modales
        closeModal() {
            this.$emit("visible", false);
        },
        eliminarUsuario() {
            this.form.delete(route("anuncios.destroy", this.dataModal.dataRegistro), {
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            });
        },
    },
};
</script>
