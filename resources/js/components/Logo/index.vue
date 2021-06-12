<template>
    <svg :width="size" :height="size" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 1V13.5M2 26V13.5M2 13.5H13" :stroke="color" stroke-width="3.5"/>
        <path d="M12 2L24 13.5L12 25" :stroke="color" stroke-width="3.5"/>
    </svg>
</template>

<script>
export default {
    name: 'Logo',
    props: {
        size: {
            type: [String, Number],
            default: 27
        },
        color: {
            type: String,
            default: "#333646"
        }
    }
}
</script>

<style scoped>

</style>
