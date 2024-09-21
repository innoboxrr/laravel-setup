<template>
    <div class="uk-slider-container-offset lg:mx-10 px-0 md:px-8 sm:px-12" uk-slider>
        <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
            <ul :class="gridClass">
                <li 
                    v-for="item in items"
                    :key="item.id">
                    <slot name="slider-item" :item="item"></slot>
                </li>
            </ul>
            <a class="absolute left-[30px] top-1/2 transform -translate-y-1/2 -translate-x-full bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-white w-12 h-12 flex items-center justify-center" href="#" uk-slider-item="previous">
                <i class="fa-solid fa-caret-left"></i>
            </a>
            <a class="absolute right-[30px] top-1/2 transform -translate-y-1/2 translate-x-full bg-white rounded-full p-3 shadow-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-opacity-50 focus:ring-white w-12 h-12 flex items-center justify-center" href="#" uk-slider-item="next">
                <i class="fa-solid fa-caret-right"></i>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "SliderComponent",
        emits: ['counter'],
        props: {
            route: {
                type: String,
                default: "",
            },
            filters: {
                type: Object,
                default: () => {
                    return {
                        paginate: 10
                    };
                },
            },
            columns: {
                type: Number,
                default: 4,
            },
        },
        emits: ["isEmpty"],
        data() {
            return {
                items: [],
            };
        },
        mounted() {
            this.fetchData();
        },  
        computed:{
            gridClass(){
                return `uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-${this.columns}@l uk-grid pb-12 uk-grid-small`;
            }
        },
        methods: {
            fetchData() {
                axios.get(this.route, { params: this.filters })
                    .then((response) => {
                        if (response.data.data.length === 0) {
                            this.$emit("isEmpty");
                        }
                        this.items = response.data.data;
                        this.$emit('counter', this.items.length);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        },
    };
</script>