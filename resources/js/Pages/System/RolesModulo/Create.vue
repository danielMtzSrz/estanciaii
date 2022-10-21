<template>
    <Head title="Usuarios"></Head>
    <app-layout>
        <h1 class="display-6 text-center my-2">Crear rol</h1>
        <div class="card">
            <form @submit.prevent="submit(false)">
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
        <!-- Sección asignar permisos -->
        <Divider align="left">
            <div class="inline-flex align-items-center">
                <i class="pi pi-globe mr-2"></i>
                Seleccionar permisos
            </div>
        </Divider>
        <div class="row p-fluid">
            <div class="mt-4 col-md-12">
                <div class="field-checkbox" v-for="permiso in permisos" :key="permiso.id">
                    <Checkbox name="permissions[]" :value="permiso.id" v-model="form.permissions" class="mr-2"/>
                    <label>{{ permiso.description}}</label>
                </div>
            </div>
        </div>
        <!-- Fin sección asignar permisos -->
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
import Checkbox from 'primevue/checkbox';
import Divider from 'primevue/divider';
import Tooltip from "primevue/tooltip";

export default {
    setup() {
        const prueba2 = computed(() => usePage().props.value.prueba);
        return { prueba2 };
    },
    directives: {
        tooltip: Tooltip,
    },
    data() {
        return {
            loading : null,
            form : useForm({
                name: '',
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
        permisos: Object,
    },
    mounted() {
        this.loading = true;
        setTimeout((this.loading = false), 2000);
    },
    methods: {
        submit() {
            this.form.post(route("role.store"), this.form, {
                onSuccess: () => {
                    this.form.reset();
                },
            });
        },
    },
};
</script>
