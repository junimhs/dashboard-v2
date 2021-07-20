<template>
    <base-layout>
        <div class="bg-gray-800 pb-32">
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-white">
                        Dashboard
                    </h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div>
                    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                            <dt>
                                <div class="absolute bg-indigo-500 rounded-md p-3">
                                    <!-- Heroicon name: outline/users -->
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Total de usuarios</p>
                            </dt>
                            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ countUsers }}
                                </p>
                                <div class="absolute bottom-0 inset-x-0 bg-gray-100 px-4 py-4 sm:px-6">
                                    <div class="text-sm">
                                        <inertia-link :href="route('admin.users.index')" class="font-medium text-indigo-600 hover:text-indigo-500"> Ver usuarios<span class="sr-only"> Total de usuario</span></inertia-link>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </main>
    </base-layout>
</template>

<script>
import BaseLayout from "../layouts/base-layout";

export default {
    name: 'Home',
    components: {BaseLayout},
    props: {
        countUsers: Number,
    },
}
</script>

<style scoped>

</style>
