<template>

	<reset-password-form
        :token="$route.params.token"
        :email="$route.params.email"
        @submit="resetPassword"/>

</template>

<script>

    import  ResetPasswordForm from '../forms/ResetPasswordForm.vue';

    export default {

        name: "ResetPasswordView",

        components: {
            ResetPasswordForm,
        },

        methods: {
            resetPassword(data) {
                this.$store.dispatch('authPages/resetPassword', data);
            }
        },

    }

</script>
