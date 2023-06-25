<template>
    <Head title="Usuarios"></Head>
    <app-layout>
        <h1 class="display-6 text-center my-2">Actualizar rol</h1>
        <div class="card">
            <form @submit.prevent="submit()">
                <div class="row p-fluid">
                    <!-- Input name -->
                    <div class="mt-4 col-md-12">
                        <div class="p-inputgroup">
                            <span class="p-inputgroup-addon">
                                <i class="pi pi-user"></i>
                            </span>
                            <span class="p-float-label">
                                <InputText name="name" id="name" type="text" v-model="form.name" required />
                                <label>Nombre del rol</label>
                            </span>
                        </div>
                    </div>
                    <!-- Fin input name -->
                </div>
                <div class="float-end space-x-2 mt-3 mb-3">
                    <Link :href="route('role.index')">
                        <Button type="button" label="Regresar"
                            class="p-button-text p-button-raised p-button-rounded p-button-warning"/>
                    </Link>
                    <Button type="submit" label="Guardar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="form.processing" />
                </div>
            </form>
        </div>
        <Divider align="left">
            <div class="inline-flex align-items-center">
                <i class="pi pi-globe mr-2"></i>
                Seleccionar permisos
            </div>
        </Divider>
            <div class="row p-fluid">
                <!-- Input name -->
                <div class="mt-4 col-md-12">
                    <div class="field-checkbox" v-for="(permiso) in permisos" :key="permiso.id">
                        <input type="checkbox" name="permissions[]" class="form-check-input mr-2" style="box-shadow: inset 0px 1px 4px rgba(60, 92, 135, 1)" :value="permiso.id" v-model="form.permissions" :checked="permisosAsignados.includes(permiso.id)">
                        <label>{{ permiso.description}}</label>
                    </div>
                </div>
            </div>
    </app-layout>
</template>

<script>

// Layout padre
import AppLayout from "@/Layouts/AppLayout.vue";

// Inertia
import { computed } from "vue";
import { useForm, Head, Link, usePage } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Divider from 'primevue/divider';
import Tooltip from "primevue/tooltip";

// Personalizados
import Checkbox from "@/Components/primevue/Input/Checkbox.vue";

export default {
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading : null,
            form : useForm({
                name: this.role.name,
                permissions : [],
            }),
        };
    },
    components: {
        AppLayout,
        Head,
        Link,
        Button,
        InputText,
        Divider,
        Checkbox
    },
    props: {
        title: String,
        role: Object,
        permisos: Object,
        role_has_permission : Object,
    },
    computed : {
        permisosAsignados(){
            const permission_id = this.role_has_permission.map(element => {
                return element.permission_id
            });
            this.form.permissions = permission_id
            return permission_id
        }
    },
    mounted() {
        this.loading = true;
        setTimeout((this.loading = false), 2000);
    },
    methods: {
        submit() {
            this.form.put(route("role.update", this.role), this.form, {
                onSuccess: () => {
                    this.form.reset();
                },
            });
        },
    },
};
</script>
