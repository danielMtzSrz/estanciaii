<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
    >
        <template #content>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Materia"
                            :data="dataMaterias"
                            textDropdown="nombre"
                            v-model="materiaSeleccionada"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Profesor"
                            :data="dataUsuarios"
                            imageDropdown="profile_photo_path"
                            textDropdown="nombre"
                            v-model="usuarioSeleccionado"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <Dropdown 
                            label="Grupo"
                            :data="dataGrupos"
                            textDropdown="nombre"
                            v-model="grupoSeleccionado"
                        />
                    </div>

                    <div v-if="usuarioSeleccionado != null">

                        <Divider align="left">
                            <div class="inline-flex align-items-center">
                                <i class="pi pi-clock mr-2"></i>
                                <b>Horarios profesor</b>
                            </div>
                        </Divider>

                        <div v-if="usuarioSeleccionado.horarios != null && Object.keys(usuarioSeleccionado.horarios).length > 0">
                            <ol class="ms-0">
                                <li v-for="(dia, index) in sortedHorarios" :key="index">
                                    {{ dia.nombre }} {{ dia.hora_inicio }} - {{ dia.hora_fin }}
                                </li>
                            </ol>
                        </div>
                        <div v-else class="p-error">
                            <ol class="ms-0">
                                <li>Sin horarios definidos</li>
                            </ol>
                        </div>
                    </div>

                    <Schedules
                        v-model="form.horarios"
                        :errors="form.errors.horarios"
                    />

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
import { ref, watch, computed } from "vue";

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";
import Divider from "primevue/divider";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import Dropdown from "@/Components/Forms/Dropdown.vue";
import Schedules from "@/Components/Forms/Schedules.vue";

// Variables
const dataUsuarios = ref(null), dataMaterias = ref(null), dataGrupos = ref(null)
const usuarioSeleccionado = ref(null), materiaSeleccionada = ref(null), grupoSeleccionado = ref(null)

const form = useForm({
    _method : null,
    profesor_id : null,
    materia_id : null,
    grupo_id : null,
    horarios : null
});

const ruta = ref(null), titulo = ref(null);

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
            profesor_id : usuarioSeleccionado.value?.id ?? null,
            materia_id : materiaSeleccionada.value?.id ?? null,
            grupo_id : grupoSeleccionado.value?.id ?? null,
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });

    } else {
        form.transform((data) => ({
            ...data,
            profesor_id : usuarioSeleccionado.value?.id ?? null,
            materia_id : materiaSeleccionada.value?.id ?? null,
            grupo_id : grupoSeleccionado.value?.id ?? null,
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
};

const dias_semana = [
  { key: "lunes", nombre: "Lunes" },
  { key: "martes", nombre: "Martes" },
  { key: "miercoles", nombre: "Miércoles" },
  { key: "jueves", nombre: "Jueves" },
  { key: "viernes", nombre: "Viernes" },
  { key: "sabado", nombre: "Sábado" },
  { key: "domingo", nombre: "Domingo" }
];

const sortedHorarios = computed(() => {
    if(usuarioSeleccionado.value.horarios != null && Object.keys(usuarioSeleccionado.value.horarios).length > 0){
        return dias_semana
            .filter(dia => usuarioSeleccionado.value.horarios[dia.key])
            .map(dia => ({
            nombre: dia.nombre,
            hora_inicio: usuarioSeleccionado.value.horarios[`${dia.key}_hora_inicio`],
            hora_fin: usuarioSeleccionado.value.horarios[`${dia.key}_hora_fin`]
            }));
    }
});

// Watchers
watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.GrupoMateria.store' : 'GestionAcademica.GrupoMateria.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva asignación' : 'Actualizar asignación'

    const dataUsuariosAxios = await axios.get(`/api/usuarios`);
    dataUsuarios.value = dataUsuariosAxios.data;

    const dataMateriasAxios = await axios.get(`/api/materias`);
    dataMaterias.value = dataMateriasAxios.data;

    const dataGruposAxios = await axios.get(`/api/grupos`);
    dataGrupos.value = dataGruposAxios.data;
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()

    form._method = newVal ? "put" : null

    form.profesor_id = newVal?.profesor.id ?? null
    form.materia_id = newVal?.materia.id ?? null
    form.grupo_id = newVal?.grupo.id ?? null
    form.horarios = newVal?.horarios ?? null

    usuarioSeleccionado.value = newVal?.profesor ?? null
    materiaSeleccionada.value = newVal?.materia ?? null
    grupoSeleccionado.value = newVal?.grupo ?? null
})
</script>
