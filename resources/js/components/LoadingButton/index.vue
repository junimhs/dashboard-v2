<template>
    <button :type="type" :disabled="loading"
            @click="$emit('click')"
            class="justify-center inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800"
            :class="{'w-full': widthFull}"
    >
        <component v-if="!!icon && !loading" :is="icon" class="-ml-1 mr-2 h-5 w-5"/>
        <div v-if="loading" class="btn-spinner mr-2"/>
        {{ title }}
    </button>
</template>

<script>
import { PlusIcon, MailIcon, KeyIcon, UserIcon, SearchIcon, CloseIcon, LockIcon, ArrowLeftIcon } from '../Icons'
export default {
    name: "LoadingButton",
    components: {
        PlusIcon,
        MailIcon,
        KeyIcon,
        UserIcon,
        SearchIcon,
        CloseIcon,
        LockIcon, ArrowLeftIcon
    },
    props: {
        loading: Boolean,
        title: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: false
        },
        type: {
            type: String,
            default: 'button'
        },
        widthFull: Boolean
    },
}
</script>

<style scoped>
</style>
