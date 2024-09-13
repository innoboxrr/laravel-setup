<template>

	<forgot-password-form
        @submit="forgotPassword"/>

</template>

<script>

    import  ForgotPasswordForm from '../forms/ForgotPasswordForm.vue';

    export default {

        name: "ForgotPasswordView",

        components: {
            ForgotPasswordForm,
        },

        methods: {
            async forgotPassword(data) {
                await this.$store.dispatch('authPages/forgotPassword', data);
                this.alert('success');
            }
        },

    }

</script>
