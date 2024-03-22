<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetActionSection from '@/Jetstream/ActionSection.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

import InlineMessage from 'primevue/inlinemessage';
import Password from 'primevue/password'
import Button from 'primevue/button'

defineProps({
    sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmLogout = () => {
    confirmingLogout.value = true;
};

const logoutOtherBrowserSessions = () => {
    form.delete(route('other-browser-sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value,
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogout.value = false;

    form.reset();
};
</script>

<template>
    <JetActionSection>
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="pi pi-key mr-2"></i>
                <b class="text-lg">Sesiones activas</b>
            </div>
        </template>
        <template #content>
            <!-- Profile Photo -->

            <div class="max-w-xl text-sm md:text-base">
                <span>Si es necesario usted puede cerrar sesión en todos los dispositivos. Algunas de sus sesiones recientes están enlistadas debajo.</span>
                <br>
                <span>Si siente que la seguridad de su cuenta está comprometida le recomendamos cerrar sesión en todos los dispositivos y actualizar su contraseña.</span>
            </div>

            <!-- Other Browser Sessions -->
            <div v-if="sessions.length > 0" class="mt-5 space-y-6">
                <div v-for="(session, i) in sessions" :key="i" class="flex items-center">
                    <div>
                        <svg
                            v-if="session.agent.is_desktop"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            class="w-8 h-8"
                        >
                            <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>

                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            fill="none"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="w-8 h-8"
                        >
                            <path d="M0 0h24v24H0z" stroke="none" /><rect
                                x="7"
                                y="4"
                                width="10"
                                height="16"
                                rx="1"
                            /><path d="M11 5h2M12 17v.01" />
                        </svg>
                    </div>

                    <div class="ml-1">
                        <div class="text-sm font-semibold">
                            {{ session.agent.platform ? session.agent.platform : 'Unknown' }} - {{ session.agent.browser ? session.agent.browser : 'Unknown' }}
                        </div>

                        <div>
                            <div class="text-xs">
                                {{ session.ip_address }},

                                <span v-if="session.is_current_device" class="text-green-500 font-semibold">Este dispositivo</span>
                                <span v-else>Última conexión {{ session.last_active }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center mt-5 justify-content-end">
                <JetActionMessage :on="form.recentlySuccessful" class="ml-3">
                    <InlineMessage severity="success" class="w-auto">Se han cerrado las sesiones en los demás navegadores.</InlineMessage>
                </JetActionMessage>
                <Button
                    icon="pi pi-sign-out"
                    class="p-button-raised p-button-rounded p-button-danger p-button-text"
                    label="Cerrar sesión en los demás navegadores"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="confirmLogout"
                />
            </div>

            <!-- Log Out Other Devices Confirmation Modal -->
            <JetDialogModal :show="confirmingLogout" @close="closeModal" header="Cerrar sesión en los demás navegadores">

                <template #content>
                    <p>Por favor, ingrese su contraseña para confirmar que desea cerrar las sesiones activas en los demás navegadores.</p>
                    
                    <Password
                        inputClass="col-sm-12 col-md-6 mt-2"
                        :class="{'p-invalid': form.errors.password}"
                        v-model="form.password"
                        :feedback="false"
                        placeholder="Contraseña"
                        @keyup.enter="logoutOtherBrowserSessions"
                    />

                    <JetInputError :message="form.errors.password" class="mt-2" />
                
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
                            icon="pi pi-sign-out"
                            class="p-button-raised p-button-rounded p-button-danger"
                            label="Cerrar sesión en los demás navegadores"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="logoutOtherBrowserSessions"
                        />
                    </div>

                </template>
            </JetDialogModal>
        </template>
    </JetActionSection>
</template>
