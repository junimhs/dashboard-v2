<template>
    <inertia-link :href="href" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
        <slot />
    </inertia-link>
</template>

<script>
export default {
    name: "MenuItem",
    props: {
        href: {
            type: String,
            required: true
        },
    },
}
</script>

<style scoped>

</style>
