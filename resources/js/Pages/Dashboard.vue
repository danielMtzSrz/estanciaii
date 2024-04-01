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
                                    @click="openModal(grupo.horarios)"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <GenericModal
                    :dataModal="dataModal"
                    @closeModal="closeModal" 
                    header="Grupo"
                >
                    <template #content>
                        <FullCalendar :options="calendarOptions" />
                        <pre>{{ dataHorarios }}</pre>
                    </template>
                </GenericModal>

            </div>

            <pre>{{grupos}}</pre>
        </template>
    </GenericLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue'

// Layout padre
import GenericLayout from "@/Layouts/GenericLayout.vue";
import GenericModal from "@/Components/GenericModal.vue";

// Fullcalendar
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'
import timeGridPlugin from '@fullcalendar/timegrid';

// Primevue
import Avatar from 'primevue/avatar'

const props = defineProps({
    grupos: {
        type: Object,
        default: {}
    }
})

const calendarOptions = ref({
    plugins: [timeGridPlugin],
    initialView: 'timeGridWeek',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'timeGridDay,timeGridWeek'
    },
    allDaySlot: false,
    expandRows: true,
    events: [
        {
            title: 'Horario Lunes',
            startTime: '10:00:00',
            endTime: '13:00:00',
            daysOfWeek: [1],
        },
        {
            title: 'Horario Jueves',
            startTime: '10:00:00',
            endTime: '13:00:00',
            daysOfWeek: [4],
        }
    ]
})

const dataHorarios = ref(null)

const dataModal = ref({
    display : false
})

function agruparHorarios(horarios) {
    const resultado = {};

    Object.keys(horarios).forEach(clave => {
        
        if (!clave.includes('_hora')) {
            const dia = clave; // Ej: 'lunes'
            const activo = horarios[clave];
            
            if (!resultado[dia]) {
                resultado[dia] = { activo };
            } else {
                resultado[dia].activo = activo;
            }
        } else {
            const [dia, tipoHora] = clave.split('_hora_');
            const valorHora = horarios[clave];
            
            if (!resultado[dia]) {
                resultado[dia] = { activo: false };
            }
            
            resultado[dia][tipoHora] = valorHora;
        }
    });

  return resultado;
}

const openModal = (horarios) => {
    dataHorarios.value = agruparHorarios(horarios);
    dataModal.value = {display : true};
}

// Methods
const closeModal = () => {
    dataModal.value = {display : false};
};
</script>