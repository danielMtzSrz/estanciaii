<script setup>
import Card from 'primevue/card';
import Divider from 'primevue/divider'

const props = defineProps({
    hasActions: Object
})
</script>

<template>
    <Card style="box-shadow: 7px 7px #83838312">
        <template #title>
                <Divider align="left" type="dashed"><slot name="title" /></Divider>
        </template>
        <template #content>
            <div class="row col-sm-12">
                <div class="mt-3 md:mt-0 md:col-span-2">
                    <form @submit.prevent="$emit('submitted')">
                        <div
                            class="ps-4 sm:ps-6"
                            :class="hasActions ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'"
                        >
                            <div class="row col-sm-12">
                                <slot name="content" />
                            </div>
                        </div>

                        <div v-if="hasActions" class="flex items-center justify-end text-right">
                            <slot name="actions" />
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </Card>
</template>
