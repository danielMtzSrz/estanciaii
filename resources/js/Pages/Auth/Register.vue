<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Checkbox from 'primevue/checkbox';
import Button from "primevue/button";

import AuthLayout from '@/Layouts/AuthLayout.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthLayout :title="'Crear usuario'">
        <template #content>                            
            <JetAuthenticationCard>
                <template #logo>
                    <JetAuthenticationCardLogo />
                </template>
    
                <JetValidationErrors class="mb-4" />
    
                <form @submit.prevent="submit">
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
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <label>Nombre completo</label>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 col-md-12">
                        <div class="p-inputgroup">
                            <span class="p-inputgroup-addon">
                                <i class="pi pi-at"></i>
                            </span>
                            <span class="p-float-label">
                                <InputText
                                    name="email"
                                    id="email"
                                    type="text"
                                    v-model="form.email"
                                    required
                                    autofocus
                                />
                                <label>Correo electrónico</label>
                            </span>
                        </div>
                    </div>
    
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
                                    autocomplete="new-password"
                                    toggleMask
                                >
                                    <template #footer>
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
    
                    <div class="mt-4 col-md-12">
                        <div class="p-inputgroup">
                            <span class="p-inputgroup-addon">
                                <i class="pi pi-key"></i>
                            </span>
                            <span class="p-float-label">
                                <Password
                                    v-model="form.password_confirmation"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    required
                                    autocomplete="current-password"
                                    :feedback="false"
                                    toggleMask
                                >
                                </Password>
                                <label>Confirmar contraseña</label>
                            </span>
                        </div>
                    </div>
    
                    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                        <JetLabel for="terms">
                            <div class="flex items-center">
                                <JetCheckbox id="terms" v-model:checked="form.terms" name="terms" />
    
                                <div class="ml-2">
                                    I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                                </div>
                            </div>
                        </JetLabel>
                    </div>
    
                    <div class="flex items-center justify-end mt-4">
                        <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                            ¿Ya está registrado?
                        </Link>
    
                        <Button
                            type="submit"
                            class="ms-3 mb-2 p-button-text p-button-raised p-button-rounded p-button-primary"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            label="Crear usuario"
                        />
                    </div>
                </form>
            </JetAuthenticationCard>
        </template>
    </AuthLayout>
</template>
