<template>
    <div>
        <header-section />
        <div class="container mx-auto p-4">
            <div class="flex flex-wrap mx-2">
                <div class="w-full lg:w-8/12 px-2 mb-4">
                    <certificate-preview 
                        :key="this.$route.params.certificate_id"
                        :certificate-id="this.$route.params.certificate_id"
                        :loadMetadata="true"/>
                </div>
                <div class="w-full lg:w-4/12 px-2 mb-4">
                    <user-certificates />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineAsyncComponent } from 'vue';

    export default {
        components: {
            HeaderSection: defineAsyncComponent(() => import('./../partials/HeaderSection.vue')),
            CertificatePreview: defineAsyncComponent(() => import('@models/certificate/widgets/CertificatePreview.vue')),
            UserCertificates: defineAsyncComponent(() => import('./../partials/UserCertificates.vue')),
            AwesomeSocialButton: defineAsyncComponent(() => import('awesome-social-button').then(m => m.AwesomeSocialButton)),
        },
    }
</script>