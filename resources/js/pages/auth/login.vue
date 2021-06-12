<template>
    <div class="min-h-screen bg-gray-800 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <logo class="mx-auto h-20 w-auto" color="#FFF"/>
        </div>
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form class="space-y-6 mt-2" @submit.prevent="handleLogin">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" v-model="form.email"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-gray-800 focus:border-gray-800 sm:text-sm"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': !!form.errors.email}"
                            />
                        </div>
                        <p v-if="form.errors.email" class="mt-2 text-sm text-red-600" id="email-error">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" autocomplete="current-password"
                                   v-model="form.password"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-gray-800 focus:border-gray-800  sm:text-sm"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500': !!form.errors.password}"
                            />
                        </div>
                        <p v-if="form.errors.password" class="mt-2 text-sm text-red-600" id="password-error">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center justify-end">
                        <div class="text-sm">
                            <inertia-link :href="route('forgot-password')" class="font-medium text-grayDark-900 hover:text-grayDark-800">
                                Esqueceu sua senha?
                            </inertia-link>
                        </div>
                    </div>

                    <div>
                        <loading-button width-full type="submit" :loading="form.processing" title="Acessar"/>
                    </div>
                </form>
            </div>
        </div>
        <notification :toast="$page.props.flash"/>
    </div>
</template>

<script>
import Logo from "../../components/Logo";
import LoadingButton from '../../components/LoadingButton'
import Notification from "../../components/Notification";

export default {
    name: 'Auth.Login',
    components: {Notification, Logo, LoadingButton},
    data() {
        return {
            form: this.$inertia.form({
                email: null,
                password: null
            })
        }
    },
    methods: {
        handleLogin() {
            this.form.post(this.route('login'))
        }
    }
}
</script>

<style scoped>

</style>
