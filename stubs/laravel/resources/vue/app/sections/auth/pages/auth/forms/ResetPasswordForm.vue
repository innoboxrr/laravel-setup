<template>
    
    <form class="form" @submit.prevent="onSubmit">

        <div class="inputBox">

            <input 
                type="password" 
                required 
                v-model="password"> 
            
            <i>Nueva contraseña</i>

        </div>

        <input-error-component :errors="errors" type="password" />

        <div class="inputBox">

            <input 
                type="password" 
                required 
                v-model="password_confirmation"> 

            <i>Confirmar contraseña</i>

        </div>

        <div class="inputBox">

            <input type="submit" value="Entrar">

        </div>

    </form>

</template>

<script>

    export default {
        
        name: "LoginForm",

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