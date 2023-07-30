<template>
    <GenericModal :dataModal="dataModal" @cerrarModal="cerrarModal" :title="titulo">
        <template #header>
                <h3>Título del modal</h3>
        </template>
       <template #content>
            <!-- Aquí íria todo el Form -->
            <div class="mt-5"></div>
            <div class="row p-fluid">
            <div v-for="item in data"
                :key="item.data_field?.field"
                :class="`col-sm-${ item.data_field?.sm ?? 12 } col-md-${ item.data_field?.md ?? 12 } col-lg-${ item.data_field?.lg ?? 12 }`"
            >
                    <template v-if="item.data_field.type === 'text'">
                        <InputText
                            :id="item.data_field?.field ?? null"
                            :name="item.data_field?.field ?? null"
                            :label="item.data_field?.label ?? null"
                            :icon="item.data_field?.icon ?? null"
                            :errors="item.data_field?.errors ?? null"
                            :disabled="item.data_field?.disabled ?? false"
                            :tooltip="item.data_field.tooltip ?? null"
                            v-model="form[item?.data_field?.field]"
                            type="text"
                        />
                    </template>

                    <template v-else-if="item.data_field.type === 'number'">
                        <InputNumber
                            :name="item.data_field?.name"
                            :id="item.data_field?.id"
                            :mode="item.data_field?.mode"
                            :disabled="item.data_field?.disabled"
                            :useGrouping="item.data_field?.useGrouping"
                            v-model="form[item.data_field?.field]"
                            :errors="item.data_field?.errors"
                            v-tooltip.top="item.data_field?.tooltip"
                        />
                    </template>

                    <template v-else-if="item.data_field.type === 'dropdown'">
                        <Dropdown 
                            :textDropdown="item.data_field?.textDropdown ?? null"
                            :label="item.data_field?.label ?? null"
                            :data="item.data_field?.data ?? null"
                            v-model="form[item?.data_field?.field]"
                            :errors="form[item?.data_field?.errors]"
                        /> 
                    </template>

                    <template v-else>
                        <p>NO ES DE TEXTO</p>
                    </template>
                    
                    <div class="mb-5"></div>
                </div>
            </div>
            <pre>{{ form }}</pre>
       </template>
   </GenericModal>
 </template>
 
<script setup>
// Vue
import { ref, watch } from 'vue';
import { useForm } from "@inertiajs/inertia-vue3";

// Componentes
import InputText from '@/Components/Forms/InputText.vue'
import InputNumber from '@/Components/Forms/InputNumber.vue'
import Dropdown from '@/Components/Forms/Dropdown.vue'

// Layout
import GenericModal from '@/Components/GenericModal.vue';

const form = useForm()

const ruta = ref(null), titulo = ref(null)
const data = ref(null)

const props = defineProps({
    dataModal: {
        type: Object,
        default: null
    },
    fields: {
        type: Object,
        default: null
    }
})

const emits = defineEmits(['closeModal'])

const cerrarModal = () => {
    emits("closeModal");
    form.reset();
    form.errors = {}
}

watch(() => props.dataModal, (newVal) => {
    ruta.value = !newVal.dataRegistro ? 'GestionAcademica.Materias.store' : 'GestionAcademica.Materias.update'
    titulo.value = !newVal.dataRegistro ? 'Nueva Materia' : 'Actualizar Materia'
    data.value = props.fields;
    props?.fields.forEach(el => {
        console.log(el.data_field?.value);
        form[el.data_field?.field] = el.data_field?.value ?? null
    })
})

watch(form, newVal => {
    console.log(newVal)
})
 </script>