<template>

   <GenericLayout titleModule="Carreras">
      <template #content>
          <GenericTable :data="carreras">
              <template #headerContent>
                  <Button
                      type="button"
                      label="Nuevo"
                      icon="pi pi-plus"
                      class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
                      @click="modalCreateUpdate(null, true)"
                  />
                  <Link :href="route('GestionAcademica.Carreras.trashed')">
                    <Button 
                        type="button"
                        label="Papelera"
                        icon="pi pi-trash"
                        class="p-button-raised p-button-rounded p-button-text p-button-help p-button-sm" 
                    />
                  </Link>
              </template>
              <template #content>
                  <Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field" :sortable="col.sortable">
                     <template #body="{data}" v-if="data===null"><p>Nulo</p></template>   
                     <template #body="{ data }" v-else-if="col.field=='estatus'"><p>{{ data.estatus===1 ? 'Activo' : 'Inactivo' }}</p></template>
                     <template  #body="{ data }" v-else-if="col.field == 'created_at'">{{ moment( new Date(data.created_at)).calendar() }}</template>
                     <template  #body="{ data }" v-else-if="col.field == 'updated_at'">{{ moment( new Date(data.updated_at)).calendar() }}</template>

                  </Column>

                  <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                      <template #body="slotProps">
                          <Button
                              type="button"
                              icon="pi pi-pencil"
                              class="p-button-warning p-button-text p-button-raised p-button-rounded"
                              @click="modalCreateUpdate(slotProps.data, true)"
                          />
                          <Button
                              type="button"
                              icon="pi pi-trash"
                              class="p-button-danger p-button-text p-button-raised p-button-rounded"
                              @click="modalEliminar(slotProps.data, true)"
                          />
                      </template>
                  </Column>
              </template>
        </GenericTable>
    
      </template>

      <template #footer>
          <form-create-update
              :dataModal="{
                  display: displayCreateUpdate,
                  dataRegistro: dataRegistro,
                  dataTipoCoordinacion: tiposCoordinacion
              }"
              v-on:visible="(visible) => modalCreateUpdate(null, visible)"
          />
          <form-delete
              :dataModal="{
                  display: displayEliminar,
                  dataRegistro : dataRegistro
              }"
              v-on:visible="(visible) => modalEliminar(null, visible)"
          />
      </template>
  </GenericLayout>
  
</template>

<script setup>
   import {ref, onMounted} from 'vue';
   import moment from 'moment';
   import Column from 'primevue/column';
   import Button from "primevue/button";
   import InputText from "primevue/inputtext";

   import GenericLayout from '@/Layouts/GenericLayout.vue';
   import GenericTable from '@/Components/GenericTable.vue';

   import FormCreateUpdate from '@/Pages/GestionAcademica/Carreras/CreateUpdate.vue';
   import FormDelete from '@/Pages/GestionAcademica/Carreras/Delete.vue';

   const displayCreateUpdate = ref(null)
   const displayEliminar = ref(null)
   const dataRegistro = ref(null)
   const columns = ref(null)


   const props = defineProps({
       carreras: {
           type: Object,
           default: {}
       },
       departamentos: {
           type: Object,
           default: {}
       }
   })
   const tiposCoordinacion = [{id:0, nombre:'A'},{id:1, nombre:'B'},{id:2, nombre:'C'},{id:3, nombre:'D'},{id:4, nombre:'E'}]

   const modalCreateUpdate = (data, show) => {
       dataRegistro.value = data
       displayCreateUpdate.value = show
   }
   const modalEliminar = (data, show) => {
       dataRegistro.value = data;
       displayEliminar.value = show;
   }

   onMounted(() => {
       columns.value = [
           {field: 'id', header: 'ID', sortable: true},
           {field: 'nombre', header: 'Nombre', sortable: true},
           {field: 'descripcion', header: 'Descripción', sortable: true},
           {field: 'estatus', header: 'Estatus', sortable: true},
           {field: 'tipo_coordinacion_carrera', header: 'Tipo de coordinación', sortable: true},
           {field: 'created_at', header: 'Fecha de creación', sortable: true},
           {field: 'updated_at', header: 'Fecha de modificación', sortable: true},
       ];
   })
</script>

<style>

</style>
