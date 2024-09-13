<template>
    <div class="flex h-full">
        <div class="flex flex-1 flex-col overflow-hidden">
            <header-component />
            <div class="flex flex-1 items-stretch overflow-hidden">
                <main class="flex-1 lg:overflow-y-auto lg:h-screen lg:pb-24 hide-scrollbar">
                    <breadcrumb-component />
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <gallery-component />
                    </div>
                </main>
                <aside class="hidden w-96 overflow-y-auto border-l border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 p-8 pb-24 lg:block lg:overflow-y-auto lg:h-screen hide-scrollbar">
                    <aside-component 
                        v-if="!$store.state.fileManagerStore.asideMobilePanelOpen" />
                </aside>
                <aside-mobile-component />
            </div>
        </div>
        <create-directory-modal />
        <upload-files-modal />
    </div>
</template>

<script>

    import { defineAsyncComponent } from 'vue'
    import { debounce } from 'innoboxrr-js-libs/libs/utils.js'

    export default {
        components: {
            HeaderComponent: defineAsyncComponent(() => import('./partials/HeaderComponent.vue')),
            BreadcrumbComponent: defineAsyncComponent(() => import('./partials/BreadcrumbComponent.vue')),
            GalleryComponent: defineAsyncComponent(() => import('./partials/GalleryComponent.vue')),
            AsideComponent: defineAsyncComponent(() => import('./partials/AsideComponent.vue')),
            AsideMobileComponent: defineAsyncComponent(() => import('./partials/AsideMobileComponent.vue')),
            CreateDirectoryModal: defineAsyncComponent(() => import('./modals/CreateDirectoryModal.vue')),
            UploadFilesModal: defineAsyncComponent(() => import('./modals/UploadFilesModal.vue')),
        },
        data() {
            return {
                debouncedResize: null
            }
        },
        mounted() {
            this.preventOverflow();
            // Close the sidebar on window resize only if the width changes significantly
            this.$nextTick(() => {
                this.debouncedResize = debounce(() => {
                    const currentWidth = window.innerWidth;
                    if (currentWidth >= 1280) {
                        this.isSidebarOpen = false;
                    }
                    this.preventOverflow();
                }, 100);
                window.addEventListener('resize', this.debouncedResize);
            });
            this.$store.dispatch('fileManagerStore/initFileManager');
        },
        beforeUnmount() {
            // Remove the resize event listener
            window.removeEventListener('resize', this.debouncedResize);
            document.documentElement.style.overflow = 'auto';
        },
        methods: {
            preventOverflow() {
                // Mover el scroll al inicio 
                window.scrollTo(0, 0);
                // Add overflow hidden al html solo cuando min-width: 1280px
                // Esto es necesario para evitar que el contenido se desborde en pantallas grandes
                // y se muestre la barra de desplazamiento
                if(window.innerWidth >= 1280) {
                    document.documentElement.style.overflow = 'hidden';
                } else {
                    document.documentElement.style.overflow = 'auto';
                }
            }
        }
    }

</script>