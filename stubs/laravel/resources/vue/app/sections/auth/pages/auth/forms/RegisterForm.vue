<template>
    <div>
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <router-link
                    :to="{ name: 'Home' }"
                    class="flex items-center justify-center">
                    <img
                        class="h-10 w-auto"
                        :src="option('login.icon', 'https://placehold.co/340x80')"
                        :alt="appName" />
                </router-link>
                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    {{ __('Create your account') }}
                </h2>
                <p class="mt-2 text-sm leading-6 text-gray-500">
                    {{ __('Already a member?') }}
                    {{ ' ' }}
                    <router-link
                        :to="{ name: 'Login' }"
                        class="font-semibold text-indigo-600 hover:text-indigo-500">
                        {{ __('Sign in here') }}
                    </router-link>
                </p>
            </div>

            <div class="mt-10">
                <div>
                    <form class="space-y-6" @submit.prevent="onSubmit">

                        <div>
                            <label for="name" class="block text-sm font-medium leading-3 text-gray-900">
                                {{ __('Name') }}
                            </label>
                            <div class="mt-2">
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    autocomplete="email"
                                    required=""
                                    v-model="name"
                                    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>
                        <input-error-component :errors="errors" type="name" />

                        <div>
                            <label for="surname" class="block text-sm font-medium leading-3 text-gray-900">
                                {{ __('Surname') }}
                            </label>
                            <div class="mt-2">
                                <input
                                    id="surname"
                                    name="surname"
                                    type="text"
                                    autocomplete="email"
                                    required=""
                                    v-model="surname"
                                    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>
                        <input-error-component :errors="errors" type="surname" />

                        <div>
                            <label for="email" class="block text-sm font-medium leading-3 text-gray-900">
                                {{ __('Email address') }}
                            </label>
                            <div class="mt-2">
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    required=""
                                    v-model="email"
                                    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>
                        <input-error-component :errors="errors" type="email" />

                        <div>
                            <label for="password" class="block text-sm font-medium leading-3 text-gray-900">
                                {{ __('Password') }}
                            </label>
                            <div class="mt-2">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required=""
                                    v-model="password"
                                    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>
                        <input-error-component :errors="errors" type="password" />

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium leading-3 text-gray-900">
                                {{ __('Confirm password') }}
                            </label>
                            <div class="mt-2">
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="current-password"
                                    required=""
                                    v-model="password_confirmation"
                                    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input
                                    id="remember-me"
                                    name="remember-me"
                                    type="checkbox"
                                    v-model="remember"
                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            <div class="text-sm leading-6">
                                <router-link
                                    :to="{
                                        name: 'ForgotPassword',
                                    }"
                                    class="font-semibold text-indigo-600 hover:text-indigo-500">
                                    {{ __('Forgot your password?') }}
                                </router-link>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </form>
                </div>
                <social-auth-links type="register" />
            </div>
        </div>
    </div>
</template>

<script>
    import SocialAuthLinks from "./../components/SocialAuthLinks.vue";
    export default {

        name: "RegisterForm",

        components: {
            SocialAuthLinks,
        },

        emits: ['submit'],

        data() {
            return {
                name: '',
                surname: '',
                email: '',
                password: '',
                password_confirmation: '',
                remember: false,
            }
        },

        computed: {
            errors() {
                return this.$store.getters['authPages/formErrors'] || {};
            },
        },

        methods: {
            onSubmit() {
                this.$emit('submit', {
                    _token: csrf_token,
                    name: this.name,
                    surname: this.surname,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    remember: this.remember,
                    redirect: this.$route.query.redirect,
                })
            },
        },

    }

</script>
