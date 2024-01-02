<template>
	
	<!-- Block start -->
    <header>

        <div class="flex justify-end items-center py-2 px-4 bg-gray-50 lg:px-6 lg:hidden m-dark:bg-gray-700">
            
            <a 
                href="#" 
                class="mr-2 text-sm font-medium text-gray-500 hover:underline m-dark:text-gray-400">

                Ventas: 729 123 4567

            </a>
            
            <a 
                href="/"
                class="inline-flex items-center p-2 text-sm font-medium text-gray-500 rounded-lg m-dark:text-gray-400 hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 m-dark:hover:bg-gray-600 focus:outline-none m-dark:focus:ring-gray-500">

                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z"
                        clip-rule="evenodd"></path>
                </svg>

            </a>

            <a 
                href="tel:729 123 4567"
                class="inline-flex items-center p-2 text-sm font-medium text-gray-500 rounded-lg m-dark:text-gray-400 hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 m-dark:hover:bg-gray-600 focus:outline-none m-dark:focus:ring-gray-500">

                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                    </path>
                </svg>

            </a>

        </div>

        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 m-dark:bg-gray-800">

            <div class="grid grid-cols-3 items-center mx-auto max-w-screen-xl">
            
                <a href="/" class="flex items-center lg:justify-center lg:order-2">
            
                    <img 
                        src="#" 
                        class="mr-3 h-6 sm:h-9" 
                        alt="appName" />
            
                    <span class="self-center text-xl font-semibold whitespace-nowrap m-dark:text-white">

                        AppName

                    </span>
            
                </a>
            
                <div class="flex col-span-2 justify-end items-center lg:order-3 lg:col-span-1">

                    <a href="tel:729 123 4567"
                        class="hidden items-center p-2 text-sm font-medium text-gray-500 rounded-lg lg:inline-flex m-dark:text-gray-400 hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 m-dark:hover:bg-gray-700 focus:outline-none m-dark:focus:ring-gray-800">

                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                            </path>
                        </svg>

                        729 123 4567

                    </a>

                    <a 
                        href="/videomeeting/join"
                        class="hidden md:block text-gray-800 m-dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 lg:py-2.5 mr-2 m-dark:hover:bg-gray-700 focus:outline-none m-dark:focus:ring-gray-800 hover:text-gray-800">

                        Entrar a reunión

                    </a>

                    <a 
                        v-if="!$store.getters['authPages/isAuth']"
                        href="/auth"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 lg:py-2.5 mr-2 m-dark:bg-blue-600 m-dark:hover:bg-blue-700 focus:outline-none m-dark:focus:ring-blue-800 hover:text-white">

                        Acceso

                    </a>

                    <a 
                        v-else
                        href="/admin"
                        class="text-gray-800 m-dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 lg:py-2.5 mr-2 m-dark:hover:bg-gray-700 focus:outline-none m-dark:focus:ring-gray-800">
                        
                        <img 
                            class="uk-border-circle" 
                            :src="$store.state.getters['authPages/userAvatar']"
                            style="height: 35px; width: 35px; object-fit: cover;" />

                    </a>

                    <button 
                        data-collapse-toggle="mobile-menu-2" 
                        uk-toggle="target: #offcanvas-menu"
                        type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 m-dark:text-gray-400 m-dark:hover:bg-gray-700 m-dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-2" 
                        aria-expanded="false">

                        <span class="sr-only">Open main menu</span>
                        
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>

                    </button>

                </div>

                <div 
                    id="mobile-menu-2"
                    class="hidden col-span-3 justify-between items-center w-full lg:flex lg:w-auto lg:order-1 lg:col-span-1">

                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    
                        <li>
                    
                            <a href="/"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100 text-blue-600 m-dark:text-blue-500 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:p-0 m-dark:hover:bg-gray-700 m-dark:hover:text-blue-500 lg:dark:hover:bg-transparent m-dark:border-gray-700"
                                aria-current="page">

                                Inicio

                            </a>
                        
                        </li>

                        <li v-if="false">
                        
                            <a 
                                href="/agents"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:p-0">

                                Agentes

                            </a>

                        </li>

                        <li>

                            <a 
                                href="/blog"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:p-0">

                                Blog

                            </a>

                        </li>

                        <li>

                            <a 
                                href="/#pricing"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:p-0">

                                Precios

                            </a>

                        </li>

                        <li>

                            <a 
                                href="/#contact"
                                class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:p-0">

                                Contacto

                            </a>

                        </li>

                    </ul>

                </div>

                <div id="offcanvas-menu" uk-offcanvas="flip: true" class="uk-dark">

                    <div class="uk-offcanvas-bar">

                        <button class="uk-offcanvas-close" type="button" uk-close></button>

                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    
                        <li>
                    
                            <a href="/"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100 text-blue-600"
                                aria-current="page">

                                Inicio

                            </a>
                        
                        </li>

                        <li v-if="false">
                        
                            <a 
                                href="/agents"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100">

                                Agentes

                            </a>

                        </li>

                        <li>
                        
                            <a 
                                href="/blog"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100">

                                Blog

                            </a>

                        </li>

                        <li>

                            <a 
                                href="/#pricing"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100">

                                Precios

                            </a>

                        </li>

                        <li>

                            <a 
                                href="/#contact"
                                class="block py-2 pr-4 pl-3 border-b border-gray-100">

                                Contacto

                            </a>

                        </li>

                    </ul>

                    </div>

                </div>

            </div>

        </nav>

    </header>
    <!-- Block end -->

</template>