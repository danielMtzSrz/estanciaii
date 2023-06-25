<!-- /**
* ? Esto usa los siguientes atributos

| Propiedad | Tipo  | Valores                                                                                                                                                                              | Default | Descripción                                           |
| --------- | ----- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------- | ----------------------------------------------------- |
| events    | Array | [{title: '', startTime: '00:00:00', endTime: '00:00:00', daysOfWeek: ['1', '3', '5'], classNames: 'bg-soft-primary',  startRecur: '2022-09-12 00:00', endRecur: '2022-09-22 00:00'}] | null    | Listado de eventos a desplegar en la tabla de horario                                                                                                                                                                                      |         |                                                       |

* ? Fin de la definición de los atributos

* TODO: Ejemplo

* * import TimeTable from "@/Components/TimeTable.vue";
    <TimeTable 
        :events="[
            { title: 'Desarrollo Humano', startTime: '07:00:00', endTime: '08:40:00', daysOfWeek: ['1', '3', '5'], classNames: 'bg-soft-primary',
            startRecur: '2022-09-12 00:00', extendedProps: {profesor: {id: 1, nombre: 'Juan Pérez'}}},
            { title: 'Inglés', startTime: '08:40:00', endTime: '10:20:00', daysOfWeek: ['1', '3', '5'], classNames: 'bg-soft-success',
            startRecur: '2022-09-12 00:00'},
            { title: 'Matemáticas', startTime: '07:00:00', endTime: '08:40:00', daysOfWeek: ['2', '4'], classNames: 'bg-soft-danger',
            startRecur: '2022-09-12 00:00'},
        ]" />
* TODO: Fin del ejemplo
**/ -->

<template>
    <div>
        <FullCalendar ref="fullCalendar" :options="calendarOptions" />
    </div>
</template>

<script>
import { defineComponent } from "vue";
import '@fullcalendar/core/vdom' // solves problem with Vite
import AppLayout from "@/Layouts/AppLayout.vue";
import FullCalendar from '@fullcalendar/vue3';
import timeGridPlugin from '@fullcalendar/timegrid';
import Toast from 'primevue/toast';

export default defineComponent({
    components: {
        AppLayout,
        FullCalendar,
        Toast
    },
    props: {
        events: {
            type: Array,
            required: true
        },
    },
    data() {
        return {
            calendarOptions: {
                plugins: [ timeGridPlugin ],
                initialView: 'timeGridWeek',
                headerToolbar: { left: "today", center: "title", right: "prev,next" },
                titleFormat: { year: 'numeric', month: 'long' },
                buttonText: { today: 'Hoy'},
                locale: 'es',
                events: this.events,    
                eventClick: this.showTeacher,
                nowIndicator: true,
                slotMinTime: '07:00:00',
                slotMaxTime: '20:40:00',
                expandRows: true,
            }
        }
    },
    watch:{
        events(value){
            this.calendarOptions.events = value;
        }
    },
    /* methods: {
        showTeacher(info){
            const defineSeverity = info.event.extendedProps.profesor?.nombre == undefined ? 'warn' : 'info'
            this.$toast.add({severity: defineSeverity, summary: info.event.title, 
                detail: `Profesor/a: ${info.event.extendedProps.profesor?.nombre ?? 'No definido'}`, life: 1000});
        }
    } */
});
</script>