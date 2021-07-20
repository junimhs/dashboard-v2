<template>
    <div class="bg-white overflow-hidden sm:rounded-md">
        <div v-if="isEmptyData">
            <ul class="divide-y divide-gray-200">
                <slot />
            </ul>
            <pagination :data="datas"/>
        </div>
        <div v-else class="flex justify-center items-center pb-4">
            <span class="text-gray-400 text-sm">Nenhum dado cadastrado...</span>
        </div>
    </div>
</template>

<script>
import Pagination from "../Pagination";
export default {
    name: "ListView",
    components: {Pagination},
    props: {
        datas: {
            type: Array | Object,
            required: true
        },
    },
    computed: {
        isEmptyData() {
            return this.datas.data.length > 0;
        },
    }
}
</script>

<style scoped>

</style>
