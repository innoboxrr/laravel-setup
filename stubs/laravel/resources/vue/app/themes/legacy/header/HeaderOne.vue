<template>
    <header v-flowbite class="shadow-md dark">
        <nav class="border-gray-200 border-gray-600 bg-slate-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
                <a @click="$sendEvent('page_view', {})" class="flex items-center">
                    <img 
                        :src="props.logo" 
                        class="mr-3 h-6 sm:h-9" 
                        :alt="appName" />
                </a>
                <div class="flex items-center">
                    <language-dropdown-component />
                    <template v-if="$store.getters['authPages/isAuth']">
                        <div class="dark">
                            <user-dropdown-component />
                        </div>
                    </template>
                    <template v-else>
                        <router-link
                            :to="{
                                name: 'Login',
                            }"
                            class="text-sm font-medium text-blue-100 hover:underline hover:text-blue-300">
                            {{ __('Login') }}
                        </router-link>
                        <span class="mr-0 ml-2 w-px h-5 bg-slate-200 dark:bg-slate-600 lg:inline lg:mr-3 lg:ml-5"></span>
                        <router-link
                            :to="{
                                name: 'Register',
                            }"
                            class="ml-3 text-sm font-medium text-blue-100 hover:underline hover:text-blue-300">
                            {{ __('Register') }}
                        </router-link>
                    </template>
                    <span class="mr-0 ml-2 w-px h-5 bg-slate-200 dark:bg-slate-600 lg:inline lg:mr-3 lg:ml-5"></span>
                    <!--facebook-->
                    <a 
                        v-if="props.facebook" 
                        :href="props.facebook" 
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                    </a>
                    <!--instagram-->
                    <a 
                        v-if="props.instagram"
                        :href="props.instagram"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                    </a>
                    <!--twitter-->
                    <a 
                        v-if="props.twitter"
                        :href="props.twitter"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
                    </a>
                    <!--linkedin-->
                    <a
                        v-if="props.linkedin"
                        :href="props.linkedin"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">    <path d="M24,4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18c1.105,0,2-0.895,2-2V6C26,4.895,25.105,4,24,4z M10.954,22h-2.95 v-9.492h2.95V22z M9.449,11.151c-0.951,0-1.72-0.771-1.72-1.72c0-0.949,0.77-1.719,1.72-1.719c0.948,0,1.719,0.771,1.719,1.719 C11.168,10.38,10.397,11.151,9.449,11.151z M22.004,22h-2.948v-4.616c0-1.101-0.02-2.517-1.533-2.517 c-1.535,0-1.771,1.199-1.771,2.437V22h-2.948v-9.492h2.83v1.297h0.04c0.394-0.746,1.356-1.533,2.791-1.533 c2.987,0,3.539,1.966,3.539,4.522V22z"/></svg>
                    </a>
                    <!--youtube-->
                    <a
                        v-if="props.youtube"
                        :href="props.youtube"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path d="M 44.898438 14.5 C 44.5 12.300781 42.601563 10.699219 40.398438 10.199219 C 37.101563 9.5 31 9 24.398438 9 C 17.800781 9 11.601563 9.5 8.300781 10.199219 C 6.101563 10.699219 4.199219 12.199219 3.800781 14.5 C 3.398438 17 3 20.5 3 25 C 3 29.5 3.398438 33 3.898438 35.5 C 4.300781 37.699219 6.199219 39.300781 8.398438 39.800781 C 11.898438 40.5 17.898438 41 24.5 41 C 31.101563 41 37.101563 40.5 40.601563 39.800781 C 42.800781 39.300781 44.699219 37.800781 45.101563 35.5 C 45.5 33 46 29.398438 46.101563 25 C 45.898438 20.5 45.398438 17 44.898438 14.5 Z M 19 32 L 19 18 L 31.199219 25 Z"/></svg>
                    </a>
                    <!--tiktok-->
                    <a 
                        v-if="props.tiktok"
                        :href="props.tiktok"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
                    </a>
                    <!--whatsapp-->
                    <a  
                        v-if="props.whatsapp" 
                        :href="props.whatsapp"
                        class="inline-flex items-center p-2 text-sm font-medium text-blue-100 rounded-lg hover:text-blue-600 hidden md:inline"
                        target="_blank">
                        <svg class="w-4 h-4" fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px">    <path d="M25,2C12.318,2,2,12.318,2,25c0,3.96,1.023,7.854,2.963,11.29L2.037,46.73c-0.096,0.343-0.003,0.711,0.245,0.966 C2.473,47.893,2.733,48,3,48c0.08,0,0.161-0.01,0.24-0.029l10.896-2.699C17.463,47.058,21.21,48,25,48c12.682,0,23-10.318,23-23 S37.682,2,25,2z M36.57,33.116c-0.492,1.362-2.852,2.605-3.986,2.772c-1.018,0.149-2.306,0.213-3.72-0.231 c-0.857-0.27-1.957-0.628-3.366-1.229c-5.923-2.526-9.791-8.415-10.087-8.804C15.116,25.235,13,22.463,13,19.594 s1.525-4.28,2.067-4.864c0.542-0.584,1.181-0.73,1.575-0.73s0.787,0.005,1.132,0.021c0.363,0.018,0.85-0.137,1.329,1.001 c0.492,1.168,1.673,4.037,1.819,4.33c0.148,0.292,0.246,0.633,0.05,1.022c-0.196,0.389-0.294,0.632-0.59,0.973 s-0.62,0.76-0.886,1.022c-0.296,0.291-0.603,0.606-0.259,1.19c0.344,0.584,1.529,2.493,3.285,4.039 c2.255,1.986,4.158,2.602,4.748,2.894c0.59,0.292,0.935,0.243,1.279-0.146c0.344-0.39,1.476-1.703,1.869-2.286 s0.787-0.487,1.329-0.292c0.542,0.194,3.445,1.604,4.035,1.896c0.59,0.292,0.984,0.438,1.132,0.681 C37.062,30.587,37.062,31.755,36.57,33.116z"/></svg>
                    </a>
                </div>
            </div>
        </nav>
        <nav class="bg-slate-900">
            <div class="grid py-4 px-4 mx-auto max-w-screen-xl lg:grid-cols-2 md:px-6">
                <search-component />
                <div class="flex items-center lg:order-1">
                    <ul class="flex flex-row mt-0 space-x-8 text-sm font-medium">
                        <li>
                            <router-link
                                :to="{
                                    name: 'Home'
                                }" 
                                class="hidden text-white hover:text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-md shadow-md md:inline" aria-current="page">
                                {{ __('Home') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{
                                    name: 'App',
                                }"
                                class="text-white hover:text-blue-100">
                                {{ __('Dashboard') }}
                            </router-link>
                        </li>
                        <li>
                            <button
                                id="dropdown-button-megamenu"
                                data-collapse-toggle="megamenu"
                                class="flex justify-between items-center w-full font-medium md:p-0 md:w-auto text-white hover:text-blue-300 dark:focus:text-blue-500">
                                {{ __('Services') }}
                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </li>
                        <li>
                            <router-link
                                :to="{
                                    name: 'AppBrowser'
                                }"
                                class="text-white hover:text-blue-100">
                                {{ __('Browser') }}
                            </router-link>
                        </li>
                        <li v-if="false">
                            <router-link 
                                :to="{
                                    name: 'Contact'
                                }"
                                class="hidden text-white hover:text-blue-100 md:inline">
                                Contact
                            </router-link>
                        </li>
                        <li v-if="false">
                            <a href="#" class="hidden text-white hover:text-blue-100 md:inline">Pricing</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <nav 
            v-if="true" 
            id="megamenu" 
            class="hidden bg-slate-900 border-b border-blue-400">
            <div class="grid py-4 px-4 mx-auto max-w-screen-xl text-gray-900 md:grid-cols-2 lg:grid-cols-4 md:px-6">
                <ul class="col-span-2 md:col-span-1">
                    <li class="hover:text-gray-800">
                        <a 
                            @click="selectProductType('course')" 
                            class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    {{ __('Courses') }}
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    {{ __('Comprehensive on-demand learning modules.') }}
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="hover:text-gray-800">
                        <a 
                            @click="selectProductType('testkin')"
                            class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    {{ __('DBCloud Exams') }}
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    {{ __('Downloadable practice test documents.') }}
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
                <ul class="col-span-2 md:col-span-1">
                    <li class="hover:text-gray-800">
                        <a 
                            @click="selectProductType('voucher')"
                            class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    {{ __('Cert Vouchers') }}
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    {{ __('Prepaid certification exam tickets.') }}
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="hover:text-gray-800">
                        <a 
                            @click="selectProductType('package')"
                            class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    {{ __('Product Packages') }}
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    {{ __('Curated educational combo deals.') }}
                                </span>
                            </div>
                        </a>
                    </li>
                    <li v-if="false" class="hover:text-gray-800">
                        <a class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    Subscriptions
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    All-access educational content passes.
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
                <ul class="hidden lg:block">
                    <li class="hover:text-gray-800">
                        <a 
                            @click="selectProductType('quiz')"
                            class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">
                                    {{ __('Practice Quizzes') }}
                                </div>
                                <span class="text-md font-light hover:text-gray-800">
                                    {{ __('Realistic interactive test environments.') }}
                                </span>
                            </div>
                        </a>
                    </li>
                    <li v-if="false" class="hover:text-gray-800">
                        <a href="#" class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">Bootcamps</div>
                                <span class="text-md font-light hover:text-gray-800">
                                    Intensive live-streamed instruction sessions.
                                </span>
                            </div>
                        </a>
                    </li>
                    <li v-if="false" class="hover:text-gray-800">
                        <a href="#" class="flex p-3 rounded-lg hover:bg-gray-50 text-white hover:text-gray-800">
                            <svg class="mr-2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <div>
                                <div class="font-semibold">Live Classes</div>
                                <span class="text-md font-light hover:text-gray-800"> Scheduled expert-led online seminars.</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="col-span-2 p-4 lg:col-span-1">
                    <h2 class="mb-2 font-semibold text-white">Sales</h2>
                    <p class="mb-2 font-light text-gray-200 dark:text-gray-400">For tailored course packages and institutional deals, reach out to our dedicated sales team.</p>
                    <router-link 
                        :to="{ name: 'Contact' }"
                        class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-100">
                        Contact sales <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </router-link>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    import SearchComponent from './SearchComponent.vue';
    export default {
        components: {
            SearchComponent
        },
        props: {
            props: {
                type: Object,
                default: () => ({})
            }
        },
        methods: {
            selectProductType(productType) {
                this.$router.push({ 
                    path: '/app/browse/products', 
                    query: { t: productType } 
                });
            },
        }
    }
</script>