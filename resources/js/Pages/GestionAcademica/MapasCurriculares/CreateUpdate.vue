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
                label="Clave del Mapa Curricular"
                name="clave_mapa_curricular"
                :errors="form.errors.clave_mapa_curricular"
                :value="form.clave_mapa_curricular"
                @input="form.clave_mapa_curricular = $event"
              />
            </div>
          </div>
          <div class="row p-fluid">
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Cuatrimestres totales" 
                  name="total_cuatrimestres"
                  mode="decimal"
                  :errors="form.errors.total_cuatrimestres"
                  :value="form.total_cuatrimestres"
                  @input="form.total_cuatrimestres = $event" />
               
            </div>
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Horas totales" 
                  name="total_horas"
                  mode="decimal"
                  :errors="form.errors.total_horas"
                  :value="form.total_horas"
                  @input="form.total_horas = $event" />
            </div>
          </div>
          <div class="row p-fluid">
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Creditos totales" 
                  name="total_creditos"
                  mode="decimal"
                  :errors="form.errors.total_creditos"
                  :value="form.total_creditos"
                  @input="form.total_creditos = $event" />
            </div>
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Materias totales" 
                  name="total_materias"
                  mode="decimal"
                  :errors="form.errors.total_materias"
                  :value="form.total_materias"
                  @input="form.total_materias = $event" />
            </div>
          </div>
          <div class="row p-fluid">
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Duración" 
                  name="duracion"
                  mode="decimal"
                  :errors="form.errors.duracion"
                  :value="form.duracion"
                  @input="form.duracion = $event" />
            </div>
            <div class="mt-4 col-md-6">
               <InputNumber 
                  label="Vigencia" 
                  name="vigencia"
                  mode="decimal"
                  :errors="form.errors.vigencia"
                  :value="form.vigencia"
                  @input="form.vigencia = $event" />
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
   import InputText from "@/Components/Forms/InputText.vue";
   import GenericModal from "@/Components/GenericModal.vue";
   import InputNumber from "@/Components/Forms/InputNumber.vue";
   
   const loading = ref(null)
   const display = ref(null)
   const form = useForm({
     clave_mapa_curricular: "",
     total_cuatrimestres:{ 
      type: Number,
      default: null
      },
     total_horas: { 
      type: Number,
      default: null
      },
     total_creditos: { 
      type: Number,
      default: null
      },
     total_materias: { 
      type: Number,
      default: null
      },
     duracion:{ 
      type: Number,
      default: null
      },
     vigencia: { 
      type: Number,
      default: null
      }
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
         ? "GestionAcademica.MapasCurriculares.store"
         : "GestionAcademica.MapasCurriculares.update";
   
       titulo.value = !props.dataModal.dataRegistro
         ? "Nuevo mapa curricular"
         : "Actualizar mapa curricular";
   
       form.clave_mapa_curricular = newVal.dataRegistro?.clave_mapa_curricular ?? "";
       form.total_cuatrimestres = newVal.dataRegistro?.total_cuatrimestres ?? null;
       form.total_horas = newVal.dataRegistro?.total_horas ?? null;
       form.total_creditos = newVal.dataRegistro?.total_creditos ?? null;
       form.total_materias = newVal.dataRegistro?.total_materias ?? null;
       form.duracion = newVal.dataRegistro?.duracion ?? null;
       form.vigencia = newVal.dataRegistro?.vigencia ?? null;
     }
   );
   </script>

<style>
  
</style>