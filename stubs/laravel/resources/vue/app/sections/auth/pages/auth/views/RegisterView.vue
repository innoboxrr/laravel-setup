<template>

	<register-form
        @submit="register"/>

</template>

<script>

    import RegisterForm from '../forms/RegisterForm.vue';

    export default {

        name: "RegisterView",

        components: {
            RegisterForm,
        },

        methods: {
            register(data) {
                this.$store.dispatch('authPages/register', data);
            }
        },

    }

</script>
