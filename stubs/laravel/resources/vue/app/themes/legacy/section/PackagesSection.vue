<template>
    <div
        v-if="props.display == 'true'" 
        class="m-8 lg:mx-36 mb-24">
        <div class="mx-auto max-w-2xl lg:text-center my-16">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">
                {{ props.pretitle }}
            </h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                {{ props.title }}
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                {{ props.subtitle }}
            </p>
        </div>
        <slider-component
            :route="packageRoute"
            :filters="packageFilters"
            :columns="3"
            @isEmpty="showPackageSlider = false">
            <template v-slot:slider-item="slotProps">
                <package-card 
                    :show-cart="false"
                    :show-favorite="false"
                    :package="slotProps.item" 
                    :product="slotProps.item.product" />
            </template>
        </slider-component>
        <div
            v-if="props.banner_display"  
            class="bg-white">
            <div class="px-6 pt-24 sm:px-6">
                <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ props.banner_title }}
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">
                    {{ props.banner_message }}
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a 
                        :href="props.banner_button_link"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 hover:text-white">
                        {{ props.banner_button_text }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import PackageCard from '@admin/models/package/widgets/PackageCard.vue';

    export default {
        components: {
            PackageCard,
        },
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        },
        data() {
            return {
                showPackageSlider: true,
                packageRoute: route('api.package.index'),
                packageFilters: {
                    paginate: 10,
                    has_product: true,
                    load_product: true,
                    load_items_productable: true,
                    status: 'published',
                    orderBy: 'id',
                    orderMode: 'desc',
                    appends: [
                        'primary_category',
                        'price'
                    ],
                },
            }
        }
    }
</script>