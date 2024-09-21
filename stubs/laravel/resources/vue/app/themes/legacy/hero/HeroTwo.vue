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
            <div 
				class="mx-auto max-w-2xl px-4 flex-shrink-0 lg:mx-0 lg:max-w-xl lg:pt-8 -mt-12">
                <div class="mt-4">
                    <span 
                        class="inline-flex space-x-6">
						<a :href="props.badge_link">
							<span class="rounded-full bg-blue-500/10 px-3 py-1 text-sm font-semibold leading-6 text-blue-400 ring-1 ring-inset ring-blue-500/20">
								{{ props.badge }}
							</span>
						</a>
						<a :href="props.badge_value_link">
							<span class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-gray-300">
								<span>
									{{ props.badge_value }}
								</span>
								<ChevronRightIcon 
									class="h-5 w-5 text-gray-500" 
									aria-hidden="true" />
							</span>
						</a>
                    </span>
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
            <div 
				class="w-full h-[20rem] sm:h-[30rem] lg:h-[35rem] overflow-hidden ml-4 mt-4 sm:-mt-16 relative" 
				style="perspective: 700px;">
                <div 
					class="grid grid-cols-3 gap-12 w-[60rem] sm:w-[80rem] lg:w-[50rem] h-[55rem] md:h-[90rem] lg:h-[75rem] overflow-hidden origin-[50%_0%]" 
					style="transform: translate3d(7%, -2%, 0px) scale3d(0.9, 0.8, 1) rotateX(15deg) rotateY(-9deg) rotateZ(32deg);">
                    <div class="grid gap-9 w-full h-[440px] animation-sliding-img-up-1">
                        <img 
							v-for="img in props.imgs_1"
							:src="img"
							class="w-full object-cover shadow-lg rounded-lg dark:shadow-neutral-900/80 dark:hidden" 
							alt="Hero Image">
                    </div>

                    <div class="grid gap-9 w-full h-[440px] animation-sliding-img-down-1">
                        <img
							v-for="img in props.imgs_2"
							:src="img"
							class="w-full object-cover shadow-lg rounded-lg dark:shadow-neutral-900/80 dark:hidden" 
							alt="Hero Image">
                    </div>

                    <div class="grid gap-9 w-full h-[440px] animation-sliding-img-up-2">
                        <img 
							v-for="img in props.imgs_3"
							:src="img"
							class="w-full object-cover shadow-lg rounded-lg dark:shadow-neutral-900/80 dark:hidden" 
							src="https://preline.co/assets/thumbnails/hero/card-1.webp" 
							alt="Hero Image">
                    </div>
                </div>
                <div		
					v-if="props.display_play_button == 'true'" 
					class="absolute inset-0 size-full">
                    <div class="flex flex-col justify-center items-center size-full">
                        <a 
							class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" 
							@click="showLightbox = true"
							target="_parent">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            {{ props.play_button_text }}
                        </a>
                    </div>
                </div>
				<video-lightbox
					:showLightbox="showLightbox"
					:src="props.video"
					@close="showLightbox = false"/>
            </div>
        </div>
    </div>
</template>

<script>
    import { ChevronRightIcon } from '@heroicons/vue/20/solid'
	import { VideoLightbox } from '@app/components/utils';
    export default {
        components: {
            ChevronRightIcon
        },
        props: {
            props: {
                type: Object,
                default: () => ({})
            }
        },
		data() {
			return  {
				showLightbox: false
			}
		}
    }
</script>

<style scoped>

	@keyframes sliding-img-up-1 {
	0% {
		transform: translateY(0);
	}

	100% {
		transform: translateY(-722px);
	}
	}

	@keyframes sliding-img-up-2 {
	0% {
		transform: translateY(0);
	}

	100% {
		transform: translateY(-1098px);
	}
	}

	@keyframes sliding-img-down-1 {
	0% {
		transform: translateY(-1161px);
	}

	100% {
		transform: translateY(0);
	}
	}

	@keyframes sliding-img-down-2 {
	0% {
		transform: translateY(-1389px);
	}

	100% {
		transform: translateY(0);
	}
	}

	@media (min-width: 640px) {
	@keyframes sliding-img-up-1 {
		0% {
		transform: translateY(0);
		}

		100% {
		transform: translateY(-936px);
		}
	}

	@keyframes sliding-img-up-2 {
		0% {
		transform: translateY(0);
		}

		100% {
		transform: translateY(-1438px);
		}
	}

	@keyframes sliding-img-down-1 {
		0% {
		transform: translateY(-1511px);
		}

		100% {
		transform: translateY(0);
		}
	}

	@keyframes sliding-img-down-2 {
		0% {
		transform: translateY(-1135px);
		}

		100% {
		transform: translateY(0);
		}
	}
	}

	@media (min-width: 1024px) {
	@keyframes sliding-img-up-1 {
		0% {
		transform: translateY(0);
		}

		100% {
		transform: translateY(-615px);
		}
	}

	@keyframes sliding-img-up-2 {
		0% {
		transform: translateY(0);
		}

		100% {
		transform: translateY(-928px);
		}
	}

	@keyframes sliding-img-down-1 {
		0% {
		transform: translateY(-986px);
		}

		100% {
		transform: translateY(0);
		}
	}

	@keyframes sliding-img-down-2 {
		0% {
		transform: translateY(-928px);
		}

		100% {
		transform: translateY(0);
		}
	}
	}

	@keyframes sliding-img-right-1 {
	0% {
		background-position-x: 0;
	}

	100% {
		background-position-x: -2880px;
	}
	}

	@keyframes sliding-img-left-1 {
	0% {
		background-position-x: 0;
	}

	100% {
		background-position-x: 2880px;
	}
	}

	.animation-sliding-img-up-1 {
	animation: sliding-img-up-1 30s linear infinite;
	}

	.animation-sliding-img-up-2 {
	animation: sliding-img-up-2 30s linear infinite;
	}

	.animation-sliding-img-down-1 {
	animation: sliding-img-down-1 30s linear infinite;
	}


</style>