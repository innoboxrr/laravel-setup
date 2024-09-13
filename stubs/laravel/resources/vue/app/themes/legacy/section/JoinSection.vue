<template>
    <div
        v-if="props.display == 'true'" 
        class="bg-gray-900 py-12">
        <div class="relative isolate">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-2xl flex-col gap-16 bg-white/5 px-6 py-16 ring-1 ring-white/10 sm:rounded-3xl sm:p-8 lg:mx-0 lg:max-w-none lg:flex-row lg:items-center lg:py-20 xl:gap-x-20 xl:px-20">
                    <img 
                        class="h-96 w-full flex-none rounded-2xl object-cover shadow-xl lg:aspect-square lg:h-auto lg:max-w-sm" 
                        :src="props.image"
                        alt="" />
                    <div class="w-full flex-auto">
                        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            {{ props.title }}    
                        </h2>
                        <p class="mt-6 text-lg leading-8 text-gray-300">
                            {{ props.subtitle }}
                        </p>
                        <ul role="list" class="mt-10 grid grid-cols-1 gap-x-8 gap-y-3 text-base leading-7 text-white sm:grid-cols-2">
                            <li 
                                v-for="feature in props.features" 
                                :key="feature" class="flex gap-x-3">
                                <CheckCircleIcon class="h-7 w-5 flex-none" aria-hidden="true" />
                                {{ feature }}
                            </li>
                        </ul>
                        <div class="mt-10 flex">
                            <a 
                                :href="props.button_link"
                                class="text-sm font-semibold leading-6 text-indigo-400">
                                {{ props.button_text }}
                                <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute inset-x-0 -top-16 -z-10 flex transform-gpu justify-center overflow-hidden blur-3xl" aria-hidden="true">
                <div class="aspect-[1318/752] w-[82.375rem] flex-none bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-25" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)" />
            </div>
        </div>
    </div>
</template>

<script>
    import { CheckCircleIcon } from '@heroicons/vue/20/solid'
    export default {
        components: {
            CheckCircleIcon,
        },
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        }
    }
</script>
