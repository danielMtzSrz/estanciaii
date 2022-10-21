<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import JetButton from '@/Jetstream/Button.vue';
import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';

import Button from 'primevue/button';
import InputText from "@/Assets/Components/Forms/InputText.vue";

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    Inertia.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <JetFormSection @submitted="updateProfileInformation">
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="pi pi-user mr-2"></i>
                <b class="text-lg">Información del perfil</b>
            </div>
        </template>
        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-12 sm:col-span-12">
                <!-- Profile Photo File Input -->
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >

                <p class="text-500">Foto</p>

                <!-- Current Profile Photo -->
                <div v-show="!photoPreview" class="mt-2">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <Button
                    type="button"
                    icon="bi bi-image-fill"
                    class="mt-2 me-2 p-button-raised p-button-rounded p-button-info p-button-text"
                    label="Actualizar foto"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click.prevent="selectNewPhoto"
                />

                <Button
                    v-if="user.profile_photo_path"
                    type="button"
                    icon="bi bi-trash3"
                    class="mt-2 p-button-raised p-button-rounded p-button-danger p-button-text"
                    label="Eliminar foto"
                    :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    @click.prevent="deletePhoto"
                />

                <JetInputError :message="form.errors.photo" class="mt-2" />
            </div>

            <div class="row col-sm-12 mt-2">
                <!-- Name -->
                <div class="mt-4 col-sm-4">
                    <InputText
                        icon="pi pi-user"
                        label="Nombre"
                        name="name"
                        :errors="form.errors.name"
                        :value="form.name"
                        @input="form.name = $event"
                    />
                </div>

                <!-- Email -->
                <div class="mt-4 col-sm-4">
                    <InputText
                        icon="pi pi-at"
                        label="Correo electrónico"
                        name="email"
                        :errors="form.errors.email"
                        :value="form.email"
                        @input="form.email = $event"
                        :disabled="true"
                    />

                    <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                        <p class="text-sm mt-2">
                            Your email address is unverified.

                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="underline text-gray-600 hover:text-gray-900"
                                @click.prevent="sendEmailVerification"
                            >
                                Click here to re-send the verification email.
                            </Link>
                        </p>

                        <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                            A new verification link has been sent to your email address.
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
                Información actualizada.
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
