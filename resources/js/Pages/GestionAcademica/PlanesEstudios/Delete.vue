<template>

    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal"> 
       <template #header>
           <h3 class="font-bold">{{titulo}}</h3>
       </template>
       <template #content>
           <div class="d-flex align-items-center">
               <i class="pi pi-exclamation-triangle"/>&nbsp;
               <span>¿Seguro que desea eliminar el plan de estudios de <strong>{{ dataModal.dataRegistro?.carrera.nombre }}</strong>?</span>
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
                   label="Eliminar"
                   class="p-button-text p-button-raised p-button-rounded p-button-danger"
                   @click="eliminarRegistro()"
                   :loading="form.processing"
               />
           </div>
       </template>
   </GenericModal>
   
 </template>
 
 <script setup>
   
    import { useForm } from "@inertiajs/inertia-vue3";
    
    import Button from "primevue/button";
    
    import GenericModal from '@/Components/GenericModal.vue';
    
    const titulo= 'Eliminar Plan de estudio'
    const form = useForm()
    
    const props = defineProps({
        dataModal: Object,
    })
    
    const emits = defineEmits(['visible'])
    
    const cerrarModal = () => {
        emits("visible", false);
    }
    const eliminarRegistro = () => {
        form.delete(route("GestionAcademica.PlanesEstudios.destroy", props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
</script>