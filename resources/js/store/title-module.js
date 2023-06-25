import { defineStore } from 'pinia'
import { ref } from 'vue';

export const useTitleModuleStore = defineStore('title-module', () => {

    const title = ref("Bienvenido")

    return { 
        title 
    }
})