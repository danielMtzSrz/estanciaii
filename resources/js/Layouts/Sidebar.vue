<template>
    <Button
        icon="pi pi-align-justify"
        @click="visible = true"
        class="my-0 py-0 p-button-text p-button-sm p-button-secondary"
    />

    <Sidebar v-model:visible="visible" class="ps-2">
        <div class="my-0 py-0 d-flex flex-column align-items-center">
            <Avatar
                :image="$page.props.user.profile_photo_url"
                class="p-avatar-circle p-avatar-xl"
            ></Avatar>
            <div class="mt-2 mb-4">
                <p class="h6">{{ $page.props.user.name }}</p>
                <small>{{ $page.props.user.email }}</small>
            </div>
        </div>
        <PanelMenu :model="items" class="w-full"/>
    </Sidebar>
    
</template>

<script setup>
// Vue
import { ref } from 'vue'
// PrimeVue
import Sidebar from 'primevue/sidebar'
import Avatar from 'primevue/avatar'
import Button from 'primevue/button'
import PanelMenu from 'primevue/panelmenu'

const visible = ref(false)

const props = defineProps({
    items: {
        type: Object,
        default: {}
    }
})
</script>