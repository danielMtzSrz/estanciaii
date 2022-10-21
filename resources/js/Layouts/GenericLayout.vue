<template>
    <app-layout :title="titleModule">
        <div class="text-center my-4">
            <p class="display-6">{{ titleModule }}</p>
        </div>
        <slot name="content"></slot>

        <slot name="footer"></slot>
    </app-layout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

// Propiedades
const props = defineProps({
    titleModule: {
        type: String,
        default: "SIIUPQ"
    }
})
</script>