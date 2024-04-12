<script setup>
// Vue
import { ref } from "vue";

// Inertia
import { Inertia } from "@inertiajs/inertia";

// Primevue
import Button from 'primevue/button'
import OverlayPanel from 'primevue/overlaypanel'
import Divider from 'primevue/divider'
import Avatar from 'primevue/avatar';

defineProps({
    title: String,
});

const op = ref();

const toggle = (event) => {
    op.value.toggle(event);
};

const logout = () => {
    Inertia.post(route("logout"));
};
</script>

<template>
    <div class="flex justify-content-center align-items-center mx-2">
        <p class="my-auto hidden text-600 mr-3 md:block">{{ $page.props.user.name }} {{ $page.props.user.apellido_paterno }} {{ $page.props.user.apellido_materno }}</p>
        <Avatar 
            class="p-avatar-circle cursor-pointer p-avatar"
            :image="`${$page.props.user.profile_photo_path ? '/storage/'+$page.props.user.profile_photo_path : $page.props.user.profile_photo_url}`"
            @click="toggle"
        />
    </div>
    <OverlayPanel ref="op" class="p-0">
        <ul class="list-none p-0 m-0">
            <li>
                <Button class="p-button-secondary p-button-text">
                    <Link class="text-500 no-underline"
                        :href="route('profile.show')"
                    >
                        <i class="pi pi-user p-button-plain"></i>
                        <span class="ms-2">Perfil</span>
                    </Link>
                </Button>
            </li>
            <Divider/>
            <li>
                <form @submit.prevent="logout">
                    <Button
                        type="submit"
                        class="p-button-danger p-button-text"
                    >
                        <i class="pi pi-sign-out"/>
                        <span class="ms-2">Cerrar sesión</span>
                    </Button>
                </form>
            </li>
        </ul>
    </OverlayPanel>
</template>
