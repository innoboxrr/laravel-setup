<template>
	
	<login-form 
        @submit="login"/>

</template>

<script>

	import LoginForm from '../forms/LoginForm.vue';

    export default {
        
        name: "LoginView",

		components: {
			LoginForm,
		},		

        data() {
            return {
                
            }
        },

        mounted() {
            
        },
        
        methods: {
            login(data) {
                this.$store.dispatch('authPages/login', data);
            }
        },

    }

</script>