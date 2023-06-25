<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal">
        <template #header>
            <h3 class="font-bold">{{ alertProcess?.alertTitle }}</h3>
        </template>
        <template #content>
            <div class="d-flex align-items-center">
                <i class="pi pi-exclamation-triangle"/>&nbsp;
                <span v-html="`¿Seguro que desea <strong>${alertProcess?.textAlert}</strong> el registro <strong>${dataModal.dataProceso?.registro ?? null}?</strong>`"></span>
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
                    :icon="alertProcess?.icon"
                    :label="alertProcess?.alertTitle"
                    :class="`p-button-text p-button-raised p-button-rounded p-button-${alertProcess?.color}`"
                    @click="submit()"
                    :loading="form.processing"
                />
            </div>
        </template>
    </GenericModal>
</template>

<script setup>
import { ref, watch } from 'vue';

// Inertia
import { useForm } from "@inertiajs/inertia-vue3";

// Primevue
import Button from "primevue/button";

// Componentes personalizados
import GenericModal from '@/Components/GenericModal.vue';

const form = useForm()
const proceso = ref(null)
const alertProcess = ref(null)

const props = defineProps({
    dataModal: Object,
})

const emits = defineEmits(['visible'])

// Métodos
const cerrarModal = () => {
    emits("visible", false);
}
const submit = () => {
    if(proceso.value == 'FORCEDELETE' || proceso.value == 'DESTROY' || proceso.value == 'DELETE'){
        form.delete(route(props.dataModal.dataProceso.ruta, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }else if(proceso.value == 'RESTORE'){
        form.post(route(props.dataModal.dataProceso.ruta, props.dataModal.dataRegistro), {
            onSuccess: () => {
                cerrarModal();
            },
        });
    }
}

const procesoExecute = () => {
    const dataProcess = {
        'FORCEDELETE' : {
            'alertTitle' : 'Eliminar definitivamente',
            'textAlert' : 'ELIMINAR DEFINITIVAMENTE',
            'icon' : 'pi pi-trash',
            'color' : 'danger'
        },
        'RESTORE' : {
            'alertTitle' : 'Restaurar',
            'textAlert' : 'restaurar',
            'icon' : 'bi bi-arrow-counterclockwise',
            'color' : 'success'
        },
        'DELETE' : {
            'alertTitle' : 'Eliminar',
            'textAlert' : 'eliminar',
            'icon' : 'pi pi-trash',
            'color' : 'danger'
        },
        'DESTROY' : {
            'alertTitle' : 'Eliminar',
            'textAlert' : 'eliminar',
            'icon' : 'pi pi-trash',
            'color' : 'danger'
        }
    }
    alertProcess.value = dataProcess[proceso.value]
}

// Watchers
watch(() => props.dataModal.dataProceso, (newVal) => {
    proceso.value = newVal?.proceso.toUpperCase() ?? null
    procesoExecute()
})
</script>
