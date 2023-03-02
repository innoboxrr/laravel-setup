<template>
    
    <div class="wrapper">

        <the-header />
        
        <div uk-height-viewport="min-height: 300">
            
            <router-view></router-view>

        </div>
        
        <the-footer />
        
        <the-offcanvas />
        
    </div>

</template>

<script>
    
    import TheHeader from '@layouts/site/TheHeader.vue'
    import TheFooter from '@layouts/site/TheFooter.vue'
    import TheOffcanvas from '@layouts/site/TheOffcanvas.vue'

    export default {

        components: {

            TheHeader,

            TheFooter,

            TheOffcanvas,

        }

    }

</script>