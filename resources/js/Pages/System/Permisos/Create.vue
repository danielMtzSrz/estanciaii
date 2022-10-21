<template>
    <!-- Modal crear -->
    <Dialog
        v-model:visible="dataModal.display"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="false"
    >
        <div class="flex justify-between mt-0 mb-2">
            <h3 class="font-bold">Nuevo permiso</h3>
            <button
                @click="cerrarModal()"
                class="rounded-full px-2 py-1 shadow-md transition-all transform hover:shadow-xl hover:shadow-gray-700"
            >
                <span class="p-dialog-header-close-icon pi pi-times"></span>
            </button>
        </div>
        <form @submit.prevent="submit(false)">
            <div class="row p-fluid">
                <!-- Input name -->
                <div class="mt-4 col-md-12">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-globe"></i>
                        </span>
                        <span class="p-float-label">
                            <InputText
                                :class="{'p-invalid': errors.name}"
                                name="name"
                                id="name"
                                type="text"
                                v-model="form.name"
                                v-tooltip.top="
                                    'Es la ruta para acceder a algo por ejemplo permission.index'
                                "
                            />

                            <label>Ruta</label>
                        </span>
                    </div>
                    <small class="p-error" v-if="errors.name">{{
                        errors.name
                    }}</small>
                </div>
                <!-- Fin input name -->
                <!-- Input email -->
                <div class="mt-4 col-md-12">
                    <div class="p-inputgroup">
                        <span class="p-float-label">
                            <Textarea
                                :class="{'p-invalid': errors.description}"
                                v-model="form.description"
                                name="description"
                                :autoResize="true"
                                rows="5"
                                cols="30"
                            />

                            <label>Descripción del permiso</label>
                        </span>
                    </div>
                    <small class="p-error" v-if="errors.description">{{
                        errors.description
                    }}</small>
                </div>
                <!-- Fin input email -->
            </div>
            <div class="float-end space-x-2 mt-3">
                <Button
                    type="button"
                    label="Cancelar"
                    class="p-button-text p-button-raised p-button-rounded p-button-warning"
                    @click="cerrarModal()"
                />
                <Button
                    type="submit"
                    label="Guardar"
                    class="p-button-text p-button-raised p-button-rounded p-button-success"
                    :loading="form.processing"
                />
            </div>
        </form>
    </Dialog>
    <!-- Fin modal crear -->
</template>

<script>
// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Divider from "primevue/divider";
import Textarea from "primevue/textarea";
import Tooltip from "primevue/tooltip";

export default {
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading: false,
            display: false,
            form: useForm({
                name: "",
                description: "",
            }),
            errors: {
                name: "",
                description: "",
            },
        };
    },
    components: {
        Button,
        InputText,
        Dialog,
        Divider,
        Textarea,
    },
    props: {
        dataModal: Object,
    },
    methods: {
        cerrarModal() {
            this.$emit("visible", false);
            this.form.reset();
            this.errors = {}
        },
        submit() {
            this.form.post(route("permission.store"), {
                onSuccess: () => {
                    this.cerrarModal();
                    this.form.reset();
                },
                onError: (error) => {
                    this.errors.name = error.name;
                    this.errors.description = error.description;
                },
            });
        },
    },
};
</script>
