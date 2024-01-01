<template>
    
    <form class="form" @submit.prevent="onSubmit">

        <div class="inputBox">

            <input 
                type="text" 
                required 
                v-model="email"> 
            
            <i>Correo electrónico</i>

        </div>

        <input-error-component :errors="errors" type="email" />

        <div class="inputBox">

            <input 
                type="password" 
                required 
                v-model="password"> 
            
            <i>Contraseña</i>

        </div>

        <input-error-component :errors="errors" type="password" />

        <div class="links"> 
            
            <router-link :to="{ name: 'ForgotPassword'}">
                
                ¿Olvidaste tu contraseña?
            
            </router-link>
            
            <router-link :to="{ name: 'Register'}">
                
                Registro
            
            </router-link>

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

        data() {
            return {
                email: '',
                password: '',
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
                    password: this.password,
                })
            },
        },

    }

</script>