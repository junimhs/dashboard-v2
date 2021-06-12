<template>
    <inertia-link :href="href" type="button"
                  class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <component :is="icon" class="-ml-1 mr-2 h-5 w-5"/>
        {{ title }}
    </inertia-link>
</template>

<script>
import PlusIcon from "../Icons/plus";
import ArrowLeftIcon from "../Icons/arrow-left"

export default {
    name: "InertiaButton",
    components: {
        PlusIcon,
        ArrowLeftIcon
    },
    props: {
        href: {
            type: String,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        }
    },
}
</script>

<style scoped>

</style>
