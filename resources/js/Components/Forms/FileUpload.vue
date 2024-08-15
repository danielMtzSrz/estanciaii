<template>
    <div v-if="imagenActual">
        Imagen actual
        <br>
        <Image
            imageClass="my-2"
            :src="'/storage/'+imagenActual"
            width="150"
            preview
        />
    </div>
    <FileUpload 
        :fileLimit="1"
        :multiple="true"
        :name="name"
        :maxFileSize="maxFileSize"
        :accept="accept"
        @input="inputValue = $event.target.files[0]"
        @upload="onTemplatedUpload($event)"
        @select="onSelectedFiles"
    >
        <template #header="{ chooseCallback, files }">
            <div class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2">
                <div class="flex gap-2">
                    <Button
                        @click="chooseCallback()"
                        icon="pi pi-images"
                        label="subir"
                        class="p-button-rounded p-button-outlined"
                        :disabled="files.length!==0"
                    />
                </div>
            </div>
        </template>
        <template #content="{ files, removeFileCallback }">
            <div v-if="files.length > 0">
                <div class="flex flex-wrap p-0 sm:p-5 gap-5">
                    <div v-for="(file, index) of files" :key="file.name + file.type + file.size" class="m-0 px-6 py-2 flex flex-column border-1 surface-border align-items-center gap-3">
                        <div>
                            <img role="presentation" :alt="file.name" :src="file.objectURL" width="100" height="50" class="shadow-2" />
                        </div>
                        <span class="font-semibold">{{ file.name }}</span>
                        <div>{{ formatSize(file.size) }}</div>
                        <Button icon="pi pi-times" @click="removeFileCallback(index)" class="p-fileupload-file-remove p-button-text p-button-danger p-button-rounded"></Button>
                    </div>
                </div>
            </div>
        </template>
        <template #empty>
            <div class="flex align-items-center justify-content-center flex-column">
                <i class="pi pi-cloud-upload border-2 border-circle p-5 text-8xl text-400 border-400" />
                <p class="mt-4 mb-0">{{ dropText }}</p>
            </div>
        </template>
    </FileUpload>
    <small class="p-error" v-if="errors">
        {{errors}}
    </small>
</template>

<script setup>
// Vue
import { ref, computed } from 'vue';

// Primevue
import Button from 'primevue/button';
import FileUpload from 'primevue/fileupload';
import Image from 'primevue/image';

const files = ref([]);

const onSelectedFiles = (event) => {
    inputValue.value = event.files[0]
    files.value = event.files;
}

const formatSize = (bytes) => {
    if (bytes === 0) {
        return '0 B';
    }

    let k = 1000,
        dm = 3,
        sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
        i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

const props = defineProps({
    errors: {
        type: [Object, String],
        default: null
    },
    value : {
        type: String,
        default: null
    },
    name: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        default: null
    },
    imagenActual: {
        type: String,
        default: null
    },
    dropText: {
        type: String,
        default: null
    },
    maxFileSize: {
        type: Number,
        default: 1000000
    },
    accept: {
        type: String,
        default: null
    },
    modelValue: null
})

const emits = defineEmits(['update:modelValue'])

const inputValue = computed({
  get() {
    return props.modelValue
  },
  set(value) {
    emits('update:modelValue', value)
  }
})

</script>