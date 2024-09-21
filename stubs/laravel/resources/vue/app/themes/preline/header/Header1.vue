<template>
    <header 
        v-if="props.display"
        v-preline
        class="sticky mt-4 top-4 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full before:absolute before:inset-0 before:max-w-[66rem] before:mx-2 before:lg:mx-auto before:rounded-[26px] before:bg-gray-800 before:backdrop-blur-md">
        <nav class="relative max-w-[66rem] w-full py-2.5 ps-5 pe-2 md:flex md:items-center md:justify-between md:py-0 mx-2 lg:mx-auto ">
            <div class="flex items-center justify-between">
                <a 
                    class="flex-none rounded-md text-xl inline-block font-semibold focus:outline-none focus:opacity-80" 
                    href="/"
                    aria-label="Preline">
                    <img 
                        class="h-8" 
                        :src="props.logo"
                        :alt="appName">
                </a>

                <div class="md:hidden">
                    <button type="button" class="hs-collapse-toggle size-8 flex justify-center items-center text-sm font-semibold rounded-full bg-gray-800 text-white disabled:opacity-50 disabled:pointer-events-none" id="hs-navbar-floating-dark-collapse" aria-expanded="false" aria-controls="hs-navbar-floating-dark" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-floating-dark">
                        <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                        <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
            </div>

            <div id="hs-navbar-floating-dark" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block" aria-labelledby="hs-navbar-floating-dark-collapse">
                <div class="flex flex-col md:flex-row md:items-center md:justify-end py-2 md:py-0 md:ps-7">

                    <a class="p-3 ps-px sm:px-3 md:py-4 text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="../templates/agency/index.html" aria-current="page">
                        Home
                    </a>

                    <a class="p-3 ps-px sm:px-3 md:py-4 text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                        Contact
                    </a>

                    <a class="p-3 ps-px sm:px-3 md:py-4 text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                        Become Teacher
                    </a>

                    <div
                        class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none] [--is-collapse:true] md:[--is-collapse:false] p-3 ps-px sm:px-3 md:py-4">
                        <button id="hs-dropdown-floating-dark" type="button" class="hs-dropdown-toggle flex items-center w-full text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            Products
                            <svg class="hs-dropdown-open:-rotate-180 md:hs-dropdown-open:rotate-0 duration-300 shrink-0 ms-auto md:ms-1 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-48 hidden z-10 bg-gray-800 md:shadow-md rounded-lg before:absolute top-full before:-top-5 before:start-0 before:w-full before:h-5" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-floating-dark">
                            <div class="py-1 md:px-1 space-y-1">
                                <a class="flex items-center gap-x-3.5 py-2 md:px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Courses
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Downloads
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Quizzes
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Packages
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Certifications
                                </a>
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-white hover:text-gray-300 focus:outline-none focus:text-gray-300" href="#">
                                    Plans
                                </a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a class="group inline-flex items-center gap-x-2 py-2 px-3 bg-[#ff0] font-medium text-sm text-gray-800 rounded-full focus:outline-none" href="../templates/agency/index.html#contact">
                            <i class="fas fa-search group-hover:text-gray-800"></i>
                            Search
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        props: {
            props: {
                type: Object,
                default: () => ({})
            }
        },
    }
</script>