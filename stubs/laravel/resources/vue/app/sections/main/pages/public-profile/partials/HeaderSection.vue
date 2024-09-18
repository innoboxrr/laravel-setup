<template>
    <div v-if="user" class="bg-slate-200 pb-4 dark:bg-slate-800">
        <div>
            <img 
                class="h-32 w-full object-cover lg:h-48" 
                :src="user.profile_background_url" 
                alt="" />
        </div>
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                <div class="flex">
                    <router-link
                        :to="{
                            name: 'ProfileUserShow',
                            params: { 
                                user_id: user.id
                            }
                        }">
                        <img 
                            class="h-24 w-24 rounded-full ring-4 ring-white sm:h-32 sm:w-32" 
                            :src="user.avatar_url" 
                            alt="" />
                    </router-link>
                </div>
                <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                    <div class="mt-6 min-w-0 flex-1 sm:hidden md:block">
                        <h1 class="truncate text-2xl font-bold text-gray-900 dark:text-white">
                            {{ user.name }}
                        </h1>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0">
                        <!-- PENDING -->
                        <button 
                            v-if="false"
                            type="button" 
                            class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 dark:bg-slate-700 dark:text-white">
                            <EnvelopeIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            <span>Message</span>
                        </button>
                        <!-- PENDING -->
                        <button 
                            v-if="false"
                            type="button" 
                            class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-50 dark:bg-slate-700 dark:text-white">
                            <ShareIcon class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                            <span>Share</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-6 hidden min-w-0 flex-1 sm:block md:hidden">
                <h1 class="truncate text-2xl font-bold text-gray-900">{{ user.name }}</h1>
            </div>
        </div>
    </div>
</template>

<script>

    import { mapState } from 'vuex'
    import { EnvelopeIcon, ShareIcon } from '@heroicons/vue/20/solid'
    
    export default {
        components: {
            EnvelopeIcon,
            ShareIcon
        },
        computed: {
            ...mapState('adminPublicProfile', ['user']),
        },  
    }

</script>