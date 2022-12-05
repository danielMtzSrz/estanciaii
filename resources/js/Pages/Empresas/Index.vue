<template>
    <GenericLayout titleModule="Empresas">
        <template #content>
            <GenericTable :data="dataEmpresas">
                <template #headerContent>
                    <Button
                        type="button"
                        label="Nuevo"
                        v-tooltip="`Crear`"
                        icon="pi pi-plus"
                        class="p-button-raised p-button-rounded p-button-text p-button-success p-button-sm"
                        @click="modalCreateUpdate(null, true)"
                    />
                </template>
                <template #content>
                    <Column
                        v-for="col of columns"
                        :field="col.field"
                        :header="col.header"
                        :key="col.field"
                        :sortable="col.sortable"
                    ></Column>
                    <Column
                        headerStyle="width: 8em"
                        bodyStyle="text-align: center"
                    >
                        <template #body="slotProps">
                            <!-- <Button v-permission="'permission.update'" -->
                            <Button
                                type="button"
                                v-tooltip="`Editar`"
                                icon="pi pi-pencil"
                                class="p-button-warning p-button-text p-button-raised p-button-rounded"
                                @click="modalCreateUpdate(slotProps.data, true)"
                            />
                            <Button
                                type="button"
                                v-tooltip="`Borrar`"
                                icon="pi pi-trash"
                                class="p-button-danger p-button-text p-button-raised p-button-rounded"
                                @click="
                                    modalGenericAlert(slotProps.data, true, {
                                        proceso: 'delete',
                                        ruta: 'empresas.destroy',
                                        registro: `<strong>${slotProps.data.nombre}</strong?`,
                                    })
                                "
                            />
                        </template>
                    </Column>
                </template>
            </GenericTable>
        </template>

        <template #footer>
            <!-- Modal crear - actualizar -->
            <form-create-update
                :dataModal="{
                    display: displayCreateUpdate,
                    dataRegistro: dataRegistro,
                }"
                @visible="(visible) => modalCreateUpdate(null, visible)"
            />
            <!-- Alerta Eliminar -->
            <GenericAlert
                :dataModal="{
                    display: displayAlert,
                    dataRegistro: dataRegistro,
                    dataProceso: dataProceso,
                }"
                @visible="(visible) => modalGenericAlert(null, visible, null)"
            />
        </template>
    </GenericLayout>
</template>

<script setup>
import { ref, onMounted } from "vue";

// Componentes de primevue
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

// Componentes personalizados
import GenericLayout from "@/Assets/Components/GenericLayout.vue";
import GenericTable from "@/Assets/Components/GenericTable.vue";

import GenericAlert from "@/Assets/Components/GenericAlert.vue";

// Componentes de los modales
import FormCreateUpdate from "@/Pages/Empresas/CreateUpdate.vue";

// Variables
const displayCreateUpdate = ref(false);
const displayAlert = ref(false);
const dataProceso = ref(null);
const dataRegistro = ref(null);
const columns = ref(null);
const dataEmpresas = ref(null);

// Propiedades
const props = defineProps({
    empresas: {
        type: Object,
        default: {},
    },
});

// Métodos
const modalCreateUpdate = (data, show) => {
    dataRegistro.value = data;
    displayCreateUpdate.value = show;
};

const modalGenericAlert = (data, show, dataProcess) => {
    dataRegistro.value = data;
    displayAlert.value = show;
    dataProceso.value = dataProcess;
};

onMounted(() => {
    // aplanar el domicilio de las empresas
    const empresaDocmicilio = props.empresas.map((empresa) => ({
        ...empresa,
        nColonia: empresa.domicilio.colonia.nombre,
        nMunicipio: empresa.domicilio.colonia.municipio.nombre,
        nEstado: empresa.domicilio.colonia.municipio.estado.nombre,
    }));
    dataEmpresas.value = empresaDocmicilio.map((empresa) => ({
        id: empresa.id,
        nombre: empresa.nombre_empresa,
        razon_social: empresa.razon_social,
        rfc: empresa.rfc,
        domicilioNombre: `${empresa.domicilio.calle} #${
            empresa.domicilio.numero_exterior
        } ${
            empresa.domicilio.numero_interior
                ? "int." + empresa.domicilio.numero_interior
                : ""
        },${empresa.nColonia},${empresa.nMunicipio},${empresa.nEstado}`,
        domicilio: empresa.domicilio
    }));

    columns.value = [
        { field: "nombre", header: "Nombre", sortable: true },
        { field: "razon_social", header: "Razon Social", sortable: true },
        { field: "rfc", header: "RFC", sortable: true },
        { field: "domicilioNombre", header: "Domicilio", sortable: true },
    ];
});
</script>
