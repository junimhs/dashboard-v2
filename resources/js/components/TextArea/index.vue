<template>
    <div>
        <label v-if="!!label" :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <div class="mt-1 rounded-md shadow-sm">
            <textarea :name="name" :id="id"
                      class="focus:ring-gray-800 focus:border-gray-800 block w-full pl-4 h-24 sm:text-sm border-gray-300 rounded-md"
                      :class="{'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': !!error}"
                      :placeholder="placeholder" :value="value" @input="$emit('input', $event.target.value)"></textarea>
        </div>
        <p v-if="!!error" class="mt-2 text-sm text-red-600" id="password-error">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: "TextArea",
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
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: true
        },
        value: String,
        error: String,
    },
}
</script>

<style scoped>
</style>
