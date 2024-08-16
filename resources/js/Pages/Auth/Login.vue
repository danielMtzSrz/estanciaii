<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

import { computed, ref, watch } from "vue";

import AuthLayout from '@/Layouts/AuthLayout.vue';

import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Checkbox from 'primevue/checkbox';
import Button from "primevue/button";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout :title="'Iniciar sesión'">
        <template #content>            
            <JetAuthenticationCard>
                <template #logo>
                    <JetAuthenticationCardLogo />
                </template>

                <JetValidationErrors class="mb-4" />

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div class="row p-fluid">
                        <!-- Input name -->
                        <div class="mt-4 col-md-12">
                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon">
                                    <i class="pi pi-user"></i>
                                </span>
                                <span class="p-float-label">
                                    <InputText
                                        name="name"
                                        id="name"
                                        type="text"
                                        v-model="form.email"
                                        required
                                        autofocus
                                    />
                                    <label>Correo electrónico</label>
                                </span>
                            </div>
                        </div>
                        <!-- Fin input name -->
                        <!-- Input contraseña -->
                        <div class="mt-4 col-md-12">
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
                                        autocomplete="current-password"
                                        :feedback="false"
                                        toggleMask
                                    >
                                    </Password>
                                    <label>Contraseña</label>
                                </span>
                            </div>
                        </div>
                        <!-- Fin Input contraseña -->
                    </div>

                    <div class="block mt-4">
                        <label class="d-flex align-items-center align-content-center">
                            <input 
                                type="checkbox"
                                name="remember"
                                class="form-check-input" 
                                style="box-shadow: inset 0px 1px 4px rgba(60, 92, 135, 1)" 
                                v-model="form.remember"
                            >
                            <!-- <JetCheckbox v-model:checked="form.remember" name="remember" /> -->
                            <span class="ml-2 text-sm text-gray-600">Recórdarme</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-500 hover:text-gray-700">
                            ¿Olvidó su contraseña?
                        </Link>

                        <Button
                            type="submit"
                            class="ms-3 mb-2 p-button-text p-button-raised p-button-rounded p-button-primary"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            label="Iniciar sesión"
                        />
                    </div>
                </form>
            </JetAuthenticationCard>
        </template>
    </AuthLayout>
</template>