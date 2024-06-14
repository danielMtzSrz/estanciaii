<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        header="Generar excel"
    >
        <template #content>
            <div class="col-sm-12 col-md-4">
                <Dropdown 
                    label="Periodo"
                    :data="dataPeriodos"
                    textDropdown="titulo"
                    v-model="periodoSeleccionado"
                />
            </div>
            <div class="float-end space-x-2 py-4">
                <Button
                    type="button"
                    label="Cancelar"
                    class="p-button-text p-button-raised p-button-rounded p-button-warning"
                    @click="closeModal()"
                />
                <a 
                    class="p-button p-component p-button-icon-only p-button-success p-button-text p-button-raised w-auto px-2"
                    :href="generateRoute('EstructuraAcademica.Aulas.generar_horario_export', 1)"
                    :disabled="!periodoSeleccionado"
                >
                    <i class="bi bi-file-earmark-excel"></i>
                    <span>Generar horario</span>
                </a>
            </div>
        </template>
    </GenericModal>
</template>

<script setup>

// Vue
import { ref, watch } from "vue";

// Primevue
import Button from "primevue/button";

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

import Dropdown from "@/Components/Forms/Dropdown.vue";

const dataPeriodos = ref(null), periodoSeleccionado = ref(null)
const aula_id = ref(1), periodo_id = ref(1)

// Props
const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

const generateRoute = (routeName) => {
    return route(routeName, { aula_id : aula_id.value, periodo_id : periodo_id.value });
};

// Emits
const emits = defineEmits(["closeModal"]);

// Methods
const closeModal = () => {
    emits("closeModal");
};

watch(() => props.dataModal.dataRegistro, async (newVal) => {
    aula_id.value = newVal?.id ?? 1
    const dataPeriodosAxios = await axios.get(`/api/periodos`);
    dataPeriodos.value = dataPeriodosAxios.data;
})

watch(() => periodoSeleccionado.value, async (newVal) => {
    periodo_id.value = newVal?.id ?? 1;
})
</script>
