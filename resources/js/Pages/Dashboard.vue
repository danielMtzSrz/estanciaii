<template>
    <GenericLayout titleModule="Menú principal">
        <template #content>
            <div class="grid">

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

            <pre>{{grupos}}</pre>
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
import { ref } from 'vue'

// Layout padre
import GenericLayout from "@/Layouts/GenericLayout.vue";
import ShowSchedule from "./ShowSchedule.vue"

// Primevue
import Avatar from 'primevue/avatar'

// Variables
const displayShowSchedule = ref(null)
const dataRegistro = ref(null)

// Props
const props = defineProps({
    grupos: {
        type: Object,
        default: {}
    }
})

// Métodos
const modalShowSchedule = (event) => {
    displayShowSchedule.value = event.display;
    dataRegistro.value = event?.data ?? null;
}
</script>