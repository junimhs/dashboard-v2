<template>
    <base-layout>
        <div class="bg-gray-800 pb-32">
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-row justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">
                        Gerenciar {{ user.name }}
                    </h1>
                    <inertia-button icon="ArrowLeftIcon" title="Voltar" :href="route('admin.users.index')"/>
                </div>
            </header>
        </div>
        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-4 lg:gap-8">
                    <div v-if="isProfile" class="bg-white rounded-md shadow py-4 sm:px-6 mt-4 lg:col-span-3">
                        <div class="bg-white pb-4 border-b border-gray-200">
                            <h3 class="2xl:text-sm leading-6 font-bold text-gray-600">
                                Detalhes da conta
                            </h3>
                            <p class="mt-1 text-sm text-gray-400">
                                Gestao das informacoes basicas.
                            </p>
                        </div>
                        <form @submit.stop.prevent="editUser" class="pt-4">
                            <text-input label="Nome" placeholder="Nome do usuario" name="name" icon="UserIcon"
                                        v-model:content="form.name" :error="form.errors.name"/>
                            <text-input label="E-mail" placeholder="E-mail do usuario" name="email" icon="MailIcon"
                                        v-model:content="form.email" class="mt-4" :error="form.errors.email"/>
                            <text-input label="Senha" type="password" placeholder="Senha do usuario" name="password"
                                        icon="LockIcon" v-model:content="form.password" class="mt-4"
                                        :error="form.errors.password"/>
                            <text-input label="Confirmacao de senha" type="password"
                                        placeholder="Confirmacao da senha do usuario" name="password_confirmation"
                                        icon="LockIcon" v-model:content="form.password_confirmation" class="mt-4"/>
                            <div class="py-4 flex justify-end">
                                <loading-button title="Editar" icon="PlusIcon" type="submit"
                                                :loading="form.processing"/>
                            </div>
                        </form>
                    </div>

                    <div v-if="isManage" class="bg-white rounded-md shadow py-4 sm:px-6 mt-4 lg:col-span-3">
                        <div class="">
                            <h3 class="2xl:text-sm leading-6 font-bold text-gray-600">
                                {{ user.deleted_at ? 'Restaurar conta' : 'Excluir conta' }}
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Voce tem certeza que deseja {{ user.deleted_at ? 'restaurar' : 'excluir' }} a conta
                                    do usuario?
                                </p>
                            </div>
                            <div class="mt-5">
                                <button @click="previewDelete" type="button"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:text-sm">
                                    {{ user.deleted_at ? 'Restaurar conta' : 'Excluir conta' }}
                                </button>

                            </div>
                            <transition name="fade">
                                <div v-if="isDelete" class="bg-gray-50 shadow sm:rounded-md mt-4">
                                    <div class="px-3 py-3 sm:p-4">
                                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                                            <p>
                                                Informe o codigo <b>{{ isSecret }}</b> para continuar.
                                            </p>
                                        </div>
                                        <form class="mt-2 sm:flex sm:items-center" @submit.stop.prevent="deleteUser">
                                            <div class="w-full sm:max-w-xs">
                                                <text-input placeholder="Informe o codigo acima" icon="LockIcon"
                                                            name="secret" v-model="secret" :error="isErrorSecret"/>
                                            </div>
                                            <loading-button class="ml-3 mt-1" :class="{'-mt-6': !!isErrorSecret}"
                                                            title="Salvar" type="submit" :loading="loading"/>
                                        </form>
                                    </div>
                                </div>
                            </transition>

                        </div>
                    </div>

                    <div v-if="isDevices" class="bg-white rounded-md shadow py-4 sm:px-6 mt-4 lg:col-span-3">
                        <div class="bg-white pb-4 border-b border-gray-200">
                            <h3 class="2xl:text-sm leading-6 font-bold text-gray-600">
                                Dispositivos conectados a sua conta.
                            </h3>
                            <p class="mt-1 text-sm text-gray-400">
                                Gestao de todos os dispositivos conectados.
                            </p>
                        </div>
                        <!-- Table -->
                        <div class="flex flex-col pt-4">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Device
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    IP
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Ultima atividade
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Device atual
                                                </th>
                                                <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Desconectar</span>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Odd row -->
                                            <tr v-for="device in devices" :key="device.id" class="bg-white">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ device.agent.browser }} / {{ device.agent.platform }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ device.ip_address }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ device.last_active }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                            :class="{'bg-green-100 text-green-800': device.is_current_device === 'Sim', 'bg-red-100 text-red-800': device.is_current_device === 'Nao'}">
                                                          {{ device.is_current_device }}
                                                        </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <button type="button" @click="openModal(device.id)"
                                                            class="text-indigo-600 hover:text-indigo-900">Desconectar
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right -->
                    <div class="grid grid-cols-1 gap-4 py-4">
                        <section aria-labelledby="section-2-title">
                            <h2 class="sr-only" id="section-2-title">Section title</h2>
                            <div class="rounded-md bg-white overflow-hidden shadow">
                                <div class="pt-6 flex flex-col items-center">
                                    <div class="pb-4 w-1/2 flex justify-center items-center">
                                        <img class="border-gray-200 border-4 rounded-full w-full"
                                             :src="`https://ui-avatars.com/api/?font-size=0.33&background=7159c1&color=fff&name=${user.name}`"
                                             alt="">
                                    </div>
                                    <div class="border-t border-gray-200 w-full">
                                        <button @click.prevent="openProfile"
                                                class="w-full text-left px-4 py-4 text-sm hover:bg-gray-800 hover:text-white"
                                                :class="{'bg-gray-800 text-white': isProfile}">
                                            Perfil do usuario
                                        </button>
                                        <button @click.prevent="openManage"
                                                class="w-full text-left px-4 py-4 text-sm hover:bg-gray-800 hover:text-white"
                                                :class="{'bg-gray-800 text-white': isManage}">
                                            Gerenciar
                                        </button>
                                        <button @click.prevent="openDevice"
                                                class="w-full text-left px-4 py-4 text-sm hover:bg-gray-800 hover:text-white"
                                                :class="{'bg-gray-800 text-white': isDevices}">
                                            Devices
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Replace with your content -->
                <modal
                    :is-view="modalView"
                    title="Deseja desconectar dispositivo"
                    message="Ao excluir o dispositivo automaticamente ira deslogar no dispositivo desconectado!"
                    button="Desconectar"
                    @onCancel="closeModal"
                    @onSuccess="destroyDevice"
                />
            </div>
        </main>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/base-layout";
import InertiaButton from "../../components/InertiaButton";
import LoadingButton from "../../components/LoadingButton";
import TextInput from "../../components/TextInput";
import Modal from "../../components/Modal";

export default {
    name: "Profile.edit",
    props: {
        user: Object,
        devices: Object | Array
    },
    components: {Modal, TextInput, LoadingButton, BaseLayout, InertiaButton},
    data() {
        return {
            form: this.$inertia.form({
                name: this.user.name,
                email: this.user.email,
                password: '',
                password_confirmation: ''
            }),
            secret: '',
            isDelete: false,
            isView: 'profile',
            isErrorSecret: '',
            loading: false,
            modalView: false,
            idDevice: ''
        }
    },
    computed: {
        isProfile() {
            return this.isView === 'profile';
        },
        isManage() {
            return this.isView === 'manage';
        },
        isSecret() {
            return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 5);
        },
        isDevices() {
            return this.isView === 'devices';
        },
    },
    methods: {
        editUser() {
            this.form.put(this.route('admin.users.update', {'id': this.user.id}));
        },
        previewDelete() {
            this.isDelete = !this.isDelete
        },
        openProfile() {
            this.isDelete = false;
            this.isView = 'profile'
        },
        openManage() {
            this.isDelete = false;
            this.isView = 'manage'
        },
        openDevice() {
            this.isDelete = false;
            this.isView = 'devices'
        },
        openModal(idDevice) {
            this.modalView = true;
            this.idDevice = idDevice
        },
        deleteUser() {
            if (this.secret !== this.isSecret) {
                this.isErrorSecret = 'Informe o codigo valido!'
                return;
            }

            this.$inertia.delete(this.route('admin.users.destroy', {'id': this.user.id}), {
                onStart: () => {
                    this.loading = true;
                },
                onFinish: () => {
                    this.loading = false;
                }
            });
        },
        destroyDevice() {
            this.$inertia.delete(route('admin.device.destroy', {id: this.idDevice}))
        },
        closeModal() {
            this.modalView = false;
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}
</style>
