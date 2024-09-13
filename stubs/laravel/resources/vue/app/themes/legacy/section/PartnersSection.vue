<template>
    <div
        v-if="props.display == 'true'"
        class="bg-gradient-to-tl from-slate-900 to-slate-700 pt-12 pb-12"
    >
        <h2
            class="text-center text-3xl font-semibold leading-8 text-white pb-12"
        >
            {{ props.title }}
        </h2>
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="-mx-6 grid grid-cols-2 gap-0.5 overflow-hidden sm:mx-0 sm:rounded-2xl md:grid-cols-3"
            >
                <div
                    v-for="partner in props.items"
                    class="bg-white/5 p-8 sm:p-10"
                >
                    <img
                        class="max-h-12 w-full object-contain"
                        :src="partner.logo"
                        :alt="partner.link"
                        width="158"
                        height="48"
                    />
                </div>
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
        },
    },
};
</script>
