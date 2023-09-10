<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :title="titulo">
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
                       <Dropdown 
                           label="Cuatrimestre"
                           :data="dataModal.dataCuatrimestre"
                           :value="cuatrimestre"
                           :errors="form.errors.cuatrimestre_id"
                           :textDropdown="'nombre'"
                           @input="form.cuatrimestre_id = $event.id, cuatrimestre=$event"
                       />
                       <Dropdown 
                           label="Plan de estudio"
                           :data="dataModal.dataPlanEstudio"
                           :value="planEstudio"
                           :errors="form.errors.plan_estudio_id"
                           :textDropdown="'id'"
                           @input="form.plan_estudio_id = $event.id, planEstudio=$event"
                        />
                   </div>
                   
                   
                   
                </div>
        
               <div class="float-end space-x-2 mt-3">
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
 
    import { ref, watch, computed } from 'vue';
    import { useForm } from "@inertiajs/inertia-vue3";
    import Button from "primevue/button";
    import Checkbox from 'primevue/checkbox';
    
    import InputText from "@/Components/Forms/InputText.vue";
    import InputNumber from "@/Components/Forms/InputNumber.vue";
    import Textarea from "@/Components/Forms/Textarea.vue";
    import Dropdown from '@/Components/Forms/Dropdown.vue';
    
    import GenericModal from '@/Components/GenericModal.vue';
    
    const cuatrimestre = ref(null)

    const planEstudio= ref(null)
 
    const form = useForm({
          cuatrimestre_id: null,
          nombre: null,
          plan_estudio_id: null
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
    
    const closeModal = () => {
        emits("visible", false);
        form.reset();
        form.errors = {}
    }
    
    const submit = () => {
        if (!props.dataModal.dataRegistro) {
            form.post(route(ruta.value), {
            onSuccess: () => {
                closeModal();
            },
            });
        } else {
            form.put(route(ruta.value, props.dataModal.dataRegistro), {
            onSuccess: () => {
                closeModal();
            },
            });
        }
    };
    
    
    watch(() => props.dataModal, (newVal, oldVal) => {
        ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.Materias.store' : 'GestionAcademica.Materias.update'
        titulo.value = !props.dataModal.dataRegistro ? 'Nueva Materia' : 'Actualizar Materia'
    })
    
    watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
        form.reset();
        cuatrimestre.value = newVal?.cuatrimestre??null
        planEstudio.value = newVal?.planEstudio??null
        form.cuatrimestre_id = newVal?.cuatrimestre_id ?? null
        form.nombre = newVal?.nombre ?? null
        form.plan_estudio_id = newVal?.plan_estudio_id ?? null
    })
 </script>