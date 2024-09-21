<template>

	<direct-reset-password-form
        :token="$route.params.token"
        :email="$route.params.email"
        @submit="directResetPassword"/>

</template>

<script>

    import  DirectResetPasswordForm from '../forms/DirectResetPasswordForm.vue';

    export default {

        name: "DirectResetPasswordView",

        components: {
            DirectResetPasswordForm,
        },

        methods: {
            directResetPassword(data) {
                this.$store.dispatch('authPages/directResetPassword', data);
            }
        },

    }

</script>
