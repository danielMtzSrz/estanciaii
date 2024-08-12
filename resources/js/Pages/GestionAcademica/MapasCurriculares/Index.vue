<template>
  <GenericLayout titleModule="Mapas curriculares">
      <template #content>
          <DynamicTable
              :data="mapas_curriculares"
              :items="items"
              titleModule="Mapas curriculares"
          >
            <template #header>
                <Button
                    v-if="hasPermission('GestionAcademica.MapasCurriculares.store')"
                    type="button"
                    label="Nuevo"
                    icon="pi pi-plus"
                    class="p-button-raised p-button-rounded p-button-success p-button-sm p-button-text"
                    @click="modalCreateUpdate({display: true})"
                />
            </template>

            <template #buttons="{ data }">
                <Button
                    v-if="hasPermission('GestionAcademica.MapasCurriculares.update')"
                    type="button"
                    icon="pi pi-pencil"
                    class="p-button-warning p-button-text p-button-raised p-button-rounded"
                    v-tooltip.top="'Actualizar'"
                    @click="modalCreateUpdate({display: true, data: data})"
                />
                <Button
                    v-if="hasPermission('GestionAcademica.MapasCurriculares.destroy')"
                    type="button"
                    icon="pi pi-trash"
                    class="p-button-danger p-button-text p-button-raised p-button-rounded"
                    @click="modalGenericAlert({
                        data: data, 
                        display: true, 
                        proceso: {
                            'proceso': 'delete',
                            'ruta': 'GestionAcademica.MapasCurriculares.destroy',
                        }
                    })"
                />
            </template>
          </DynamicTable>
      </template>

      <template #footer>
          <CreateUpdate
              :dataModal="{
                  display: displayCreateUpdate,
                  dataRegistro: dataRegistro,
              }"
              @closeModal="modalCreateUpdate({display: false, data: null})"
          />
          <GenericAlert
              :dataModal="{
                  display: displayGenericAlert,
                  dataRegistro : dataRegistro,
                  dataProceso : dataProceso
              }"
              @closeModal="modalGenericAlert({display: false, data: null, dataProceso: null})"
          />
      </template>
  </GenericLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue';

// Layouts
import GenericLayout from "@/Layouts/GenericLayout.vue";
import DynamicTable from "@/Components/DynamicTable.vue";

import GenericAlert from "@/Components/GenericAlert.vue";

// Componentes de los modales
import CreateUpdate from "@/Pages/GestionAcademica/MapasCurriculares/CreateUpdate.vue";

// Variables para los modales
const displayCreateUpdate = ref(false), displayGenericAlert = ref(false);
const dataRegistro = ref(null), dataProceso = ref(null)

// Métodos
const modalCreateUpdate = (event) => {
  displayCreateUpdate.value = event.display;
  dataRegistro.value = event?.data ?? null;
}

const modalGenericAlert = (event) => {
  dataRegistro.value = event.data;
  displayGenericAlert.value = event.display;
  dataProceso.value = event.proceso;
}

// Propiedades
const props = defineProps({
  mapas_curriculares: {
      type: Object,
      default: null
  }
})

// Array-Object para los items del DataTable
const items = ref([
  {
      dataField: {
          field: 'clave_mapa_curricular',
          header : 'Clave',
          sortable: true,
          type: 'text',
      },
      filters: {
          active: true,
          type: 'text',
      },
  },
  {
      dataField: {
          field: 'total_cuatrimestres',
          header : 'Total de cuatrimestres',
          sortable: true,
          type: 'text',
      },
      filters: {
          active: true,
          type: 'text',
      },
  },
  {
      dataField: {
          field: 'total_materias',
          header : 'Total de materias',
          sortable: true,
          type: 'text',
      },
      filters: {
          active: true,
          type: 'text',
      },
  },
  {
      dataField: {
          field: 'fecha_revision',
          header : 'Fecha de revisión',
          sortable: true,
          type: 'date',
      },
      filters: {
          active: true,
          type: 'date',
      },
  }
])
</script>