<template>
    
    <form class="form" @submit.prevent="onSubmit">

        <div class="inputBox">

            <input 
                type="text" 
                required 
                v-model="email"> 

            <input-error-component :errors="errors" type="email" />
            
            <i>Correo electrónico</i>

            <p class="mb-2">
                
                Te enviaremos un enlace para restablecer tu contraseña.

                Regresar

                <router-link :to="{ name: 'Login'}" class="text-app-color">
                
                    Iniciar sesión
                
                </router-link>

            </p>

        </div>

        <div class="inputBox">

            <input type="submit" value="Enviar enlace">

        </div>

    </form>

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