<script setup>
import { nextTick, ref } from 'vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';

import InputText from 'primevue/inputtext'
import Button from 'primevue/button'

import AuthLayout from '@/Layouts/AuthLayout.vue';

const recovery = ref(false);

const form = useForm({
    code: '',
    recovery_code: '',
});

const recoveryCodeInput = ref(null);
const codeInput = ref(null);

const toggleRecovery = async () => {
    recovery.value ^= true;

    await nextTick();

    if (recovery.value) {
        recoveryCodeInput.value.focus();
        form.code = '';
    } else {
        codeInput.value.focus();
        form.recovery_code = '';
    }
};

const submit = () => {
    form.post(route('two-factor.login'));
};
</script>

<template>
    <Head title="Two-factor Confirmation" />

    <AuthLayout>
        <template #content>            
            <JetAuthenticationCard>
                <template #logo>
                    <JetAuthenticationCardLogo />
                </template>

                <div class="mb-4 text-sm">
                    <template v-if="! recovery">
                        Por favor, confirme el acceso a su cuenta ingresando el código que provee tu aplicación de "Google Authenticator".
                    </template>

                    <template v-else>
                        Por favor, confirme el acceso a su cuenta ingresando uno de sus código de emergencia.
                    </template>
                </div>
                <JetValidationErrors class="mb-4" />

                <form @submit.prevent="submit">
                    <div v-if="! recovery">
                        <div class="mt-4 col-md-12">
                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon">
                                    <i class="pi pi-hashtag"></i>
                                </span>
                                <span class="p-float-label">
                                    <InputText
                                        name="code"
                                        id="code"
                                        type="text"
                                        v-model="form.code"
                                        required
                                        autofocus
                                    />
                                    <label>Código de autenticación</label>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                        <div class="mt-4 col-md-12">
                            <div class="p-inputgroup">
                                <span class="p-inputgroup-addon">
                                    <i class="pi pi-code"></i>
                                </span>
                                <span class="p-float-label">
                                    <InputText
                                        name="recovery_code"
                                        id="recovery_code"
                                        type="text"
                                        v-model="form.recovery_code"
                                        required
                                        autofocus
                                    />
                                    <label>Código de emergencia</label>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="button" class="text-sm hover:text-indigo-600 underline cursor-pointer" @click.prevent="toggleRecovery">
                            <template v-if="! recovery">
                                Usar código de emergencia
                            </template>

                            <template v-else>
                                Usar código de autenticación
                            </template>
                        </button>

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
