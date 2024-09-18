<template>
    <div v-if="false" class="mx-auto mx-12">
        <h3 class="font-extrabold text-2xl  text-black dark:text-white hidden"> Stories</h3>
        <div
            class="relative uk-slider"
            tabindex="-1"
            uk-slider="auto play: true; finite: true"
            uk-lightbox="">
            <div class="py-5 uk-slider-container">
                <ul
                    class="uk-slider-items w-[calc(100%+14px)]"
                    uk-scrollspy="target: > li; cls: uk-animation-scale-up; delay: 20;repeat:true"
                    style="transform: translate3d(-76px, 0px, 0px);">
                    <li
                        v-for="x in 20"
                        key="x"
                        class="md:pr-3 pr-2 hover:scale-[1.15] hover:-rotate-2 duration-300 uk-active uk-scrollspy-inview "
                        tabindex="-1"
                        style="">
                        <a
                            href="https://cdn.iconscout.com/icon/free/png-512/free-badge-1521803-1288915.png?f=webp&w=256"
                            data-caption="Esta insignia se otorga a...">
                            <div
                                class="md:w-16 md:h-16 w-12 h-12 relative md:border-4 border-2 shadow border-white rounded-full overflow-hidden dark:border-slate-700">
                                <img
                                    src="https://cdn.iconscout.com/icon/free/png-512/free-badge-1521803-1288915.png?f=webp&w=256"
                                    alt=""
                                    class="absolute w-full h-full object-cover">
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="max-md:hidden">
                <button type="button" class="absolute -translate-y-1/2 bg-white shadow rounded-full top-1/2 -left-3.5 grid w-8 h-8 place-items-center dark:bg-dark3" uk-slider-item="previous">
                    <i class="fa-solid fa-caret-left"></i>
                </button>
                <button type="button" class="absolute -right-2 -translate-y-1/2 bg-white shadow rounded-full top-1/2 grid w-8 h-8 place-items-center dark:bg-dark3" uk-slider-item="next">
                    <i class="fa-solid fa-caret-right"></i>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
</script>
