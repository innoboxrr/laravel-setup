<template>

	<div id="adminAppWrapper">

        <main uk-grid>
            
            <div class="uk-width-auto sidebar">
                
                <sidebar-nav class="uk-visible@m" @select="setNav"/>

                <offcanvas-nav :nav-option="navOption"/>

            </div>

            <div 
                class="uk-width-expand uk-padding-remove-horizontal uk-section-muted main-container" 
                uk-height-viewport="offset-top: true">

                <top-nav />

                <router-view></router-view>

            </div>

        </main>

	</div>

</template>

<script>

    import TopNav from '@layouts/admin/TopNav.vue'
    import SidebarNav from '@layouts/admin/SidebarNav.vue'  
    import OffcanvasNav from '@layouts/admin/OffcanvasNav.vue'
    
	export default {

        components: {

            TopNav,
            
            SidebarNav,
            
            OffcanvasNav
            
        },

        data() {

            return {

                navOption: '',

            }

        },

        methods: {

            setNav(option) {

                this.navOption = option;

            }

        }

	}

</script>

<style scoped>

    @media(min-width: 960px) {

        .main-container {
            margin-left: 60px;
        }

    }

</style>