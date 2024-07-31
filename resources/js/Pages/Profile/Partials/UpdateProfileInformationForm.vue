<template>
    <JetFormSection @submitted="updateProfileInformation">
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="pi pi-user mr-2"></i>
                <b class="text-lg">Actualizar información</b>
            </div>
        </template>
        <template #form>

            <div class="col-sm-12 col-md-8">

                <!-- Profile Photo -->
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="sm:flex col-sm-12">
                    
                    <div class="col-sm-12 col-md-2">
                            <!-- Profile Photo File Input -->
                        <input
                            ref="photoInput"
                            type="file"
                            class="hidden"
                            @change="updatePhotoPreview"
                        >

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
                    </div>

                    <div class="col-sm-12 col-md-10 align-items-center mt-3">
                        <div class="col-sm-12 flex align-items-center">
                            <Button
                                type="button"
                                class="mt-2 me-2 p-button-raised p-button-rounded p-button-info p-button-text text-xs md:text-base"
                                label="Actualizar foto"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click.prevent="selectNewPhoto"
                            />

                            <Button
                                v-if="user.profile_photo_url"
                                type="button"
                                class="mt-2 p-button-raised p-button-rounded p-button-danger p-button-text text-xs md:text-base"
                                label="Eliminar foto"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click.prevent="deletePhoto"
                            />
                        </div>
                        <div class="col-sm-12 mt-2">
                            <p class="text-xs font-italic text-600">Solo aceptamos fotos cuadradas</p>
                        </div>
                    </div>

                    <JetInputError :message="form.errors.photo" class="mt-2" />
                </div>

                <div class="row col-sm-12">

                    <Divider align="left" type="solid" class="pl-0 py-4">
                        <b>Información personal</b>
                    </Divider>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Nombre (s)"
                            name="name"
                            :errors="form.errors.name"
                            v-model="form.name"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Apellido paterno"
                            name="apellido_paterno"
                            :errors="form.errors.apellido_paterno"
                            v-model="form.apellido_paterno"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Apellido materno"
                            name="apellido_materno"
                            :errors="form.errors.apellido_materno"
                            v-model="form.apellido_materno"
                        />
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
                        <Calendar
                            label="Fecha de nacimiento"
                            v-model="form.fecha_nacimiento"
                            :showTime="false"
                            :errors="form.errors.fecha_nacimiento"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="CURP"
                            name="curp"
                            :errors="form.errors.curp"
                            v-model="form.curp"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="RFC"
                            name="rfc"
                            :errors="form.errors.rfc"
                            v-model="form.rfc"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Correo electrónico"
                            name="email"
                            v-model="form.email"
                            :errors="form.errors.email"
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

                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="Teléfono celular"
                            name="telefono_celular"
                            :errors="form.errors.telefono_celular"
                            v-model="form.telefono_celular"
                            :useGrouping="false"
                        />
                    </div>
                    
                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="Teléfono local"
                            name="telefono_local"
                            :errors="form.errors.telefono_local"
                            v-model="form.telefono_local"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="NSS"
                            name="nss"
                            :errors="form.errors.nss"
                            v-model="form.nss"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estado civil"
                            name="estado_civil_id"
                            :data="dataEstadosCiviles"
                            textDropdown="nombre"
                            v-model="estado_civil_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Genero"
                            :data="dataGeneros"
                            textDropdown="nombre"
                            v-model="genero_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Tipo de sangre"
                            :data="dataTiposSangre"
                            textDropdown="nombre"
                            v-model="tipo_sangre_seleccionado"
                        />
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <Divider align="left" type="solid" class="pl-0 mb-4">
                    <b>Domicilio</b>
                </Divider>

                <div class="col-sm-12">
                    <Dropdown 
                        label="Países"
                        :data="data_paises"
                        textDropdown="nombre"
                        v-model="pais_seleccionado"
                    />
                </div>

                <div class="col-sm-12">
                    <Dropdown 
                        label="Estados"
                        :data="data_estados"
                        textDropdown="nombre"
                        v-model="estado_seleccionado"
                        :disabled="!data_estados"
                    />
                </div>

                <div class="col-sm-12">
                    <Dropdown 
                        label="Municipios"
                        :data="data_municipios"
                        textDropdown="nombre"
                        v-model="municipio_seleccionado"
                        :disabled="!data_municipios"
                    />
                </div>

                <div class="col-sm-12">
                    <Dropdown 
                        label="Colonias"
                        :data="data_colonias"
                        textDropdown="nombre"
                        v-model="colonia_seleccionada"
                        :errors="form.errors.colonia_id"
                        :disabled="!data_colonias"
                    />
                </div>

                <div class="col-sm-12">
                    <InputText
                        label="Calle"
                        name="calle"
                        v-model="form.calle"
                        :errors="form.errors.calle"
                    />
                </div>

                <div class="col-sm-12">
                    <InputNumber
                        label="N° Exterior"
                        name="numero_exterior"
                        v-model="form.numero_exterior"
                        :errors="form.errors.numero_exterior"
                        :useGrouping="false"
                    />
                </div>

                <div class="col-sm-12">
                    <InputNumber
                        label="N° Interior"
                        name="numero_interior"
                        v-model="form.numero_interior"
                        :errors="form.errors.numero_interior"
                        :useGrouping="false"
                    />
                </div>
            </div>
        </template>

        <template #actions>
            <Message
                v-if="form.recentlySuccessful" 
                severity="success"
                class="mr-2"
            >
            Información actualizada.
            </Message>

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

<script setup>
import { onBeforeMount, onMounted, ref, watch } from 'vue';

import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';

import JetFormSection from '@/Jetstream/FormSection.vue';
import JetInputError from '@/Jetstream/InputError.vue';

import Button from 'primevue/button';
import Divider from 'primevue/divider';
import Message from 'primevue/message';

import InputText from "@/Components/Forms/InputText.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import Calendar from "@/Components/Forms/Calendar.vue";

// Variables
const data_paises = ref(null), pais_seleccionado = ref(null),
      data_estados = ref(null), estado_seleccionado = ref(null),
      data_municipios = ref(null), municipio_seleccionado = ref(null),
      data_colonias = ref(null), colonia_seleccionada = ref(null),
      dataEstadosCiviles = ref(null), estado_civil_seleccionado = ref(null), 
      dataGeneros = ref(null), genero_seleccionado = ref(null), 
      dataTiposSangre = ref(null), tipo_sangre_seleccionado = ref(null),
      fecha_nacimiento = ref(null)

onBeforeMount(async () => {
    const dataPaisesAxios = await axios.get(`/api/domicilio/paises`);
    data_paises.value = dataPaisesAxios.data

    const dataGenerosApi = await axios.get(`/api/generos`);
    dataGeneros.value = dataGenerosApi.data

    const dataEstadosCivilesApi = await axios.get(`/api/estados_civiles`);
    dataEstadosCiviles.value = dataEstadosCivilesApi.data

    const dataTiposSangreApi = await axios.get(`/api/tipos_sangre`);
    dataTiposSangre.value = dataTiposSangreApi.data
})

onMounted(async () => {

    if(props.user.colonia_id){
        try{
            const obtener_colonia = await axios.get(`/api/domicilio/obtener_colonia/${props.user.colonia_id}`)
            const colonia = obtener_colonia.data[0];
            pais_seleccionado.value = colonia.municipio.estado?.pais ?? null
            estado_seleccionado.value = colonia.municipio?.estado ?? null
            municipio_seleccionado.value = colonia?.municipio ?? null
            colonia_seleccionada.value = colonia ?? null
        }catch(e){
            console.error("Actualiza para obtener los datos", e)
        }
    }

    form.colonia_id = props.user?.colonia_id ?? null
    
    form.tipo_sangre_id = props.user?.tipo_sangre_id ?? null
    form.estado_civil_id = props.user?.estado_civil_id ?? null
    form.generos_id = props.user?.generos_id ?? null
    
    form.apellido_paterno = props.user?.apellido_paterno ?? null
    form.apellido_materno = props.user?.apellido_materno ?? null
    form.fecha_nacimiento = props.user?.fecha_nacimiento ?? null
    form.curp = props.user?.curp ?? null
    form.rfc = props.user?.rfc ?? null
    form.nss = props.user?.nss ?? null
    form.telefono_local = props.user?.telefono_local ?? null
    form.telefono_celular = props.user?.telefono_celular ?? null
    form.name = props.user?.name ?? null
    form.email = props.user?.email ?? null
    
    form.calle = props.user?.calle ?? null
    form.numero_exterior = props.user?.numero_exterior ?? null
    form.numero_interior = props.user?.numero_interior ?? null
    form.profile_photo_path = props.user?.profile_photo_url ?? null
})

watch(() => dataGeneros.value, async (newVal) => {
    genero_seleccionado.value = newVal.find(el => el.id == props.user?.generos_id)
})

watch(() => dataEstadosCiviles.value, async (newVal) => {
    estado_civil_seleccionado.value = newVal.find(el => el.id == props.user?.estado_civil_id)
})

watch(() => dataTiposSangre.value, async (newVal) => {
    tipo_sangre_seleccionado.value = newVal.find(el => el.id == props.user?.tipo_sangre_id)
})

watch(() => pais_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/estados/${newVal?.id}`)
    data_estados.value = data
})

watch(() => estado_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/municipios/${newVal?.id}`)
    data_municipios.value = data
})

watch(() => municipio_seleccionado.value, async (newVal) => {
    const { data } = await axios.get(`/api/domicilio/colonias/${newVal?.id}`)
    data_colonias.value = data
})

const props = defineProps({
    user: Object,
});

const form = useForm({
    _method: 'PUT',
    
    colonia_id: null,
    tipo_sangre_id: null,
    estado_civil_id: null,
    generos_id: null,
    nacionalidad_id: null,
    
    apellido_paterno: null,
    apellido_materno: null,
    fecha_nacimiento: null,
    curp: null,
    rfc: null,
    nss: null,
    telefono_local: null,
    telefono_celular: null,
    name: null,
    email: null,
    
    calle: null,
    numero_exterior: null,
    numero_interior: null,
    profile_photo_path: null,

    photo: null
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if(photoInput.value){
        form.photo = photoInput.value.files[0];
    }

    form.transform((data) => ({
        ...data,
        colonia_id      : colonia_seleccionada.value?.id ?? null,
        tipo_sangre_id  : tipo_sangre_seleccionado.value?.id ?? null,
        estado_civil_id : estado_civil_seleccionado.value?.id ?? null,
        generos_id      : genero_seleccionado.value?.id ?? null
    })).post(route('user-profile-information.update'), {
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

    if(!photo) return;

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
    if(photoInput.value?.value){
        photoInput.value.value = null;
    }
};
</script>