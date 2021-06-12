<template>
    <div>
        <label v-if="!!label" :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <component :is="icon" class="h-5 w-5 text-gray-400" :class="{ 'text-red-300': !!error }"/>
            </div>
            <input :type="type" :name="name" :id="id"
                   class="focus:ring-gray-800 focus:border-gray-800 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': !!error}"
                   :placeholder="placeholder" :value="value" @input="$emit('input', $event.target.value)">
        </div>
        <p v-if="!!error" class="mt-2 text-sm text-red-600" id="password-error">{{ error }}</p>
    </div>
</template>

<script>
import PlusIcon from '../Icons/plus'
import MailIcon from '../Icons/mail'
import KeyIcon from '../Icons/key'
import UserIcon from '../Icons/user'
import LockIcon from '../Icons/lock'
export default {
    name: "TextInput",
    components: {
        PlusIcon,
        MailIcon,
        KeyIcon,
        UserIcon,
        LockIcon
    },
    emits: ['update:content'],
    props: {
        label: {
            type: String,
            required: false
        },
        id: {
            type: String,
            default() {
                return `text-input-${Math.random().toString()}`
            }
        },
        type: {
            type: String,
            default: 'text'
        },
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true
        },
        value: String,
        error: String
    },
}
</script>

<style scoped>

</style>
