<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal">
        <template #header>
            <h3 class="font-bold">Eliminar periodo</h3>
        </template>
        <template #content>
            <div class="d-flex align-items-center">
                <i class="pi pi-exclamation-triangle"/>&nbsp;
                <span>¿Seguro que desea eliminar el periodo <strong>{{ dataModal.dataRegistro?.titulo }}</strong>?</span>
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
// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Componentes personalizados
import GenericModal from '@/Assets/Components/GenericModal.vue';

const form = useForm()

const props = defineProps({
    dataModal: Object,
})

const emits = defineEmits(['visible'])

const cerrarModal = () => {
    emits("visible", false);
}
const eliminarRegistro = () => {
    form.delete(route("Calendarizaciones.Periodos.destroy", props.dataModal.dataRegistro), {
        onSuccess: () => {
            cerrarModal();
        },
    });
}
</script>
