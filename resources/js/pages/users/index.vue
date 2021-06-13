<template>
    <base-layout>
        <div class="bg-gray-800 pb-32">
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-row justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">
                        Usuarios
                    </h1>
                    <inertia-button icon="PlusIcon" title="Cadastrar usuario" :href="route('admin.users.create')"/>
                </div>
            </header>
        </div>
        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="bg-white rounded-lg shadow px-4 py-2 sm:px-6">
                    <div class="border-b border-gray-200 py-3 flex justify-between">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Filtrar usuarios
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Preencha os campos abaixo para filtragem de usuarios
                            </p>
                        </div>
                        <div class="flex items-center">
                            <!-- Enabled: "bg-indigo-600", Not Enabled: "bg-gray-200" -->
                            <button @click="showTrashed" type="button"
                                    class="bg-gray-200 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :class="{'bg-indigo-600': isTrashed}"
                                    role="switch" aria-checked="false" aria-labelledby="annual-billing-label">
                                <span class="sr-only">Use setting</span>
                                <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
                                <span aria-hidden="true"
                                      class="translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                                      :class="{'translate-x-5': isTrashed}"
                                ></span>
                            </button>
                            <span class="ml-3" id="annual-billing-label">
                                <span class="text-sm font-medium text-gray-900">{{ isTrashed ? 'Usuarios excluidos' : 'Usuarios ativos' }}</span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex flex-col">
                            <div class="grid grid-cols-4 gap-4">
                                <text-input
                                    label="Id"
                                    name="id"
                                    placeholder="Id"
                                    icon="KeyIcon"
                                    v-model="params.id"
                                />
                            </div>
                            <div class="mt-4 grid grid-cols-2 gap-4">
                                <text-input
                                    label="Nome"
                                    name="name"
                                    placeholder="Nome"
                                    icon="UserIcon"
                                    v-model="params.name"

                                />
                                <text-input
                                    label="E-mail"
                                    name="email"
                                    type="email"
                                    placeholder="E-mail"
                                    icon="MailIcon"
                                    v-model="params.email"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="py-4 flex justify-end">
                        <loading-button title="Filtrar usuario" type="button" icon="SearchIcon" @click="filterUser"
                                        :loading="loading"/>

                        <loading-button class="ml-2" title="Resetar filtro" icon="CloseIcon" @click="resetFilter"
                                        v-if="isFilter"/>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow px-5 py-6 sm:px-6 mt-4">
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <ul class="divide-y divide-gray-200">
                            <li v-for="user in users.data" :key="user.id">
                                <inertia-link :href="route('admin.users.edit', {'id': user.id})"
                                              class="block hover:bg-gray-50">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-12 w-12 rounded-full"
                                                     :src="`https://ui-avatars.com/api/?font-size=0.33&background=7159c1&color=fff&name=${user.name}`"
                                                     alt="">
                                            </div>
                                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                <div>
                                                    <p class="text-sm font-medium text-indigo-600 truncate">{{
                                                            user.name
                                                        }}</p>
                                                    <p class="mt-2 flex items-center text-sm text-gray-500">
                                                        <!-- Heroicon name: solid/mail -->
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                             fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                            <path
                                                                d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                        </svg>
                                                        <span class="truncate">{{ user.email }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <!-- Heroicon name: solid/chevron-right -->
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </inertia-link>
                            </li>
                        </ul>
                        <pagination :data="users"/>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/base-layout";
import InertiaButton from "../../components/InertiaButton";
import TextInput from "../../components/TextInput";
import LoadingButton from "../../components/LoadingButton";
import Pagination from "../../components/Pagination";

export default {
    name: 'User.index',
    components: {Pagination, LoadingButton, TextInput, InertiaButton, BaseLayout},
    props: {
        users: Object,
        filters: Object | Array
    },
    data() {
        return {
            params: {
                id: this.filters.id,
                name: this.filters.name,
                email: this.filters.email,
                trashed: this.filters.trashed
            },
            filterView: this.isFilter,
            loading: false,
        }
    },
    methods: {
        filterUser() {
            this.$inertia.get(this.route('admin.users.index'), this.params, {
                replace: true,
                preserveState: true,
                preserveScroll: true,
                onStart: () => {
                    this.loading = true
                },
                onFinish: () => {
                    this.loading = false
                },
            });
        },
        resetFilter() {
            this.params.id = null;
            this.params.name = null;
            this.params.email = null;

            this.filterUser();
        },
        showTrashed() {
            this.params.trashed = this.params.trashed == 'true' ? 'false' : 'true';
            this.$inertia.get(this.route('admin.users.index'), this.params, {
                replace: true,
                preserveState: true,
                preserveScroll: true,
            });
        }
    },
    computed: {
        isFilter() {
            return this.params.email || this.params.id || this.params.name;
        },
        isTrashed() {
            return this.params.trashed == 'true' ? true : false
        }
    }
}
</script>

<style scoped>

</style>
