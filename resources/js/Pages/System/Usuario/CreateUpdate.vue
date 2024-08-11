<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">
                    
                    <Divider align="left" type="solid" class="mb-4">
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
                        <Calendar
                            label="Fecha de nacimiento"
                            v-model="form.fecha_nacimiento"
                            :showTime="false"
                            :errors="form.errors.fecha_nacimiento"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Correo electrónico"
                            name="email"
                            :errors="form.errors.email"
                            v-model="form.email"
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
                            label="NSS"
                            name="nss"
                            :errors="form.errors.nss"
                            v-model="form.nss"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Genero"
                            :data="dataModal.data_generos"
                            textDropdown="nombre"
                            v-model="genero_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Tipo de sangre"
                            :data="dataModal.data_tipos_sangre"
                            textDropdown="nombre"
                            v-model="tipo_sangre_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estado civil"
                            :data="dataModal.data_estados_civiles"
                            textDropdown="nombre"
                            v-model="estado_civil_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Nacionalidad"
                            :data="data_paises"
                            textDropdown="nacionalidad"
                            v-model="nacionalidad_seleccionada"
                        />
                    </div>

                    <Divider align="left" type="solid" class="mb-4">
                        <b>Domicilio</b>
                    </Divider>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Países"
                            :data="data_paises"
                            textDropdown="nombre"
                            v-model="pais_seleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estados"
                            :data="data_estados"
                            textDropdown="nombre"
                            v-model="estado_seleccionado"
                            :disabled="!data_estados"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Estados"
                            :data="data_municipios"
                            textDropdown="nombre"
                            v-model="municipio_seleccionado"
                            :disabled="!data_municipios"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Colonias"
                            :data="data_colonias"
                            textDropdown="nombre"
                            v-model="colonia_seleccionada"
                            :errors="form.errors.colonia_id"
                            :disabled="!data_colonias"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Calle"
                            name="calle"
                            v-model="form.calle"
                            :errors="form.errors.calle"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="N° Exterior"
                            name="numero_exterior"
                            v-model="form.numero_exterior"
                            :errors="form.errors.numero_exterior"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputNumber
                            label="N° Interior"
                            name="numero_interior"
                            v-model="form.numero_interior"
                            :errors="form.errors.numero_interior"
                            :useGrouping="false"
                        />
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <InputText
                            label="Código Postal"
                            name="codigo_postal"
                            v-model="form.codigo_postal"
                            :errors="form.errors.codigo_postal"
                        />
                    </div>

                    <!-- Horarios -->
                    <Schedules
                        v-model="form.horarios"
                        :errors="form.errors.horarios"
                    />

                    <div class="mt-4 col-md-12">
                        <FileUpload
                            dropText="Arrastre aquí la foto del usuario."
                            :imagenActual="imagenActual"
                            v-model="form.profile_photo_path"
                            :errors="form.errors.profile_photo_path"
                        />
                    </div>

                    <div class="col-sm-12">
                        <Divider align="left">
                            <div class="inline-flex align-items-center">
                                <i class="pi pi-globe mr-2"></i>
                                Seleccionar roles
                            </div>
                        </Divider>
                        <div class="flex flex-row-reverse flex-wrap card-container yellow-container mb-4">
                            <div class="flex align-items-center justify-content-center w-20rem">
                                <InputText
                                    label="Buscador"
                                    v-model="buscador"
                                />
                            </div>
                        </div>

                        <DataView :value="data_roles_all" layout="grid" :paginator="true" :rows="24" :rowsPerPageOptions="[8, 12, 20, 24, 40]">
                            <template #grid="slotProps">
                                <div class="col-12 md:col-3">
                                    <div class="field-checkbox d-flex mb-5 mx-3">
                                        <Checkbox
                                            name="roles[]"
                                            :value="slotProps.data.id"
                                            v-model="form.roles"
                                            class="mr-2"
                                            :checked="true"
                                        />
                                        <label>{{ slotProps.data.name}}</label>
                                    </div>
                                </div>
                            </template>
                        </DataView>
                    </div>

                </div>

                <div class="float-end space-x-2 py-4">
                    <Button
                        type="button"
                        label="Cancelar"
                        class="p-button-text p-button-raised p-button-rounded p-button-warning"
                        @click="closeModal()"
                    />
                    <Button
                        type="submit"
                        label="Guardar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="form.processing"
                    />
                </div>
            </form>
        </template>
    </GenericModal>
</template>

<script setup>

// Vue
import { ref, watch, computed, toRaw } from "vue";

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Divider from 'primevue/divider';
import Checkbox from 'primevue/checkbox';
import DataView from 'primevue/dataview';

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import Dropdown from "@/Components/Forms/Dropdown.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import FileUpload from "@/Components/Forms/FileUpload.vue";
import Calendar from "@/Components/Forms/Calendar.vue";
import Schedules from "@/Components/Forms/Schedules.vue";

// Variables
const dataUsuariosRolesAxios = ref(null)

const data_paises = ref(null), pais_seleccionado = ref(null),
      data_estados = ref(null), estado_seleccionado = ref(null),
      data_municipios = ref(null), municipio_seleccionado = ref(null),
      data_colonias = ref(null), colonia_seleccionada = ref(null),
      estado_civil_seleccionado = ref(null), genero_seleccionado = ref(null), tipo_sangre_seleccionado = ref(null),
      nacionalidad_seleccionada = ref(null),
      data_roles = ref(null),
      data_usuarios_roles = ref(null)

const imagenActual = ref(null)

const form = useForm({
    _method: null,
    
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

    horarios : null,

    roles: []
});

const ruta = ref(null), titulo = ref(null);
const buscador = ref(null)

const data_roles_all = computed(() => {
    return buscador.value 
        ? data_roles.value.filter(el => el.name.toLowerCase().indexOf(buscador.value.toLowerCase()) >= 0)
        : data_roles.value
})

// Props
const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

// Emits
const emits = defineEmits(["closeModal"]);

// Methods
const closeModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
};

const submit = () => {

    if (!props.dataModal.dataRegistro) {
        form.transform((data) => ({
            ...data,
            colonia_id      : colonia_seleccionada.value?.id ?? null,
            tipo_sangre_id  : tipo_sangre_seleccionado.value?.id ?? null,
            estado_civil_id : estado_civil_seleccionado.value?.id ?? null,
            generos_id      : genero_seleccionado.value?.id ?? null,
            nacionalidad_id : nacionalidad_seleccionada.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    }else{
        form.transform((data) => ({
            ...data,
            colonia_id      : colonia_seleccionada.value?.id ?? null,
            tipo_sangre_id  : tipo_sangre_seleccionado.value?.id ?? null,
            estado_civil_id : estado_civil_seleccionado.value?.id ?? null,
            generos_id      : genero_seleccionado.value?.id ?? null,
            nacionalidad_id : nacionalidad_seleccionada.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'user.store' : 'user.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo usuario' : 'Actualizar usuario'
    
    const { data } = await axios.get(`/api/domicilio/paises`);
    data_paises.value = data

    const dataRolesAxios = await axios.get(`/api/roles`);
    data_roles.value = dataRolesAxios.data
})

watch(() => props.dataModal.dataRegistro, async (newVal) => {
    form.reset()

    form.horarios = newVal?.horarios ?? null

    if(newVal){
        try{
            const obtener_colonia = await axios.get(`/api/domicilio/obtener_colonia/${newVal.colonia_id}`)
            const colonia = obtener_colonia.data[0];
            pais_seleccionado.value = colonia.municipio.estado?.pais ?? null
            estado_seleccionado.value = colonia.municipio?.estado ?? null
            municipio_seleccionado.value = colonia?.municipio ?? null
            colonia_seleccionada.value = colonia ?? null
            nacionalidad_seleccionada.value = data_paises.value.find(el => el.id == newVal?.nacionalidad_id)
        }catch(e){
            console.error("Actualiza para obtener los datos", e)
        }
    
        dataUsuariosRolesAxios.value = await axios.get(`/api/user_roles/${newVal?.id}`)
    }

    form.roles = toRaw(dataUsuariosRolesAxios.value.data)

    form._method = newVal ? "put" : null

    form.colonia_id = newVal?.colonia_id ?? null
    
    form.tipo_sangre_id = newVal?.tipo_sangre_id ?? null
    form.estado_civil_id = newVal?.estado_civil_id ?? null
    form.generos_id = newVal?.generos_id ?? null
    form.nacionalidad_id = newVal?.nacionalidad_id ?? null
    
    form.apellido_paterno = newVal?.apellido_paterno ?? null
    form.apellido_materno = newVal?.apellido_materno ?? null
    form.fecha_nacimiento = newVal?.fecha_nacimiento ?? null
    form.curp = newVal?.curp ?? null
    form.rfc = newVal?.rfc ?? null
    form.nss = newVal?.nss ?? null
    form.telefono_local = newVal?.telefono_local ?? null
    form.telefono_celular = newVal?.telefono_celular ?? null
    form.name = newVal?.name ?? null
    form.email = newVal?.email ?? null
    
    form.calle = newVal?.calle ?? null
    form.numero_exterior = newVal?.numero_exterior ?? null
    form.numero_interior = newVal?.numero_interior ?? null
    form.profile_photo_path = newVal?.profile_photo_path ?? null
    

    imagenActual.value = newVal?.profile_photo_path ?? null

    tipo_sangre_seleccionado.value = props.dataModal.data_tipos_sangre.find(el => el.id == newVal?.tipo_sangre_id)
    estado_civil_seleccionado.value = props.dataModal.data_estados_civiles.find(el => el.id == newVal?.estado_civil_id)
    genero_seleccionado.value = props.dataModal.data_generos.find(el => el.id == newVal?.generos_id)
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

// Para obtener todo lo anterior a través de la colonia
// watch(() => form.codigo_postal, async (newVal) => {
//     if(form.codigo_postal.length === 5){
//         const { data } = await axios.get(`/api/domicilio/cp/${newVal}`)
//         console.log(data)
//     }
// })
</script>
