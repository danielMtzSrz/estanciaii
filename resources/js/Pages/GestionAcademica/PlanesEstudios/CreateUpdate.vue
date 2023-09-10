<template>
    <GenericModal :dataModal="dataModal" @closeModal="closeModal" :title="titulo">
       <template #header>
           <h3 class="font-bold">{{ titulo }}</h3>
       </template>
       <template #content>
           <form @submit.prevent="submit(false)">
               <div class="row p-fluid">
                   <div class="mt-4 col-md-12">
                       <Dropdown 
                           label="Carrera"
                           :data="dataModal.dataCarrera"
                           :value="carrera"
                           :errors="form.errors.carrera_id"
                           :textDropdown="'nombre'"
                           @input="form.carrera_id = $event.id, carrera=$event"
                       />
                       <Dropdown 
                           label="Mapa Curricular"
                           :data="dataModal.dataMapaCurricular"
                           :value="mapaCurricular"
                           :errors="form.errors.mapa_curricular_id"
                           :textDropdown="'clave_mapa_curricular'"
                           @input="form.mapa_curricular_id = $event.id, mapaCurricular=$event"
                       />
                   </div>
                   
                   <div class="col-sm-4 mt-3">
                        <div class=" field-checkbox">
                            <div class="flex align-items-end">
                                <Checkbox v-model="form.estatus" :binary="true" />
                                <label>&nbsp;{{ form.estatus ? 'Plan activo' : 'Plan inactivo' }}</label>
                            </div>
                        </div>
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
    const carrera = ref(null)
    
    const mapaCurricular = ref(null)
 
    const form = useForm({
          carrera_id: null,
          mapa_curricular_id: null,
          estatus : false,
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
        if(!props.dataModal.dataRegistro){
            form.transform((data) => ({
                ...data,
                estatus: data.estatus ? '1' : '0',
            })).post(route(ruta.value), {
                onSuccess: () => {
                    closeModal();
                },
            });
        }else{
            form.transform((data) => ({
                ...data,
                estatus: data.estatus ? '1' : '0',
            })).put(route(ruta.value, props.dataModal.dataRegistro), {
                onSuccess: () => {
                    closeModal();
                },
            });
        }
    }
    
    watch(() => props.dataModal, (newVal, oldVal) => {
        ruta.value = !props.dataModal.dataRegistro ? 'GestionAcademica.PlanesEstudios.store' : 'GestionAcademica.PlanesEstudios.update'
        titulo.value = !props.dataModal.dataRegistro ? 'Nuevo Plan de estudios' : 'Actualizar Plan de estudios'
    })
    
    watch(() => props.dataModal.dataRegistro, (newVal, oldVal) => {
        form.reset();
        carrera.value = newVal?.carrera??null
        mapaCurricular.value = newVal?.mapaCurricular??null
        form.carrera_id = newVal?.carrera_id ?? null
        form.mapa_curricular_id = newVal?.mapa_curricular_id ?? null
        form.estatus = (newVal?.estatus ? true : false)
    })
 </script>