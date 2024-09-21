<template>
    <div
        v-if="props.display == 'true'" 
        class="relative isolate overflow-hidden bg-gray-900">
        <svg class="absolute inset-0 -z-10 h-full w-full stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible fill-gray-800/20">
                <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
        </svg>
        <div class="absolute left-[calc(50%-4rem)] top-10 -z-10 transform-gpu blur-2xl sm:left-[calc(50%-18rem)] lg:left-48 lg:top-[calc(50%-30rem)] xl:left-[calc(50%-24rem)]" aria-hidden="true">
            <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-[#80caff] to-[#4f46e5] opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)" />
        </div>
        <div class="mx-auto max-w-7xl px-6 pb-12 pt-10 sm:pb-16 lg:flex lg:px-8 lg:pt-20">
            <div class="mx-auto max-w-2xl px-4 flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8">
                <div class="mt-4">
                    <a 
                        :href="props.badge_link"
                        class="inline-flex space-x-6">
                        <span class="rounded-full bg-blue-500/10 px-3 py-1 text-sm font-semibold leading-6 text-blue-400 ring-1 ring-inset ring-blue-500/20">
                            {{ props.badge }}
                        </span>
                        <span class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-gray-300">
                            <span>
                                {{ props.badge_value }}
                            </span>
                            <ChevronRightIcon class="h-5 w-5 text-gray-500" aria-hidden="true" />
                        </span>
                    </a>
                </div>
                <h1 class="mt-10 text-4xl font-bold tracking-tight text-white sm:text-6xl">
                    {{ props.title }}
                </h1>
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    {{ props.message }}
                </p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a 
                        :href="props.primary_button_link"
                        class="rounded-md bg-blue-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-400">
                        {{ props.primary_button_text }}
                    </a>
                    <a 
                        :href="props.secondary_button_link"
                        class="text-sm font-semibold leading-6 text-white">
                        {{ props.secondary_button_text }}
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
            <div class="relative ms-4 -my-16 dark">
				<img 
					class="w-full rounded-md opacity-60" 
					src="https://images.unsplash.com/photo-1665686377065-08ba896d16fd?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=700&amp;h=800&amp;q=80" 
					alt="Hero Image">
				<div class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 size-full rounded-md mt-4 -mb-4 me-4 -ms-4 lg:mt-6 lg:-mb-6 lg:me-6 lg:-ms-6 dark:from-neutral-800 dark:via-neutral-900/0 dark:to-neutral-900/0"></div>

				<!-- SVG-->
				<div class="absolute bottom-0 start-0">
					<svg class="w-2/3 ms-auto h-auto text-white dark:text-neutral-900" width="630" height="451" viewBox="0 0 630 451" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="531" y="352" width="99" height="99" fill="currentColor"></rect>
						<rect x="140" y="352" width="106" height="99" fill="currentColor"></rect>
						<rect x="482" y="402" width="64" height="49" fill="currentColor"></rect>
						<rect x="433" y="402" width="63" height="49" fill="currentColor"></rect>
						<rect x="384" y="352" width="49" height="50" fill="currentColor"></rect>
						<rect x="531" y="328" width="50" height="50" fill="currentColor"></rect>
						<rect x="99" y="303" width="49" height="58" fill="currentColor"></rect>
						<rect x="99" y="352" width="49" height="50" fill="currentColor"></rect>
						<rect x="99" y="392" width="49" height="59" fill="currentColor"></rect>
						<rect x="44" y="402" width="66" height="49" fill="currentColor"></rect>
						<rect x="234" y="402" width="62" height="49" fill="currentColor"></rect>
						<rect x="334" y="303" width="50" height="49" fill="currentColor"></rect>
						<rect x="581" width="49" height="49" fill="currentColor"></rect>
						<rect x="581" width="49" height="64" fill="currentColor"></rect>
						<rect x="482" y="123" width="49" height="49" fill="currentColor"></rect>
						<rect x="507" y="124" width="49" height="24" fill="currentColor"></rect>
						<rect x="531" y="49" width="99" height="99" fill="currentColor"></rect>
					</svg>
				</div>
				<div class="absolute inset-0 size-full">
                    <div class="flex flex-col justify-center items-center size-full">
                        <a class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#" target="_parent">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Play the overview
                        </a>
                    </div>
                </div>
				<!-- End SVG-->
			</div>
        </div>
    </div>
</template>

<script>
    import { ChevronRightIcon } from '@heroicons/vue/20/solid'
    export default {
        components: {
            ChevronRightIcon
        },
        props: {
            props: {
                type: Object,
                default: () => ({})
            }
        }
    }
</script>
