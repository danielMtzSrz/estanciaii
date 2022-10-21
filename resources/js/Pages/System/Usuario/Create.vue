<template>
    <!-- Modal crear -->
    <Dialog
        v-model:visible="dataModal.display"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="false"
    >
        <div class="flex justify-between mt-0 mb-2">
            <h3 class="font-bold">Nuevo usuario</h3>
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
                <div class="mt-4 col-md-6">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-user"></i>
                        </span>
                        <span class="p-float-label">
                            <InputText
                                name="name"
                                id="name"
                                type="text"
                                v-model="form.name"
                                required
                            />
                            <label>Nombre completo</label>
                        </span>
                    </div>
                </div>
                <!-- Fin input name -->
                <!-- Input email -->
                <div class="mt-4 col-md-6">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-at"></i>
                        </span>
                        <span class="p-float-label">
                            <InputText
                                name="email"
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                            />
                            <label>Email</label>
                        </span>
                    </div>
                </div>
                <!-- Fin input email -->
                <!-- Input contraseña -->
                <div class="mt-4 col-md-6">
                    <div class="p-inputgroup">
                        <span class="p-inputgroup-addon">
                            <i class="pi pi-key"></i>
                        </span>
                        <span class="p-float-label">
                            <Password
                                v-model="form.password"
                                name="password"
                                id="password"
                                required
                            >
                                <template #header>
                                    <h6>Establecer contraseña</h6>
                                </template>
                                <template #footer>
                                    <Divider />
                                    <p class="mt-2">Sugerencias</p>
                                    <ul
                                        class="pl-2 ml-2 mt-0"
                                        style="line-height: 1.5"
                                    >
                                        <li>
                                            Al menos 1 carácter en minúscula
                                        </li>
                                        <li>
                                            Al menos 1 carácter en mayúsculas
                                        </li>
                                        <li>Al menos 1 valor numérico</li>
                                        <li>Al menos 8 carácteres</li>
                                    </ul>
                                </template>
                            </Password>
                            <label>Contraseña</label>
                        </span>
                    </div>
                </div>
                <!-- Fin Input contraseña -->
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
            <!-- Sección asignar permisos -->
            <Divider align="left">
                <div class="inline-flex align-items-center">
                    <i class="pi pi-key mr-2"></i>
                    Seleccionar roles
                </div>
            </Divider>
            <div class="row p-fluid">
                <div class="mt-2 col-md-12">
                    <div class="field-checkbox" v-for="rol in dataModal.roles" :key="rol.id">
                        <Checkbox name="roles[]" :value="rol.id" v-model="form.roles" class="mr-2"/>
                        <label>{{ rol.name}}</label>
                    </div>
                </div>
            </div>
            <!-- Fin sección asignar permisos -->
        </form>
    </Dialog>
    <!-- Fin modal crear -->
</template>

<script>
// Inertia
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Password from "primevue/password";
import Divider from "primevue/divider";
import Checkbox from "primevue/checkbox";

export default {
    setup() {
        const prueba2 = computed(() => usePage().props.value.prueba);
        return { prueba2 };
    },
    data() {
        return {
            loading: false,
            display: false,
            form: useForm({
                name: "",
                email: "",
                password: "",
                roles : [],
            }),
        };
    },
    components: {
        Button,
        InputText,
        Dialog,
        Password,
        Divider,
        Checkbox
    },
    props: {
        dataModal: Object,
        permisos : Object
    },
    methods: {
        cerrarModal() {
            this.$emit("visible", false);
        },
        submit() {
            this.form.post(route("user.store"), {
                onSuccess: () => {
                    this.cerrarModal();
                    this.form.reset();
                },
            });
        },
    },
};
</script>
