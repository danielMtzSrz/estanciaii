<template>
    <!-- Modal crear -->
    <Dialog
        v-model:visible="dataModal.display"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="false"
    >
        <div class="flex justify-between mt-0 mb-2">
            <h3 class="font-bold">Nuevo anuncio</h3>
            <button
                @click="cerrarModal()"
                class="rounded-full px-2 py-1 shadow-md transition-all transform hover:shadow-xl hover:shadow-gray-700"
            >
                <span class="p-dialog-header-close-icon pi pi-times"></span>
            </button>
        </div>
        <form @submit.prevent="submit(false)" enctype="multipart/form-data">
            <div class="row p-fluid">
                <div class="mt-4 col-md-12">
                    <label class="mb-2">Empresa encargada del anuncio</label>
                    <Dropdown
                        v-model="empresa" 
                        :options="dataModal.dataEmpresas"
                        optionLabel="name"
                        placeholder="Seleccionar..."
                        :filter="true"
                        filterPlaceholder="Buscar..."
                    >
                        <template #value="slotProps">
                            <div class="p-dropdown-car-value" v-if="slotProps.value">
                                <div class="flex p-dropdown-car-option">
                                    <Avatar :alt="slotProps.value.name" :image="'/storage/'+slotProps.value.imagen" class="p-avatar-image p-avatar-circle"/>
                                    <span>&nbsp;&nbsp;{{slotProps.value.name}}</span>
                                </div>
                            </div>
                            <span v-else>
                                {{slotProps.placeholder}}
                            </span>
                        </template>
                        <template #option="slotProps">
                            <div class="flex p-dropdown-car-option">
                                <Avatar :alt="slotProps.option.name" :image="'/storage/'+slotProps.option.imagen" class="p-avatar-image p-avatar-circle"/>
                                <span>&nbsp;&nbsp;{{slotProps.option.name}}</span>
                            </div>
                        </template>
                    </Dropdown>
                </div>
            </div>
            <div class="row p-fluid">
                <!-- Input name -->
                <div class="mt-4 col-md-12">
                    <div class="p-inputgroup">
                        <span class="p-float-label">
                            <InputText
                                :class="{'p-invalid': form.errors.name}"
                                name="name"
                                type="text"
                                v-model="form.name"
                            />

                            <label>Título</label>
                        </span>
                    </div>
                    <small class="p-error" v-if="form.errors.name">
                        {{form.errors.name}}
                    </small>
                </div>
                <!-- Fin input name -->
                <!-- Input name -->
                <div class="mt-4 col-md-12">
                    <label class="mb-2">Contenido</label>
                    <Editor 
                        v-model="form.contenido"
                        name="contenido"
                        :class="{'p-invalid': form.errors.name}"
                        editorStyle="height: 320px"
                    />
                    <small class="p-error" v-if="form.errors.contenido">
                        {{form.errors.contenido}}
                    </small>
                </div>
                <!-- Fin de inputs de dirección -->
                <!-- Inputs de dirección -->
                <div class="row p-fluid mt-2">
                    <div class="col-12 mt-4">
                        <FileUpload name="imagen" url="./upload" accept="image/*" :maxFileSize="2500000" :fileLimit="1" @input="form.imagen = $event.target.files[0]">
                            <template #empty>
                                <p>Subir imagen del anuncio</p>
                            </template>
                        </FileUpload>
                        <small class="p-error" v-if="form.errors.imagen">
                            {{form.errors.imagen}}
                        </small>
                    </div>
                </div>
                <!-- Fin de inputs de dirección -->
            </div>
            <div class="float-end space-x-2 py-3">
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
import Dropdown from 'primevue/dropdown';
import Avatar from 'primevue/avatar';
import Editor from 'primevue/editor';
import FileUpload from '@/Components/primevue/Input/FileUpload.vue';

export default {
    data() {
        return {
            loading: false,
            display: false,
            empresa : "",
            form: useForm({
                name: "",
                empresa_id: "",
                contenido: "",
                imagen: null,
            }),
        };
    },
    components: {
        Button,
        InputText,
        Dialog,
        Divider,
        Textarea,
        Dropdown,
        Avatar,
        Editor,
        FileUpload
    },
    props: {
        dataModal: Object,
    },
    watch: {
        empresa(newVal){
            this.form.empresa_id = newVal.id
        }
    },
    methods: {
        cerrarModal() {
            this.$emit("visible", false);
            this.form.reset();
            this.errors = {}
        },
        submit() {
            this.form.transform((data) => ({
                ...data,
                empresa_id: 1,
            })).post(route("anuncios.store"), {
                onSuccess: () => {
                    console.log(this.form)
                    this.cerrarModal();
                    this.form.reset();
                },
                onError: (error) => {
                    console.log(error)
                },
            });
        },
    },
};
</script>
