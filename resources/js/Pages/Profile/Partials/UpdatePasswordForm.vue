<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';

import Button from 'primevue/button';
import Password from 'primevue/password';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <JetFormSection @submitted="updatePassword">
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="pi pi-key mr-2"></i>
                <b class="text-lg">Actualizar contraseña</b>
            </div>
        </template>
        <template #form>
            <!-- Profile Photo -->

            <div class="flex-row-reverse">
                <div class="row col-sm-12">
                    <div class="col-md-6 space-y-6">
                        <div class="col-sm-12">
                            <div class="p-inputgroup">
                                <span class="p-float-label">
                                    <Password
                                        v-model="form.current_password"
                                        name="current_password"
                                        id="current_password"
                                        required
                                        :feedback="false"
                                        toggleMask
                                    />
                                    <label>Contraseña actual</label>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="p-inputgroup">
                                <span class="p-float-label">
                                    <Password
                                        v-model="form.password"
                                        name="password"
                                        id="password"
                                        required
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
                                    <label>Nueva contraseña</label>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="p-inputgroup">
                                <span class="p-float-label">
                                    <Password
                                        v-model="form.password_confirmation"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        required
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
                                    <label>Confirmar contraseña</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Contraseña actualizada.
            </JetActionMessage>

            <Button
                type="submit"
                icon="pi pi-check"
                class="p-button-raised p-button-rounded p-button-success p-button-text"
                label="Actualizar"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            />
        </template>
    </JetFormSection>
</template>
