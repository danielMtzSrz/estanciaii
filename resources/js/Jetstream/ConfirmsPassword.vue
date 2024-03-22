<script setup>
import { ref, reactive, nextTick } from 'vue';

import JetDialogModal from './DialogModal.vue';
import JetInputError from './InputError.vue';

import Button from 'primevue/button';
import Password from 'primevue/password';

const emit = defineEmits(['confirmed']);

defineProps({
    title: {
        type: String,
        default: 'Confirmar contraseña',
    },
    content: {
        type: String,
        default: 'Por su seguridad, por favor ingrese su contraseña para continuar.',
    },
    button: {
        type: String,
        default: 'Confirmar',
    },
});

const confirmingPassword = ref(false);

const form = reactive({
    password: '',
    error: '',
    processing: false,
});

const passwordInput = ref(null);

const startConfirmingPassword = () => {
    axios.get(route('password.confirmation')).then(response => {
        if (response.data.confirmed) {
            emit('confirmed');
        } else {
            confirmingPassword.value = true;

            setTimeout(() => passwordInput.value.focus(), 250);
        }
    });
};

const confirmPassword = () => {
    form.processing = true;

    axios.post(route('password.confirm'), {
        password: form.password,
    }).then(() => {
        form.processing = false;

        closeModal();
        nextTick().then(() => emit('confirmed'));

    }).catch(error => {
        form.processing = false;
        form.error = error.response.data.errors.password[0];
        passwordInput.value.focus();
    });
};

const closeModal = () => {
    confirmingPassword.value = false;
    form.password = '';
    form.error = '';
};
</script>

<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot />
        </span>

        <JetDialogModal :show="confirmingPassword" @close="closeModal" :header="title">

            <template #content>
                <p>{{ content }}</p>

                <Password
                    inputClass="col-sm-12 col-md-6 mt-2"
                    :class="{'p-invalid': form.error}"
                    v-model="form.password"
                    :feedback="false"
                    placeholder="Contraseña"
                    @keyup.enter="confirmPassword"
                />
                
                <JetInputError :message="form.error" class="mt-2" />

                <div class="flex flex-row justify-end space-x-2 text-right mt-4">
                    <Button
                        type="submit"
                        class="p-button-raised p-button-rounded p-button-warning p-button-text"
                        label="Cancelar"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="closeModal"
                    />

                    <Button
                        type="submit"
                        icon="pi pi-save"
                        class="p-button-raised p-button-rounded p-button-success ml-2"
                        :label="button"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="confirmPassword"
                    />
                </div>
            </template>
        </JetDialogModal>
    </span>
</template>
