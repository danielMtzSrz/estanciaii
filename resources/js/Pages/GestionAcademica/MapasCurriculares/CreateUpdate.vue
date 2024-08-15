<template>
  <GenericModal
      :dataModal="dataModal"
      @closeModal="closeModal()" 
      :header="titulo"
  >
      <template #content>
          <form @submit.prevent="submit" enctype="multipart/form-data">
              <div class="row col-12 pt-4">

                  <div class="col-sm-12 col-md-3">
                      <InputText
                          label="Clave mapa curricular"
                          v-model="form.clave_mapa_curricular"
                          :errors="form.errors.clave_mapa_curricular"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Total de cuatrimestres"
                          v-model="form.total_cuatrimestres"
                          :errors="form.errors.total_cuatrimestres"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Total de horas"
                          v-model="form.total_horas"
                          :errors="form.errors.total_horas"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Total de créditos"
                          v-model="form.total_creditos"
                          :errors="form.errors.total_creditos"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Total de materias"
                          v-model="form.total_materias"
                          :errors="form.errors.total_materias"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Duración"
                          v-model="form.duracion"
                          :errors="form.errors.duracion"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                      <InputNumber
                          label="Vigencia"
                          v-model="form.vigencia"
                          :errors="form.errors.vigencia"
                      />
                  </div>

                  <div class="col-sm-12 col-md-3">
                        <Calendar 
                            label="Fecha de revisión"
                            icon="pi pi-calendar"
                            v-model="form.fecha_revision"
                            :errors="form.errors.fecha_revision"
                            :showTime="false"
                        />
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

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Inputs
import InputText from "@/Components/Forms/InputText.vue";
import InputNumber from "@/Components/Forms/InputNumber.vue";
import Calendar from "@/Components/Forms/Calendar.vue";

// Variables
const fechaRevision = ref(null)

const form = useForm({
  _method : null,
  clave_mapa_curricular : null,
  total_cuatrimestres : null,
  total_horas : null,
  total_creditos : null,
  total_materias : null,
  duracion : null,
  vigencia : null,
  fecha_revision : null
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
      form.post(route(ruta.value), {
          onSuccess: () => {
              closeModal();
          },
      });

  } else {
      form.post(route(ruta.value, props.dataModal.dataRegistro), {
          onSuccess: () => {
              closeModal();
          },
      });
  }
};

// Watchers
watch(() => props.dataModal, async (newVal) => {
  ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.MapasCurriculares.store' : 'GestionAcademica.MapasCurriculares.update'
  titulo.value = !newVal.dataRegistro ? 'Nuevo mapa curricular' : 'Actualizar mapa curricular'
})

watch(() => props.dataModal.dataRegistro, (newVal) => {
  form.reset()

  form._method = newVal ? "put" : null

  form.clave_mapa_curricular = newVal?.clave_mapa_curricular ?? null
  form.total_cuatrimestres = newVal?.total_cuatrimestres ?? null
  form.total_horas = newVal?.total_horas ?? null
  form.total_creditos = newVal?.total_creditos ?? null
  form.total_materias = newVal?.total_materias ?? null
  form.duracion = newVal?.duracion ?? null
  form.vigencia = newVal?.vigencia ?? null
  form.fecha_revision = newVal?.fecha_revision_format ?? null

  fechaRevision.value = newVal?.fecha_revision ?? null
})
</script>
