<template>
    <div>
        <Toast />
        <Head :title="title" />
        <JetBanner />

        <div
            class="min-h-screen dark:modoOscur"
            :class="{ modoOscuro: darkMode, 'bg-gray-300' : !darkMode }"
            id="contentMain"
        >
            <Header :darkMode="darkMode" @themeColor="themeColor"> </Header>

            <!-- Page Content -->
            <div class="container mt-4">
                {{ this.breadcrumbItems }}
                <div class="row justify-content-center">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import JetBanner from "@/Jetstream/Banner.vue";
import Header from "@/Assets/Components/Header.vue";
import InputSwitch from "primevue/inputswitch";
import Breadcrumb from "@/Assets/Components/primevue/Menu/Breadcrumb.vue";
import Toast from "primevue/toast";
import Button from "primevue/button";
import { useToast } from "primevue/usetoast";
import { Inertia } from "@inertiajs/inertia";
export default {
    mounted() {
        const toast = useToast();
        const to = usePage().props?.value?.toast ?? null

        if (to) {
            if (!Object.values(to).includes(null) && to.severity) {
                toast.add({
                    severity: to.severity,
                    summary: to.summary,
                    detail: to.detail,
                    life: to.life,
                });
            }
        }
    },
    setup() {
        // console.log(usePage().props.value.flash);
        const toast=useToast()
        const toastData = computed(() => usePage().props.value.flash);

        watch(toastData, (newData, oldData) => {
            if (Object.values(newData).includes(null)) {
                return;
            }

            toast.add({
                severity: newData.severity,
                summary: newData.summary,
                detail: newData.detail,
                life: newData.life,
            });
        });
    },

    components: {
        Head,
        JetBanner,
        Header,
        InputSwitch,
        Breadcrumb,
        Toast,
        Button,
    },
    data() {
        return {
            darkMode: true,
            checked: true,
            home: {
                icon: "pi pi-home",
                command:() => this.$inertia.visit(route('dashboard'))
            },
            items: usePage().props.value.breadcrumbItems.map(item=>(
                {
                    label:item.label,
                    command:()=>this.$inertia.visit(item.url)
                })
            ),

           
        };
    },
    props: {
        title: String,
        breadcrumbItems: Array,
    },
    methods: {
        theme() {
            return this.darkMode
                ? "/themes/bootstrap4-dark-blue/theme.css"
                : "/themes/bootstrap4-light-blue/theme.css";
        },
        themeColor() {
            this.darkMode = this.cheked = !this.darkMode;
            let container = document.getElementById("contentMain");
            let themeElement = document.getElementById("theme-link");
            let div = document.getElementById("main-container");
            // console.log(div);
            if (this.darkMode) {
                localStorage.setItem("darkMode", true);
                document.documentElement.classList.add("dark");
                container.classList.add("modoOscuro");
                div.classList.add("dark");
            } else {
                localStorage.setItem("darkMode", false);
                document.documentElement.classList.remove("dark");
                container.classList.remove("modoOscuro");
                div.classList.remove("dark");
            }
            themeElement.setAttribute("href", this.theme());
        },
    },
    beforeMount() {
        let cargar = async () => {
            let dark = localStorage.getItem("darkMode");
            if (dark === "true") {
                this.darkMode = this.checked = true;
            } else {
                this.darkMode = this.checked = false;
            }
            let themeElement = document.getElementById("theme-link");
            await setTimeout(() => {
                themeElement.setAttribute("href", this.theme());
            }, 200);
        };
        cargar();
    },
};
</script>

<style>
.modoOscuro {
    background-color: #20262e;
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro .card {
    background-color: #20262e;
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro input {
    background-color: #20262e;
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro label {
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro p {
    color: rgba(255, 255, 255, 0.87);
}
.modoOscuro strong {
    color: rgba(255, 255, 255, 0.87);
}

@media (prefers-color-scheme: dark) {
    ::-webkit-scrollbar {
        width: 12px;
    }

  

    ::-webkit-scrollbar-thumb {
        background-color: #565c6323;
        border-radius: 20px;
        border: 3px solid #454e5ab6;
    }
}
</style>
