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
                    {{ __('Reset your account') }}
                </h2>
                <p class="mt-2 text-sm leading-6 text-gray-500">
                    {{ __('Enter your new password and confirm it.') }}
                </p>
            </div>

            <div class="mt-10">
                <div>
                    <form class="space-y-6" @submit.prevent="onSubmit">

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
                                {{ __('Confirm Password') }}
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

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        name: "DirectResetPasswordForm",

        emits: ['submit'],

        props: {
            token: {
                type: String,
                required: true,
            },
            email: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
                password: '',
                password_confirmation: '',
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
                    token: this.token,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
            },
        },

    }

</script>
