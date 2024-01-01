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

        data() {
            return {
                
            }
        },

        mounted() {
            
        },
        
        methods: {
            resetPassword(data) {
                this.$store.dispatch('authPages/resetPassword', data);
            }
        },

    }

</script>