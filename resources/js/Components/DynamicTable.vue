<!-- 

Propiedades principales
-----------------------
| Propiedad   | Descripción                                          | Values           | type          | Default                 |
| ----------- | ---------------------------------------------------- | ---------------- | ------------- | ----------------------- |
| data        | Recibe la colección de datos para cargar la tabla    | [{}]             | Array-Objects | null                    |
| titleModule | Nombre del modulo                                    | String           | String        | Falta definir el titulo |
| pdfRoute    | Ruta para exportar a PDF                             | route('pdfRuta') | String        | null                    |
| items       | Recibe cada uno de las columnas para cargar la tabla | [{}]             | Array-Objects | null                    |


Propiedades dentro de :items="[]"
---------------------------------
| Propiedad | Descripción                                                     | Values | type   |
| --------- | --------------------------------------------------------------- | ------ | ------ |
| dataField | Recibe cada una de las opciones para esa columna                | {}     | Object |
| filters   | Recibe cada una de las opciones para los filtros de esa columna | {}     | Object |


Propiedades dentro de dataField: {} para columnas de texto
----------------------------------------------------------
| Propiedad   | Descripción                                                     | Values     | type    |
| ----------- | --------------------------------------------------------------- | ---------- | ------- |
| field       | El nombre del atributo que contiene el valor que desean mostrar | String     | String  |
| header      | El encabezado de la tabla en esa columna                        | String     | String  |
| sortable    | Valor booleano para decidir si ordernar o no los valores        | true/false | Boolean |
| headerStyle | Estilos que tendrá la cabecera de la columna en concreto        | String     | String  |
| type        | Manera en la que se mostrará la información                     | text       | String  |


Propiedades dentro de dataField: {} para columnas de avatar (logo y texto)
--------------------------------------------------------------------------
| Propiedad   | Descripción                                                         | Values     | type    |
| ----------- | ------------------------------------------------------------------- | ---------- | ------- |
| field       | El nombre del atributo que contiene el valor que desean mostrar     | String     | String  |
| header      | El encabezado de la tabla en esa columna                            | String     | String  |
| sortable    | Valor booleano para decidir si ordernar o no los valores            | true/false | Boolean |
| type        | Manera en la que se mostrará la información                         | avatar     | String  |
| headerStyle | Estilos que tendrá la cabecera de la columna en concreto            | String     | String  |
| avatarText  | Texto que aparecerá al lado de la imagen (avatar) igual es un field | text       | String  |


Propiedades dentro de dataField: {} para columnas de HTML
----------------------------------------------------------
| Propiedad   | Descripción                                                     | Values     | type    |
| ----------- | --------------------------------------------------------------- | ---------- | ------- |
| field       | El nombre del atributo que contiene el valor que desean mostrar | String     | String  |
| header      | El encabezado de la tabla en esa columna                        | String     | String  |
| sortable    | Valor booleano para decidir si ordernar o no los valores        | true/false | Boolean |
| type        | Manera en la que se mostrará la información                     | html       | String  |
| headerStyle | Estilos que tendrá la cabecera de la columna en concreto        | String     | String  |


Propiedades dentro de dataField: {} para columnas de image
----------------------------------------------------------
| Propiedad   | Descripción                                                     | Values     | type    |
| ----------- | --------------------------------------------------------------- | ---------- | ------- |
| field       | El nombre del atributo que contiene el valor que desean mostrar | String     | String  |
| header      | El encabezado de la tabla en esa columna                        | String     | String  |
| sortable    | Valor booleano para decidir si ordernar o no los valores        | true/false | Boolean |
| type        | Manera en la que se mostrará la información                     | html       | String  |
| headerStyle | Estilos que tendrá la cabecera de la columna en concreto        | String     | String  |
| alt         | Texto alternativo de la imagen (es un field)                    | String     | String  |


Propiedades dentro de filters: {}
---------------------------------
| Propiedad | Descripción                                             | Values            | type    |
| --------- | ------------------------------------------------------- | ----------------- | ------- |
| active    | Valor booleano para decidir si mostrar o no los filtros | true/false        | Boolean |
| type      | Tipo de filtro a implementar                            | text/date/numeric | String  |


<DynamicTable
    :data="data"
    titleModule="Anuncios"
    :pdfRoute="route('pdfGaleria')"
    :items="[
        {
            dataField: {
                field: 'empresaImagen',
                avatarText : 'empresaNombre',
                header : 'Empresa',
                sortable: true,
                type: 'avatar',
            },
            filters: {
                active: true,
                type: 'text',
            },
        },
        {
            dataField: {
                field : 'name',
                header : 'Nombre',
                sortable: true,
                type: 'text',
            },
            filters: {
                active: true,
                type: 'text',
            },
        },
        {
            dataField: {
                field : 'contenido',
                header : 'Contenido',
                sortable: false,
                type: 'html',
                headerStyle: 'width: 20em'
            },
            filters: {
                active: false,
                type: 'text',
            },
        },
        {
            dataField: {
                field : 'imagen',
                header : 'Imagen',
                alt: 'titulo',
                sortable: false,
                type: 'image',
                headerStyle: 'width: 10em'
            },
            filters: {
                active: false,
                type: 'text',
            },
        },
        {
            dataField: {
                field : 'fecha_fin',
                header : 'Fecha fin',
                sortable: true,
                type: 'date',
            },
            filters: {
                active: true,
                type: 'date',
            },
        },
    ]"
>
 -->

 <template>
    <!-- Inicio DataTable -->
    <GenericTable
        v-bind="$attrs"
        :data="dat"
        :titleModule="titleModule"
        :fields="fields"
        @selectedRegisters="selectedRegisters = $event"
        :selectedRows="selectedRows"
        :selectionModeRow="selectionModeRow"
        :selectionModeCheck="selectionModeCheck"
        @rowSelect="onRowSelect"
        @rowUnselect="onRowUnselect"
    >
        <template #headerContent>
            <slot name="header" v-bind="{ selectedRegisters }"></slot>
            <a
                v-if="pdfRoute"
                :href="pdfRoute"
                target="_blank"
                style="text-decoration: none"
            >
                <Button
                    type="button"
                    icon="bi bi-file-earmark-pdf"
                    label="Generar PDF"
                    class="p-button-raised p-button-rounded p-button-text p-button-danger p-button-sm ms-2"
                />
            </a>
        </template>
        <template #content>
            <Column
                v-for="item in items"
                :field="item.dataField.field"
                :header="item.dataField.header"
                :key="item.dataField.field"
                :sortable="item.dataField.sortable"
                :exportFooter="item.dataField.header"
                :filterField="item.dataField.field"
                :headerStyle="item.dataField.headerStyle"
                :dataType="item.filters.type"
            >
                <!-- Table data -->
                <template #body="{ data, index }">
                    
                    <!-- Campo de texto -->
                    <template v-if="item.dataField.type === 'text'">
                        <template v-if="data[item.dataField.field]">
                            {{ data[item.dataField.field] }}
                        </template>
                        <template v-else>
                            <span class="p-error">Sin definir</span>
                        </template>
                    </template>

                    <!-- Campo de fecha -->
                    <template v-if="item.dataField.type === 'date'">
                        {{ formatDate(data[item.dataField.field]) }}
                    </template>

                    <!-- Campo de fecha con hora -->
                    <template v-if="item.dataField.type === 'datetime'">
                        {{ formatDateTime(data[item.dataField.field]) }}
                    </template>

                    <!-- Campo de imagen -->
                    <template v-else-if="item.dataField.type === 'image'">
                        <Image
                            :src="`/storage/${data[item.dataField.field]}`"
                            :alt="data[item.dataField.field]"
                            width="200"
                            preview
                        />
                    </template>

                    <!-- Campo de Avatar -->
                    <template v-else-if="item.dataField.type === 'avatar'">
                        <div class="flex align-items-center">
                            <!-- <Avatar
                                class="p-avatar-image p-avatar-circle p-avatar-lg"
                                :image="`${data[item.dataField.field]?.substring(0, 4) == 'http' ? '' : '/storage/'}${data[item.dataField.field]}`"
                            /> -->
                            <Image
                                imageClass="p-avatar-image p-avatar-circle p-avatar-lg"
                                :src="`${data[item.dataField.field]?.substring(0, 4) == 'http' ? '' : '/storage/'}${data[item.dataField.field]}`"
                                width="35"
                                preview
                            />
                            <p class="my-0 py-0 ms-3">
                                {{ data[item.dataField.avatarText] }}
                            </p>
                        </div>
                    </template>

                    <!-- Campo con renderización de HTML -->
                    <template v-else-if="item.dataField.type === 'html'">
                        <Button
                            type="button"
                            icon="pi pi-eye"
                            :label="`${item.dataField.header}`"
                            class="p-button-text p-button-raised p-button-rounded p-button-primary"
                            @click="openModal(index)"
                        />
                        <Dialog
                            :visible="displayHTML[index]"
                            :breakpoints="{ '960px': '75vw', '640px': '90vw' }"
                            :style="{ width: '50vw' }"
                            :modal="true"
                            :header="item.dataField.header"
                            v-on:update:visible="closeModal(index)"
                        >
                            <div v-html="data[item.dataField.field]"></div>
                            <div class="float-end space-x-2 mt-4">
                                <Button
                                    label="Cerrar"
                                    icon="pi pi-times"
                                    class="p-button-text p-button-raised p-button-rounded p-button-warning"
                                    @click="closeModal(index)"
                                />
                            </div>
                        </Dialog>
                    </template>
                </template>
                <!-- Fin table data -->

                <!-- Filtros -->
                <template #filter="{ filterModel }" v-if="item.filters.active">

                    <!-- Filtro de Texto -->
                    <template v-if="item.filters.type === 'text'">
                        <InputText
                            type="text"
                            v-model="filterModel.value"
                            class="p-column-filter"
                            placeholder="Búscar"
                        />
                    </template>

                    <!-- Filtro numérico -->
                    <template v-else-if="item.filters.type === 'numeric'">
                        <InputNumber
                            v-model="filterModel.value"
                            locale="en-US"
                            :mode="item.filters.mode ?? 'decimal'"
                            :currency="item.filters.currency"
                            :prefix="item.filters.prefix"
                            :suffix="item.filters.suffix"
                            :minFractionDigits="
                                item.filters.minFractionDigits ?? 2
                            "
                            :maxFractionDigits="
                                item.filters.maxFractionDigits ?? 2
                            "
                            :min="item.filters.min"
                            :max="item.filters.max"
                            :useGrouping="item.filters.useGrouping ?? true"
                            placeholder="Búscar"
                        />
                    </template>

                    <!-- Filtro de fecha -->
                    <template v-else-if="item.filters.type === 'date'">
                        <Calendar
                            v-model="filterModel.value"
                            dateFormat="mm/dd/yy"
                            placeholder="mm/dd/yyyy"
                        />
                    </template>
                </template>
                <template #filterclear="{ filterCallback }">
                    <Button
                        type="button"
                        icon="pi pi-filter-slash"
                        class="pt-0 p-button-help p-button-text p-button-raised p-button-rounded p-button-sm"
                        @click="filterCallback()"
                    />
                </template>
                <template #filterapply="{ filterCallback }">
                    <Button
                        type="button"
                        icon="pi pi-search"
                        label="Filtrar"
                        class="p-button-success p-button-text p-button-raised p-button-rounded p-button-sm"
                        @click="filterCallback()"
                    />
                </template>
                <!-- Fin filtros -->
            </Column>
            <slot name="columns"></slot>
            <Column headerStyle="width: 8em" bodyStyle="text-align: center">
                <template #body="{ data }">
                    <slot
                        name="buttons"
                        v-bind="{ data, selectedRegisters }"
                    ></slot>
                </template>
            </Column>
        </template>
    </GenericTable>
    <!-- Fin DataTable -->
</template>
<script setup>
import { ref, computed, watch, onMounted } from "vue";

import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";

// Primevue
import Column from "primevue/column";
import Button from "primevue/button";
import Image from "primevue/image";
import Avatar from "primevue/avatar";
import InputText from "primevue/inputtext";
import Calendar from "primevue/calendar";
import InputNumber from "primevue/inputnumber";
import Dialog from "primevue/dialog";

// Layout padre
import GenericTable from "@/Components/GenericTable.vue";

import moment from "moment";

const fields = {};
props.items.forEach((el) => (fields[el.dataField.field] = el.filters.type));
const displayForm = ref(null);
const selectedRegisters = ref(null);

const displayHTML = ref([]);

props.data?.forEach((el) => displayHTML.value.push(false));

const props = defineProps({
    data: {
        type: Object,
        defautl: null,
    },
    items: {
        type: Object,
        default: null,
    },
    titleModule: {
        type: String,
        default: "Falta definir el titulo",
    },
    pdfRoute: {
        type: String,
        default: null,
    },
    selectedRows: {
        type: Boolean,
        default: false,
    },
    selectionModeRow: {
        type: String,
        default: null,
    },
    selectionModeCheck: {
        type: String,
        default: null,
    },
});

const openModal      = (index) => displayHTML.value[index] = true;
const closeModal     = (index) => displayHTML.value[index] = false;
const formatDate     = (fecha) => moment(fecha).format("D [de] MMM YYYY");
const formatDateTime = (fecha) => moment(fecha).format("D [de] MMM, YYYY - h:mm:ss a");

moment.locale("es", {
    months : "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split("_"),
    monthsShort : "Enero._Feb._Mar_Abr._May_Jun_Jul._Ago_Sept._Oct._Nov._Dic.".split("_"),
    weekdays : "Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado".split("_"),
    weekdaysShort : "Dom._Lun._Mar._Mier._Jue._Vier._Sab.".split("_"),
    weekdaysMin : "Do_Lu_Ma_Mi_Ju_Vi_Sa".split("_"),
});

const dat = computed(() => {
    let dat = props.data;
    props.items
        // Filtra por las fechas
        .filter((item) => item.filters.type === "date")
        .forEach(({ dataField }) => {
            // Cambia las fechas de String a Date
            dat = props?.data?.map((dato) => {
                dato[dataField.field] = new Date(dato[dataField.field]);
                return dato;
            }) ?? null;
        });
    return dat
});

// Emits
const emits = defineEmits(["rowSelect", "rowUnselect"]);

// Methods
const onRowSelect   = (event) => emits("rowSelect", event);
const onRowUnselect = (event) => emits("rowUnselect", event);
</script>
