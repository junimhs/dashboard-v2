<template>
    <div class="min-h-screen bg-gray-800 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <logo class="mx-auto h-20 w-auto" color="#FFF"/>
            <h2 class="mt-6 text-center text-2xl font-extrabold text-white">
                Recuperar sua senha
            </h2>
        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6 mt-2" @submit.prevent="handleForgot">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" v-model="form.email"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-gray-800 focus:border-gray-800 sm:text-sm"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': !!form.errors.email || $page.props.flash.message}"
                            />
                        </div>
                        <p v-if="form.errors.email || $page.props.flash.message" class="mt-2 text-sm text-red-600" id="email-error">
                            {{ form.errors.email || $page.props.flash.message }}</p>
                    </div>

                    <div>
                        <loading-button width-full type="submit" :loading="form.processing" title="Enviar"/>
                    </div>
                </form>
                <div class="flex justify-center items-center mt-4">
                    <inertia-link :href="route('login')" class="px-2 bg-white text-gray-500">
                              Voltar a tela de login
                    </inertia-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Logo from "../../components/Logo";
import LoadingButton from '../../components/LoadingButton'

export default {
    name: "forgot-password",
    components: {
        Logo,
        LoadingButton
    },
    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },
    methods: {
        handleForgot() {
            this.form.post(this.route('forgot-password-recover'));
        }
    }
}
</script>

<style scoped>

</style>
