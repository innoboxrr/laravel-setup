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
                    {{ __('We will send you an email to reset your password.') }} <br />
                    {{ __('Go to') }}
                    <router-link
                        :to="{ name: 'Login' }"
                        class="font-semibold text-indigo-600 hover:text-indigo-500">
                        {{ __('Sign in') }}
                    </router-link>
                </p>
            </div>
            <div class="mt-6">
                <div>
                    <form class="space-y-6" @submit.prevent="onSubmit">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
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
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ __('Request reset link') }}
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

        name: "ForgotPasswordForm",

        emits: ['submit'],

        data() {
            return {
                email: '',
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
                    email: this.email,
                })
            },
        },

    }

</script>
