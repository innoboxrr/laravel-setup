<template>
    
    <div class="wrapper">

        <the-header />
        
        <div uk-height-viewport="expand: true">
            
            <router-view></router-view>

        </div>
        
        <the-footer />
        
    </div>

</template>

<script>
    
    import TheHeader from './TheHeader.vue'
    import TheFooter from './TheFooter.vue'

    export default {

        components: {

            TheHeader,

            TheFooter,

        }

    }

</script>