<template>
    <GenericModal
        :dataModal="dataModal"
        @closeModal="closeModal()" 
        :header="titulo"
        :style="{ width: '75vw' }"
    >
        <template #content>
            <FullCalendar :options="calendarOptions">
                <template v-slot:eventContent='arg'>
                    <b class="text-xs">{{ arg.event.title }}</b>
                    <br>
                    <small>{{ moment(arg.event.start).format("HH:mm A") }} - {{ moment(arg.event.end).format("HH:mm A") }}</small>
                </template>
            </FullCalendar>
        </template>
    </GenericModal>
</template>

<script setup>

// Vue
import { ref, watch } from "vue";

import moment from 'moment'

// Layouts
import GenericModal from "@/Components/GenericModal.vue";

// Fullcalendar
import '@fullcalendar/core/vdom'
import FullCalendar from '@fullcalendar/vue3'
import timeGridPlugin from '@fullcalendar/timegrid';
import esLocale from '@fullcalendar/core/locales/es';

// Variables
const titulo = ref(null);

const calendarOptions = ref({
    plugins : [timeGridPlugin],
    initialView : 'timeGridWeek',
    headerToolbar : {
        left : '',
        center : 'title',
        right: 'timeGridWeek,timeGridDay'
    },
    slotMinTime : '07:00:00',
    slotMaxTime : '21:00:00',
    slotDuration : '00:15:00',
    allDaySlot : false,
    expandRows : true,
    contentHeight: 'auto',
    locale: esLocale,
    hiddenDays : [0]
})

// Props
const props = defineProps({
    dataModal: {
        type: Object,
        default: null,
    },
});

// Emits
const emits = defineEmits(["closeModal"]);

// Methods
const closeModal = () => {
    emits("closeModal");
};

watch(() => props.dataModal.dataRegistro, async (newVal) => {
    if(newVal?.id){
        const dataHorarioGrupoMateria = await axios.get(`/api/horario/grupo_materia/${newVal?.id}`)
        calendarOptions.value.events = dataHorarioGrupoMateria.data.map($materia_horario => {
            return {...$materia_horario.horario_materia}
        })
    }

    titulo.value = `${ newVal?.nombre ?? null } - ${ newVal?.edificio_nombre ?? null }${ newVal?.aula_nombre ?? null }`
})
</script>
