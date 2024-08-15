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
                            label="Carrera"
                            :data="dataCarreras"
                            imageDropdown="imagen"
                            textDropdown="nombre"
                            v-model="carreraSeleccionada"
                            :errors="form.errors.carrera_id"
                        />
                    </div>
  
                    <div class="col-sm-12 col-md-3">
                        <Dropdown 
                            label="Mapa curricular"
                            :data="dataMapasCurriculares"
                            textDropdown="clave_mapa_curricular"
                            v-model="mapaCurricularSeleccionado"
                            :errors="form.errors.mapa_curricular_id"
                        />
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="field-checkbox">
                            <div class="flex align-items-end">
                                <Checkbox v-model="form.estatus" :binary="true"/>
                                <label>&nbsp;{{ form.estatus ? 'Activo' : 'Inactivo' }}</label>
                            </div>
                        </div>
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
  import { ref, watch } from "vue";
  
  // Inertia
  import { useForm } from "@inertiajs/inertia-vue3";
  
  // Primevue
  import Button from "primevue/button";
  import Checkbox from "primevue/checkbox";
  
  // Layouts
  import GenericModal from "@/Components/GenericModal.vue";
  
  // Inputs
  import Dropdown from "@/Components/Forms/Dropdown.vue";
  
  // Variables
  const dataMapasCurriculares = ref(null), dataCarreras = ref(null)
  const mapaCurricularSeleccionado = ref(null), carreraSeleccionada = ref(null)
  const fechaRevision = ref(null)
  
  const form = useForm({
    _method : null,
    carrera_id : null,
    mapa_curricular_id : null,
    estatus : null
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
  
    if(!props.dataModal.dataRegistro){
        form.transform((data) => ({
            ...data,
            carrera_id : carreraSeleccionada.value?.id ?? null,
            mapa_curricular_id : mapaCurricularSeleccionado.value?.id ?? null
        })).post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
        });
  
    }else{
        form.transform((data) => ({
            ...data,
            carrera_id : carreraSeleccionada.value?.id ?? null,
            mapa_curricular_id : mapaCurricularSeleccionado.value?.id ?? null
        })).post(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
        });
    }
  };
  
  // Watchers
  watch(() => props.dataModal, async (newVal) => {
    ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.PlanesEstudios.store' : 'GestionAcademica.PlanesEstudios.update'
    titulo.value = !newVal.dataRegistro ? 'Nuevo plan de estudio' : 'Actualizar plan de estudio'

    const dataCarrerasAxios = await axios.get(`/api/carreras`);
    dataCarreras.value = dataCarrerasAxios.data;

    const dataMapasCurricularesAxios = await axios.get(`/api/mapas_curriculares`);
    dataMapasCurriculares.value = dataMapasCurricularesAxios.data;
  })
  
  watch(() => props.dataModal.dataRegistro, (newVal) => {
    form.reset()
  
    form._method = newVal ? "put" : null
  
    form.carrera_id = newVal?.carrera.id ?? null
    form.mapa_curricular_id = newVal?.mapa_curricular.id ?? null
    form.estatus = newVal?.estatus == 'Activo' ? true : false
  
    carreraSeleccionada.value = newVal?.carrera ?? null
    mapaCurricularSeleccionado.value = newVal?.mapa_curricular ?? null
  })
  </script>
  