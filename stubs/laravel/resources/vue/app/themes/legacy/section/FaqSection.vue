<template>
    <div
        v-if="props.display == 'true'" 
        class="bg-white">
        <div class="mx-auto max-w-7xl px-6 pb-16 sm:pb-24 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">
                    {{ props.title }}
                </h2>
                <p class="mt-6 text-base leading-7 text-gray-600">
                    {{ props.subtitle }}
                </p>
            </div>
            <div class="mt-20">
                <dl class="space-y-16 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-16 sm:space-y-0 lg:grid-cols-3 lg:gap-x-10">
                    <div 
                        v-for="faq in props.items" 
                        :key="faq.question">
                        <dt class="text-base font-semibold leading-7 text-gray-900">{{ faq.question }}</dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">{{ faq.answer }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        }
    }
</script>
