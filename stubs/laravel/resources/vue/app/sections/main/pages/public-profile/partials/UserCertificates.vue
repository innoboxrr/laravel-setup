<template>
    <div v-if="(user && !isHeadTeacher) || (isHeadTeacher && certificates.length > 0)">
        <h3 class="text-lg font-bold dark:text-white mb-4">
            My <span class="text-blue-500">certificates</span>
        </h3>
        <ul role="list" class="mx-auto mt-4 grid max-w-2xl grid-cols-1 gap-y-4">
            <li 
                v-for="certificate in certificates" 
                :key="certificate.id"
                class="bg-slate-100 dark:bg-slate-800 rounded-lg">
                <router-link 
                    :to="{
                        name: 'ProfileUserCertificate',
                        params: { 
                            certificate_id: certificate.id 
                        }
                    }">
                    <img
                        class="aspect-[3/2] w-full rounded-t-2xl object-cover"
                        :src="certificate.image" 
                        :alt="certificate.course_name">
                </router-link>
                <div class="px-6 pb-8">
                    <h3 class="mt-3 text-lg font-semibold leading-8 tracking-tight text-gray-900 dark:text-white">
                        {{ certificate.course_name }}
                    </h3>
                    <p class="text-base leading-7 text-gray-600 dark:text-gray-200">
                        {{ __('Code') }}: {{ certificate.code }}
                    </p>
                    <ul role="list" 
                        class="mt-6 flex gap-x-6">
                        <li>
                            <awesome-social-button
                                type="facebook"
                                tooltip="Facebook"
                                shape="square"
                                :width="40"
                                :link="getShareUrl('facebook', certificate)" dark />
                        </li>
                        <li>
                            <awesome-social-button
                                type="twitter"
                                tooltip="Twitter"
                                shape="square"
                                :width="40"
                                :link="getShareUrl('twitter', certificate)" dark />
                        </li>
                        <li>
                            <awesome-social-button
                                type="linkedin"
                                tooltip="LinkedIn"
                                shape="square"
                                :width="40"
                                :link="getShareUrl('linkedin', certificate)" dark />
                        </li>
                    </ul>
                </div>
            </li>
            <li 
                v-if="certificates.length == 0" 
                class="mt-8 text-center text-gray-600 dark:text-gray-400">
                <div class="text-2xl">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <p class="mt-4">
                    {{ __('No certificates yet') }}
                </p>
            </li>
        </ul>
    </div>
</template>
<script>
    import { indexModel as indexCertificatesModel, getShareUrl } from '@models/certificate'
    import { defineAsyncComponent } from 'vue';

    export default {
        components: {
            // Docs: https://github.com/logicspark/awesome-social-button#readme
            AwesomeSocialButton: defineAsyncComponent(() => import('awesome-social-button').then(m => m.AwesomeSocialButton)),
        },
        data() {
            return {
                certificates: [],
            }
        },
        async mounted() {
            this.fetchData();
        },
        watch: {
            user() {
                this.fetchData();
            }
        },
        computed: {
            user() {
                return this.$store.state.adminPublicProfile.user;
            },
            isHeadTeacher() {
                return this.$store.state.adminPublicProfile.isHeadTeacher;
            }
        },
        methods: {
            async fetchData() {
                if(!this.user) return;
                let res = await indexCertificatesModel({
                    paginate: 3,
                    orderBy: 'created_at',
                    sortedBy: 'desc',
                    load_user: true,
                    user_id: this.user.id
                });
                let certificates = res.data.map(certificate => {
                    certificate.user_id = certificate.user_id || certificate.user.id;
                    return certificate;
                });
                this.certificates = certificates;
            },
            getShareUrl(platform, certificate) {
                return getShareUrl(platform, certificate);
            }
        }
    }
</script>
