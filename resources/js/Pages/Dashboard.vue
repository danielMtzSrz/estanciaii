<template>
    <GenericLayout titleModule="Menú principal">
        <template #content>
            <div class="grid">
                <div class="col-sm-12">
                    <div class="col-sm-12 col-md-4">
                        <Dropdown 
                            label="Periodo"
                            :data="dataPeriodos"
                            textDropdown="titulo"
                            v-model="periodoSeleccionado"
                        />
                    </div>
                </div>
                <div class="col-12 md:col-6 lg:col-4 flex justify-content-center" v-for="grupo in grupos" :key="grupo.id">
                    <div class="card mb-3">
                        <img :src="`${grupo.carrera.imagen == 'http' ? '' : '/storage/'}${grupo.carrera.imagen}`" class="card-img-top" style="height: 200px; width: 100%; object-fit: cover;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ grupo.nombre }} - {{ grupo.edificio_nombre }}{{ grupo.aula_nombre }}</h5>
                            <p class="card-text">{{ grupo.carrera_nombre }}</p>
                            <div class="flex justify-between flex-column">
                                <div class="flex mb-3">
                                    <Avatar
                                        style="background-color: transparent;"
                                        class="mr-2"
                                        shape="circle"
                                        :image="`${grupo.tutor.profile_photo_path == 'http' ? '' : '/storage/'}${grupo.tutor.profile_photo_path}`"
                                    />
                                    <p class="my-0 py-0">
                                        {{ grupo.tutor.nombre }}
                                    </p>
                                </div>

                                <Button
                                    type="submit"
                                    label="Ver horario"
                                    class="p-button-raised p-button-rounded p-button-success w-100 sm:w-auto mt-2 sm:mt-0"
                                    @click="modalShowSchedule({display: true, data: grupo})"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <pre>{{grupos}}</pre> -->
        </template>

        <template #footer>
            <ShowSchedule
                :dataModal="{
                    display: displayShowSchedule,
                    dataRegistro: dataRegistro,
                }"
                @closeModal="modalShowSchedule({display: false, data: null})"
            />
        </template>
    </GenericLayout>
</template>

<script setup>
// Vue
import { ref, onBeforeMount, watch } from 'vue'

// Layout padre
import GenericLayout from "@/Layouts/GenericLayout.vue";
import ShowSchedule from "./ShowSchedule.vue"

// Primevue
import Avatar from 'primevue/avatar'

import Dropdown from "@/Components/Forms/Dropdown.vue";

// Variables
const dataPeriodos = ref(null), periodoSeleccionado = ref(null)

const displayShowSchedule = ref(null)
const dataRegistro = ref(null)
const grupos = ref(null)

// Métodos
const modalShowSchedule = (event) => {
    displayShowSchedule.value = event.display;
    dataRegistro.value = event?.data ?? null;
}

onBeforeMount(async () => {    
    const data = await axios.get(`/api/panel_principal/`+null);
    grupos.value = data.data;
    const dataPeriodosAxios = await axios.get(`/api/periodos`);
    dataPeriodos.value = dataPeriodosAxios.data;
});

watch(() => periodoSeleccionado.value, async (newVal) => {
    const data = await axios.get(`/api/panel_principal/`+newVal?.id);
    grupos.value = data.data;
})
</script>