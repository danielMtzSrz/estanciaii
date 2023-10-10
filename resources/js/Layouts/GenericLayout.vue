<template>
    <AppLayout :title="titleModule">
        <p class="display-6">&nbsp;</p>
        <slot name="content"></slot>
        <slot name="footer"></slot>
    </AppLayout>
</template>

<script setup>
// Layouts
import AppLayout from "@/Layouts/AppLayout.vue";

// Propiedades
const props = defineProps({
    titleModule: {
        type: String,
        default: null
    }
})
</script>