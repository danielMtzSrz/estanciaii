<script setup>
import { ref, watch } from "vue";
import Modal from "./Modal.vue";
import Dialog from "primevue/dialog";
import Divider from "primevue/divider";

const emit = defineEmits(["close"]);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "2xl",
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    header: {
        type: String,
        default: 'No hay título'
    }
});

const close = () => {
    emit("close");
};

const showVar = ref();
watch(
    () => props.show,
    (newVal) => {
        showVar.value = newVal;
    }
);
</script>

<template>
    <Dialog
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        :style="{ width: '50vw' }"
        :closable="true"
        :modal="true"
        :showHeader="true"
        :header="header"
        :visible="showVar"
        v-on:update:visible="close"
    >
        <div class="row col-sm-12 pt-2 px-2">
            <slot name="content" />
        </div>

        <div class="flex flex-row justify-end text-right">
            <slot name="footer" />
        </div>

    </Dialog>
</template>
