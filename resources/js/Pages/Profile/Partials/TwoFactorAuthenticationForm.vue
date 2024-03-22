<script setup>
import { ref, computed, watch } from 'vue';

import { Inertia } from '@inertiajs/inertia';
import { useForm, usePage } from '@inertiajs/inertia-vue3';

import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetConfirmsPassword from '@/Jetstream/ConfirmsPassword.vue';

import InlineMessage from 'primevue/inlinemessage';
import Button from 'primevue/button';

import InputText from "@/Components/Forms/InputText.vue";

const props = defineProps({
    requiresConfirmation: Boolean,
});

const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
    code: '',
});

const twoFactorEnabled = computed(
    () => ! enabling.value && usePage().props.value.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
    if (! twoFactorEnabled.value) {
        confirmationForm.reset();
        confirmationForm.clearErrors();
    }
});

const enableTwoFactorAuthentication = () => {
    enabling.value = true;

    Inertia.post('/user/two-factor-authentication', {}, {
        preserveScroll: true,
        onSuccess: () => Promise.all([
            showQrCode(),
            showSetupKey(),
            showRecoveryCodes(),
        ]),
        onFinish: () => {
            enabling.value = false;
            confirming.value = props.requiresConfirmation;
        },
    });
};

const showQrCode = () => {
    return axios.get('/user/two-factor-qr-code').then(response => {
        qrCode.value = response.data.svg;
    });
};

const showSetupKey = () => {
    return axios.get('/user/two-factor-secret-key').then(response => {
        setupKey.value = response.data.secretKey;
    });
}

const showRecoveryCodes = () => {
    return axios.get('/user/two-factor-recovery-codes').then(response => {
        recoveryCodes.value = response.data;
    });
};

const confirmTwoFactorAuthentication = () => {
    confirmationForm.post('/user/confirmed-two-factor-authentication', {
        errorBag: "confirmTwoFactorAuthentication",
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            confirming.value = false;
            qrCode.value = null;
            setupKey.value = null;
        },
    });
};

const regenerateRecoveryCodes = () => {
    axios
        .post('/user/two-factor-recovery-codes')
        .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
    disabling.value = true;

    Inertia.delete('/user/two-factor-authentication', {
        preserveScroll: true,
        onSuccess: () => {
            disabling.value = false;
            confirming.value = false;
        },
    });
};
</script>

<template>
    <JetActionSection>
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="bi bi-phone mr-2"></i>
                <b class="text-lg">Autenticación en dos pasos</b>
            </div>
        </template>

        <template #content>
            <InlineMessage severity="success" class="w-auto" icon="pi pi-eye" v-if="twoFactorEnabled && ! confirming">Ha habilitado la autenticación de dos pasos.</InlineMessage>
            <InlineMessage severity="warn" class="w-auto" v-else-if="twoFactorEnabled && confirming">No ha habilitado la autenticación de dos pasos.</InlineMessage>
            <InlineMessage severity="warn" class="w-auto" v-else>No ha habilitado la autenticación de dos pasos.</InlineMessage>

            <div class="mt-3 text-sm text-gray-600">
                <p class="text-sm md:text-base">
                    Cuando la autenticación en dos factores está habilitada, se le
                    solicita un token seguro y aleatorio durante la autenticación.
                    Puede obtener este token desde su teléfono de la aplicación "Autenticador de Google".
                </p>
            </div>

            <div v-if="twoFactorEnabled">
                <div v-if="qrCode" class="row col-md-10 md:col-md-12 mx-auto">
                    <div class="text-sm col-md-8 m-auto px-0">
                        <p v-if="confirming" class="text-sm md:text-base mx-auto px-0">
                            Para terminar de habilitar la autenticación en dos factores, escanee
                            el siguiente código QR usando la aplicación de su teléfono "Autenticador de Google"
                            e ingrese el código que le aparece en la aplicación.
                        </p>

                        <p v-else>
                            La autenticación en dos factores ahora está habilitada. Escanea el
                            siguiente código QR usando la aplicación de "Autenticador de Google" 
                            o introduzca el código de recuperación.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <div class="mt-4 row bg-white mx-auto" style="width: 200px;" v-html="qrCode"/>

                        <!-- <div class="mt-4 text-sm text-gray-600 mx-auto" v-if="setupKey">
                            <p class="font-semibold text-center">
                                Clave: <span v-html="setupKey"></span>
                            </p>
                        </div> -->
                    </div>

                    <div v-if="confirming" class="mt-2 row">
                        <div class="col-sm-12 flex justify-end">
                            <div class="mt-4 w-full md:w-14rem">
                                <InputText
                                    label="Código"
                                    name="name"
                                    v-model="confirmationForm.code"
                                    :errors="confirmationForm.errors.code"
                                    @keyup.enter="confirmTwoFactorAuthentication"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="recoveryCodes.length > 0 && ! confirming" class="mt-0 md:mt-4 row col-12 md:col-10">
                    <div class="col-md-7 my-auto">
                        <p class="text-sm md:text-base w-full md:w-96 mx-auto">
                            Guarde estos códigos de recuperación. 
                            Se pueden utilizar para recuperar el acceso a su
                            cuenta si su dispositivo de autenticación en dos pasos se perdió.
                        </p>
                    </div>

                    <div class="col-md-5 font-mono text-sm rounded-lg">
                        <div v-for="(code, index) in recoveryCodes" :key="code" class="text-center md:text-right">
                            Código {{index+1}}: {{ code }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3 flex justify-end col-11 px-4 md:col-md-12">
                <div v-if="! twoFactorEnabled" class="float-right">
                    <JetConfirmsPassword @confirmed="enableTwoFactorAuthentication">
                        <Button
                            icon="pi pi-key"
                            class="p-button-raised p-button-rounded p-button-success p-button-text"
                            label="Habilitar"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        />
                    </JetConfirmsPassword>
                </div>

                <div v-else>
                    <JetConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
                        <Button
                            v-if="confirming"
                            icon="pi pi-check"
                            class="p-button-raised p-button-rounded p-button-sm p-button-success p-button-text mr-3"
                            label="Confirmar"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        />
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="regenerateRecoveryCodes">
                        <Button
                            v-if="recoveryCodes.length > 0 && ! confirming"
                            icon="bi bi-arrow-clockwise"
                            class="p-button-raised p-button-rounded p-button-sm p-button-info p-button-text mr-2"
                            label="Actualizar códigos de recuperación"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        />
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="showRecoveryCodes">
                        <Button
                        v-if="recoveryCodes.length === 0 && ! confirming"
                            icon="bi bi-eye"
                            class="p-button-raised p-button-rounded p-button-sm p-button-info p-button-text mr-2"
                            label="Mostrar códigos de recuperación"
                            :class="{ 'opacity-25': enabling }"
                            :disabled="enabling"
                        />
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <Button
                            v-if="confirming"
                            class="p-button-raised p-button-rounded p-button-sm p-button-warning p-button-text mr-3"
                            label="Cancelar"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        />
                    </JetConfirmsPassword>

                    <JetConfirmsPassword @confirmed="disableTwoFactorAuthentication">
                        <Button
                            v-if="! confirming"    
                            type="submit"
                            class="p-button-raised p-button-rounded p-button-sm p-button-warning p-button-text"
                            label="Deshabilitar"
                            :class="{ 'opacity-25': disabling }"
                            :disabled="disabling"
                        />
                    </JetConfirmsPassword>
                </div>
            </div>
        </template>
    </JetActionSection>
</template>
