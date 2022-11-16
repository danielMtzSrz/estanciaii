<template>
   <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
      <template #header>
        <h3 class="font-bold">{{ titulo }}</h3>
      </template>
      <template #content>
        <form @submit.prevent="submit(false)">
          <div class="row p-fluid">
            <div class="mt-4 col-md-12">
              <InputText
                label="Nombre"
                name="nombre"
                :errors="form.errors.nombre"
                :value="form.nombre"
                @input="form.nombre = $event"
              />
            </div>
          </div>
          <div class="float-end space-x-2 mt-3">
            <Button
              type="button"
              label="Cancelar"
              class="p-button-text p-button-raised p-button-rounded p-button-warning"
              @click="cerrarModal()"
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
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

import Button from "primevue/button";
import InputText from "@/Assets/Components/Forms/InputText.vue";
import GenericModal from "@/Assets/Components/GenericModal.vue";

const loading = ref(null)
const display = ref(null)
const form = useForm({
  nombre: "",
})
const ruta = ref(null)
const titulo = ref(null)

const props = defineProps({
  dataModal: {
    type: Object,
    default: null,
  },
})

const emits = defineEmits(["visible"])

const cerrarModal = () => {
  emits("visible", false);
  form.reset();
}
const submit = () => {
  if (!props.dataModal.dataRegistro) {
    form.post(route(ruta.value), {
      onSuccess: () => {
        cerrarModal();
      },
    });
  } else {
    form.put(route(ruta.value, props.dataModal.dataRegistro), {
      onSuccess: () => {
        cerrarModal();
      },
    });
  }
};

watch(
  () => props.dataModal,
  (newVal, oldVal) => {
    form.reset();

    ruta.value = !props.dataModal.dataRegistro
      ? "GestionAcademica.Cuatrimestres.store"
      : "GestionAcademica.Cuatrimestres.update";

    titulo.value = !props.dataModal.dataRegistro
      ? "Nuevo cuatrimestre"
      : "Actualizar cuatrimestre";

    form.nombre = newVal.dataRegistro?.nombre ?? "";
  }
);
</script>

<style>
  
</style>