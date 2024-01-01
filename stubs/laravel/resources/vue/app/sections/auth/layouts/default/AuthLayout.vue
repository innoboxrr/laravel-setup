<template>
    
    <div class="auth-wrapper">

        <section class="main"> 
            
            <span v-for="x in 200"></span>

            <div class="auth">

                <div class="content">

                    <h2>
                        <router-link 
                            :to="{name: 'Home'}"
                            class="hover:no-underline hover:text-app-color">
                            <div class="flex mx-3">
                                <img src="@app/assets/images/logos/tec.png" class="w-40">
                            </div>
                        </router-link>
                    </h2>

                    <router-view></router-view>

                </div>

            </div>

        </section> <!-- partial -->

    </div>

</template>

<script>

    import './assets/auth.scss';

    export default {
        
        name: "AuthLayout",

        data() {
            return {
                
            }
        },

        mounted() {
            
        },
        
        methods: {
            
        },

    }

</script>
