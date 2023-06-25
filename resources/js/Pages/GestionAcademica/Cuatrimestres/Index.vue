<template>

   <GenericLayout titleModule="Cuatrimestres">
      <template #content>
        <GenericTable :data="cuatrimestres">
          <template #headerContent>
            <Button
              type="button"
              label="Nuevo"
              icon="pi pi-plus"
              class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
              @click="modalCreateUpdate(null, true)"
            />
            <Link :href="route('GestionAcademica.Cuatrimestres.trashed')">
              <Button 
                  type="button"
                  label="Papelera"
                  icon="pi pi-trash"
                  class="p-button-raised p-button-rounded p-button-text p-button-help p-button-sm" 
              />
            </Link>
          </template>
          <template #content>
            <Column
              v-for="col of columns"
              :field="col.field"
              :header="col.header"
              :key="col.field"
              :sortable="col.sortable"
            >
              <template  #body="{ data }" v-if="col.field == 'created_at'">{{ moment( new Date(data.created_at)).calendar() }}</template>
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
          }"
          v-on:visible="(visible) => modalCreateUpdate(null, visible)"
        />
        <form-delete
          :dataModal="{
            display: displayEliminar,
            dataRegistro: dataRegistro,
          }"
          v-on:visible="(visible) => modalEliminar(null, visible)"
        />
      </template>
    </GenericLayout>

</template>

<script setup>
import { ref , onMounted } from "vue";
import moment from 'moment';
import Column from "primevue/column";
import Button from "primevue/button";

import GenericLayout from "@/Layouts/GenericLayout.vue";
import GenericTable from "@/Components/GenericTable.vue";

import FormCreateUpdate from "@/Pages/GestionAcademica/Cuatrimestres/CreateUpdate.vue";
import FormDelete from "@/Pages/GestionAcademica/Cuatrimestres/Delete.vue";

const displayCreateUpdate = ref(null)
const displayEliminar = ref(null)
const dataRegistro = ref(null)
const columns = ref(null)
const props = defineProps({
  cuatrimestres: {
    type: Object,
    default: {},
  },
})

const modalCreateUpdate = (data, show) => {
  dataRegistro.value = data;
  displayCreateUpdate.value = show;
}
const modalEliminar = (data, show) => {
  dataRegistro.value = data;
  displayEliminar.value = show;
}

onMounted(() => {
  columns.value = [
    { field: "id", header: "ID", sortable: true },
    { field: "nombre", header: "Nombre", sortable: true },
    { field: "created_at", header: "Fecha de creación ", sortable: true },
    { field: "updated_at", header: "Fecha de modificación", sortable: true },
  ];
})
</script>

<style>

</style>
