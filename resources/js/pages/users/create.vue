<template>
    <base-layout>
        <div class="bg-gray-800 pb-32">
            <header class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-row justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">
                        Cadastro de usuario
                    </h1>
                    <inertia-button icon="ArrowLeftIcon" title="Voltar" :href="route('admin.users.index')"/>
                </div>
            </header>
        </div>
        <main class="-mt-32">
            <div class="max-w-7xl mx-auto pb-12 px-4 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="bg-white rounded-lg shadow px-4 py-4 sm:px-6">
                    <form @submit.stop.prevent="registerUser">
                        <text-input label="Nome" placeholder="Nome do usuario" name="name" icon="UserIcon" v-model="form.name" :error="form.errors.name"/>
                        <text-input label="E-mail" placeholder="E-mail do usuario" name="email" icon="MailIcon" v-model="form.email" class="mt-4" :error="form.errors.email"/>
                        <text-input label="Senha" type="password" placeholder="Senha do usuario" name="password" icon="LockIcon" v-model="form.password" class="mt-4" :error="form.errors.password"/>
                        <text-input label="Confirmacao de senha" type="password" placeholder="Confirmacao da senha do usuario" name="password_confirmation" icon="LockIcon" v-model="form.password_confirmation" class="mt-4"/>
                        <div class="py-4 flex justify-end">
                            <loading-button title="Cadastrar" icon="PlusIcon" type="submit" :loading="form.processing"/>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </base-layout>
</template>

<script>
import BaseLayout from "../../layouts/base-layout";
import InertiaButton from "../../components/InertiaButton";
import LoadingButton from "../../components/LoadingButton";
import TextInput from "../../components/TextInput";
export default {
    name: "Users.create",
    components: {TextInput, LoadingButton, BaseLayout, InertiaButton},
    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }
    },
    methods: {
        registerUser(){
            this.form.post(this.route('admin.users.store'));
        }
    }
}
</script>

<style scoped>

</style>
