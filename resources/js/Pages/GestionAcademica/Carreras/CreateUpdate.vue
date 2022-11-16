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
                  <div class="mt-4 col-md-12">
                      <Textarea
                          label="Descripción de la carrera"
                          name="descripcion"
                          :errors="form.errors.descripcion"
                          :value="form.descripcion"
                          @input="form.descripcion = $event"
                      />
                  </div>
               </div>
               <div class="flex row p-fluid">   
                  <div class="mt-4 col-md-8">
                        <Dropdown 
                            label="Tipo de coordinación"
                            :data="dataModal.dataTipoCoordinacion"
                            :value="tipoCoordinacion"
                            :errors="form.errors.tipo_coordinacion_carrera"
                            :textDropdown="'nombre'"
                            @input="form.tipo_coordinacion_carrera = $event.id, tipoCoordinacion=$event"/>
                 </div>
                  <div class="col-sm-4 mt-3">
                     <div class=" field-checkbox">
                         <div class="flex align-items-end">
                             <Checkbox v-model="form.estatus" :binary="true" />
                             <label>&nbsp;{{ form.estatus ? 'Carrera activa' : 'Carrera inactiva' }}</label>
                         </div>
                     </div>
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

   import { ref, watch, computed } from 'vue';
   import { useForm } from "@inertiajs/inertia-vue3";
   import Button from "primevue/button";
   import Checkbox from 'primevue/checkbox';
   
   import InputText from "@/Assets/Components/Forms/InputText.vue";
   import InputNumber from "@/Assets/Components/Forms/InputNumber.vue";
   import Textarea from "@/Assets/Components/Forms/Textarea.vue";
   import Dropdown from '@/Assets/Components/Forms/Dropdown.vue';
   
   import GenericModal from '@/Assets/Components/GenericModal.vue';
   
   const tipoCoordinacion = ref(null)

   const form = useForm({
         nombre: null,
         descripcion: null,
         estatus : null,
         tipo_coordinacion_carrera:  null,
   })

   const ruta = ref(null)
   const titulo = ref(null)
  
   const props = defineProps({
       dataModal: {
           type: Object,
           default: null
       },
   })
   
   const emits = defineEmits(['visible'])
   
   const cerrarModal = () => {
       emits("visible", false);
       form.reset();
       form.errors = {}
   }
   
   const submit = () => {
       if(!props.dataModal.dataRegistro){
           form.transform((data) => ({
               ...data,
               estatus: data.estatus ? 1 : 0,
           })).post(route(ruta.value), {
               onSuccess: () => {
                   cerrarModal();
               },
           });
       }else{
           form.transform((data) => ({
               ...data,
               estatus: data.estatus ? 1 : 0,
           })).put(route(ruta.value, props.dataModal.dataRegistro), {
               onSuccess: () => {
                   cerrarModal();
               },
           });
       }
   }
   
   watch(() => props.dataModal, (newVal, oldVal) => {
       ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.Carreras.store' : 'GestionAcademica.Carreras.update'
       titulo.value = !props.dataModal.dataRegistro ? 'Nueva carrera' : 'Actualizar carrera'
   })
   
   watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
       form.reset();
       tipoCoordinacion.value = newVal?.tipoCoordinacion??null
       form.nombre = newVal?.nombre ?? null
       form.descripcion = newVal?.descripcion ?? null
       form.estatus = (newVal?.estatus ? true : false)
       form.tipo_coordinacion_carrera = newVal?.tipo_coordinacion_carrera ?? null
   })
</script>

<style>
  
</style>