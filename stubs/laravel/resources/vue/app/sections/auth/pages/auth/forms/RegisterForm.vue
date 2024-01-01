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

        <div class="inputBox">

            <input 
                type="password" 
                required 
                v-model="password_confirmation"> 

            <i>Confirmar contraseña</i>

        </div>

        <div class="links"> 
            
            <p>¿Ya tienes cuenta?</p>
            
            <router-link :to="{ name: 'Login'}">
                
                Iniciar sesión
            
            </router-link>

        </div>

        <div class="inputBox">

            <input type="submit" value="Crear cuenta">

        </div>

    </form>

</template>

<script>

    export default {
        
        name: "RegisterForm",

        emits: ['submit'],

        data() {
            return {
                email: '',
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
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
            },
        },

    }

</script>