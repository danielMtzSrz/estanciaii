<template>
	<AppLayout title="Direccion Carrera">
		<Panel :header="(`Asigna Horarios - Programación Académica ` + periodo.titulo)" class="mb-3">
			<DataTable :value="gruposMateria" rowGroupMode="subheader" groupRowsBy="grupo.nombre" :expander="true"
				sortMode="single" sortField="grupo.nombre" :sortOrder="1" responsiveLayout="scroll"
				:expandableRowGroups="true" v-model:expandedRowGroups="expandedRowGroups">
				<Column v-for="col of columns" :field="col.field" :header="col.header" :key="col.field"
                        :sortable="col.sortable"/>
				<Column header="Horarios">
					<template #body="{ data }">
						<div class="container">
							<Chip v-for="(item, index) in data.horario_grupo_materia" :key="index" class="block align-items-center my-1">
									<div class="align-items-center justify-content-center flex">
										{{item.horario.dia_semana.nombre + ` ` + item.horario.hora_inicio + `-` + item.horario.hora_fin}}
									</div>
									<div class="align-items-center justify-content-center flex">
										{{item.horario.aula.nombre}}
									</div>
									<!-- <p> {{item.horario.aula.nombre}} </p> -->
							</Chip>
						</div>
					</template>
				</Column>
				<Column headerStyle="width: 4rem; text-align: center" bodyStyle="text-align: center; overflow: visible">
					<template #body="{ data }">
						<Link :href="route('ProgramacionAcademica.DireccionCarrera.AsignaHorarios.edit', data.id)">
							<Button type="button" icon="pi pi-pencil" class="p-button-rounded p-button-warning">
						</Button>
						</Link>
					</template>
				</Column>
				<template #groupheader="slotProps">
					<span>
						<i class="ms-2 pi pi-users"></i>
						{{ slotProps.data.grupo.nombre }}
					</span>
				</template>
				<template #groupfooter="slotProps">
					<td colspan="5" style="text-align: right"><b>Total materias:</b></td>
					<td>{{ calcularTotalMaterias(slotProps.data.grupo.nombre) }}</td>
				</template>
			</DataTable>
		</Panel>
	</AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from 'primevue/button';
import Chip from 'primevue/chip';
import Column from "primevue/column";
import DataTable from 'primevue/datatable';
import Panel from 'primevue/panel';
const props = defineProps({
	gruposMateria: {
		type: Array,
		required: true
	},
	periodo: {
		type: Object,
		required: true
	}
})

const columns = ref(null)
const expandedRowGroups = ref();

const calcularTotalMaterias = (nombre) => {
	let total = 0;

	if (props.gruposMateria) {
		for (let materia of props.gruposMateria) {
			if (materia.grupo.nombre == nombre) {
				total++;
			}
		}
	}

	return total;
};

onMounted(() => {
    columns.value = [
        { field: 'nombre', header: 'Grupo', sortable: true },
        { field: 'materia.nombre', header: 'Materia', sortable: true },
    ];
})
</script>