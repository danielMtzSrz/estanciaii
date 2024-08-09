<template>
    <JetFormSection>
        <template #title>
            <div class="inline-flex align-items-center">
                <i class="pi pi-key mr-2"></i>
                <b class="text-lg">Curriculum vitae</b>
            </div>
        </template>
        <template #content>
            <div class="d-flex justify-end">
                <a :href="route('user.generar_cv', user.id)" target="_blank" style="text-decoration: none;" v-if="user.cv != null">
                    <Button
                        type="button"
                        icon="bi bi-file-earmark-pdf"
                        label="Generar PDF"
                        class="p-button-rounded p-button-text p-button-danger"
                    />
                </a>
            </div>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div class="row col-12 pt-4">
                    <!-- Información de contacto -->
                    <Divider align="left" type="dashed">
                        <b>Informacion de contacto</b>
                    </Divider>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Correo electrónico"
                            name="correo_electronico"
                            v-model="form.cv.informacion_contacto.correo_electronico"
                        />
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <InputText
                            label="Enlace a perfil profesional (LinkedIn, web personal, etc)"
                            name="enlace"
                            v-model="form.cv.informacion_contacto.enlace"
                        />
                    </div>

                    <!-- Resumen -->
                    <Divider align="left" type="dashed">
                        <b>Resumen</b>
                    </Divider>

                    <div class="col-sm-12">
                        <Textarea
                            label="Breve descripción de tu experiencia, habilidades y objetivos profesionales."
                            v-model="form.cv.resumen"
                        />
                    </div>

                    <!-- Experiencia laboral -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Experiencia laboral ('+form.cv.experiencia_laboral.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('experiencia_laboral')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(experiencia_laboral, index) in form.cv.experiencia_laboral" :key="index">

                        <div class="d-flex justify-end">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                label="Eliminar"
                                class="p-button-text p-button-raised p-button-rounded p-button-danger"
                                @click="eliminarInformacion('experiencia_laboral', index)"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <InputText
                                label="Puesto"
                                name="puesto"
                                v-model="experiencia_laboral.puesto"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <InputText
                                label="Empresa"
                                name="empresa"    
                                v-model="experiencia_laboral.empresa"
                            />
                        </div>

                        <div class="col-sm-12 col-md-8">
                            <InputText
                                label="Ubicación de la empresa"
                                name="ubicacion_empresa"
                                v-model="experiencia_laboral.ubicacion_empresa"
                            />
                        </div>

                        <div class="col-sm-12 col-md-2">
                            <Calendar
                                label="Desde"
                                name="desde"
                                :showTime="false"
                                v-model="experiencia_laboral.desde"
                            />
                        </div>

                        <div class="col-sm-12 col-md-2">
                            <Calendar
                                label="Hasta"
                                name="hasta"
                                :showTime="false"
                                v-model="experiencia_laboral.hasta"
                            />
                        </div>

                        <div class="col-sm-12">
                            <Textarea
                                label="Descripción de responsabilidades y logros principales"
                                name="descripcion"
                                v-model="experiencia_laboral.descripcion"
                            />
                        </div>
                        
                        <Divider/>

                    </div>
                    
                    
                    <!-- Formación académica -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                            type="button"
                            icon="pi pi-plus"
                            :label="'Formación académica ('+form.cv.formacion_academica.length+')'"
                            class="p-button-text p-button-rounded p-button-success"
                            @click="nuevoElemento('formacion_academica')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(formacion_academica, index) in form.cv.formacion_academica" :key="index">

                        <div class="d-flex justify-end">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                label="Eliminar"
                                class="p-button-text p-button-raised p-button-rounded p-button-danger"
                                @click="eliminarInformacion('formacion_academica', index)"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <InputText
                                label="Institución"
                                name="institucion"
                                v-model="formacion_academica.institucion"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <InputText
                                label="Título obtenido"
                                name="titulo"
                                v-model="formacion_academica.titulo"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <Calendar
                                label="Desde"
                                name="desde"
                                :showTime="false"
                                v-model="formacion_academica.desde"
                            />
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <Calendar
                                label="Hasta"
                                name="hasta"
                                :showTime="false"
                                v-model="formacion_academica.hasta"
                            />
                        </div>

                        <div class="col-sm-12">
                            <Textarea
                                label="Información relevante sobre cursos o proyectos destacados"
                                name="descripcion"
                                v-model="formacion_academica.descripcion"
                            />
                        </div>

                        <Divider/>

                    </div>
                    
                    
                    <!-- Habilidades profesionales -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Habilidades profesionales ('+form.cv.habilidades_profesionales.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('habilidades_profesionales')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(habilidades_profesionales, index) in form.cv.habilidades_profesionales" :key="index">
                        <div class="col-sm-12 col-md-11">
                            <InputText
                                label="Nombre"
                                name="nombre"
                                v-model="habilidades_profesionales.nombre"
                            />    
                        </div>
                        <div class="col-sm-12 col-1 my-auto">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-text p-button-rounded p-button-danger"
                                @click="eliminarInformacion('habilidades_profesionales', index)"
                            />
                        </div>
                    </div>

                    <!-- Habilidades blandas -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Habilidades blandas ('+form.cv.habilidades_blandas.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('habilidades_blandas')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(habilidades_blandas, index) in form.cv.habilidades_blandas" :key="index">
                        <div class="col-sm-12 col-md-11">
                            <InputText
                                label="Nombre"
                                name="nombre"
                                v-model="habilidades_blandas.nombre"
                            />    
                        </div>
                        <div class="col-sm-12 col-1 my-auto">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-text p-button-rounded p-button-danger"
                                @click="eliminarInformacion('habilidades_blandas', index)"
                            />
                        </div>
                    </div>

                    <!-- Certificaciones -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Certificaciones ('+form.cv.certificaciones.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('certificaciones')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(certificaciones, index) in form.cv.certificaciones" :key="index">
                        <div class="col-sm-12 col-md-4">
                            <InputText
                                label="Certificado"
                                name="certificado"
                                v-model="certificaciones.certificado"
                            />
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <InputText
                                label="Institución"
                                name="institucion"
                                v-model="certificaciones.institucion"
                            />
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <Calendar
                                label="Fecha de obtención"
                                name="fecha"
                                :showTime="false"
                                v-model="certificaciones.fecha"
                            />
                        </div>
                        <div class="col-sm-12 col-1 my-auto">
                            <div class="d-flex align-items-center justify-content-center">
                                <Button
                                    type="button"
                                    icon="pi pi-trash"
                                    class="p-button-text p-button-rounded p-button-danger"
                                    @click="eliminarInformacion('certificaciones', index)"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Idiomas -->
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Idiomas ('+form.cv.idiomas.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('idiomas')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(idiomas, index) in form.cv.idiomas" :key="index">
                        <div class="col-sm-12 col-md-6">
                            <InputText
                                label="Idioma"
                                name="idioma"
                                v-model="idiomas.idioma"
                            />
                        </div>
                        <div class="col-sm-12 col-md-5">
                            <InputText
                                label="Nivel"
                                name="nivel"
                                v-model="idiomas.nivel"
                            />
                        </div>
                        <div class="col-sm-12 col-md-1 my-auto">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-text p-button-rounded p-button-danger"
                                @click="eliminarInformacion('idiomas', index)"
                            />
                        </div>
                    </div>

                    <!-- Proyectos
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Proyectos ('+form.cv.proyectos.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('proyectos')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(proyectos, index) in form.cv.proyectos" :key="index">
                        <div class="col-sm-12 col-md-11">
                            <Textarea
                                label="Descripción breve de proyectos relevantes, ya sean personales o profesionales"
                                name="descripcion"
                                v-model="proyectos.descripcion"
                            />
                        </div>
                        <div class="col-sm-12 col-md-1 my-auto">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-text p-button-rounded p-button-danger"
                                @click="eliminarInformacion('proyectos', index)"
                            />
                        </div>
                    </div>

                    Información adicional
                    <Divider align="left" type="dashed">
                        <div class="d-flex align-items-center justify-content-center">
                            <Button
                                type="button"
                                icon="pi pi-plus"
                                :label="'Información adicional ('+form.cv.informacion_adicional.length+')'"
                                class="p-button-text p-button-rounded p-button-success"
                                @click="nuevoElemento('informacion_adicional')"
                            />
                        </div>
                    </Divider>

                    <div class="row col-12" v-for="(informacion_adicional, index) in form.cv.informacion_adicional" :key="index">
                        <div class="col-sm-12 col-md-11">
                            <Textarea
                                label="Publicaciones, conferencias, premios, actividades extracurriculares o voluntariados, si son relevantes para el puesto al que aplicas."
                                name="descripcion"
                                v-model="informacion_adicional.descripcion"
                            />
                        </div>
                        <div class="col-sm-12 col-md-1 my-auto">
                            <Button
                                type="button"
                                icon="pi pi-trash"
                                class="p-button-text p-button-rounded p-button-danger"
                                @click="eliminarInformacion('informacion_adicional', index)"
                            />
                        </div>
                    </div> -->
                </div>

                <div class="float-end space-x-2 py-4">
                    <Message
                        v-if="form.recentlySuccessful" 
                        severity="success"
                        class="mr-2"
                    >
                    Contraseña actualizada.
                    </Message>
                    <Button
                        type="submit"
                        label="Guardar"
                        class="p-button-text p-button-raised p-button-rounded p-button-success"
                        :loading="form.processing"
                    />
                </div>
            </form>
        </template>

        <template #actions>
            
        </template>
    </JetFormSection>
</template>

<script setup>
import { onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

import JetFormSection from '@/Jetstream/FormSection.vue';

import Message from 'primevue/message';
import Button from 'primevue/button';
import Divider from 'primevue/divider';

import InputText from "@/Components/Forms/InputText.vue";
import Calendar from "@/Components/Forms/Calendar.vue";
import Textarea from "@/Components/Forms/Textarea.vue";

const props = defineProps({
    user : {
        type: Object,
        default: null
    }
})

const form = useForm({
    _method: 'PUT',
    cv : {
        informacion_contacto : {},
        resumen : null,
        experiencia_laboral : [],
        formacion_academica : [],
        habilidades_profesionales : [],
        habilidades_blandas : [],
        certificaciones : [],
        idiomas : [],
        proyectos : [],
        informacion_adicional : []
    }
});

const nuevoElemento = (atributo) => form.cv[atributo].push({})

const eliminarInformacion = (atributo, index) => form.cv[atributo].splice(index, 1)

const submit = () => {
    form.post(route('user.update_cv', props.user.id));
};

onMounted(() => {
    if (props.user && props.user.cv) {
        const parsedCv = JSON.parse(props.user.cv);
        form.cv = {
            informacion_contacto: parsedCv.informacion_contacto || {},
            resumen: parsedCv.resumen || null,
            experiencia_laboral: parsedCv.experiencia_laboral || [],
            formacion_academica: parsedCv.formacion_academica || [],
            habilidades_profesionales: parsedCv.habilidades_profesionales || [],
            habilidades_blandas: parsedCv.habilidades_blandas || [],
            certificaciones: parsedCv.certificaciones || [],
            idiomas: parsedCv.idiomas || [],
            proyectos: parsedCv.proyectos || [],
            informacion_adicional: parsedCv.informacion_adicional || []
        };
    }
});
</script>