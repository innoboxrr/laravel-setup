<template>
    <section v-flowbite class="antialiased">
        <h3 class="text-lg font-bold dark:text-white mb-4">
            My <span class="text-blue-500">activity</span>
        </h3>
        <div class="max-w-2xl mx-auto px-4">
            <article class="p-4 lg:p-6 mb-6 text-base bg-white border border-gray-100 dark:border-gray-700 rounded-lg dark:bg-gray-800">
                <div class="flex">
                    <div class="mr-4">
                        <div class="rounded-lg bg-gray-100 w-9 flex flex-col items-center justify-center font-medium dark:bg-gray-700">
                            <button type="button" class="text-gray-500 dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-t-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">+</button>
                            <span class="text-gray-900 font-medium py-1 px-2 lg:px-0 text-xs lg:text-sm dark:text-white">14</span>
                            <button type="button" class="text-gray-500  dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-b-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">-</button>
                        </div>
                    </div>
                    <div class="w-full">
                        <footer class="flex justify-between items-center mb-2 w-full">
                            <a href="#" class="flex items-center">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                     alt="Bonnie Green">
                                <p class="inline-flex flex-col md:flex-row items-start mr-3 text-sm text-gray-900 dark:text-white">
                                    <span class="font-semibold">Bonnie Green</span>
                                    <time class="text-sm text-gray-600 dark:text-gray-400 md:ml-2" pubdate datetime="2022-03-15"
                                          title="March 15th, 2022">Mar. 15, 2022</time>
                                </p>
                            </a>
                            <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownComment1"
                                 class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">The article covers the essentials, challenges, myths and stages the UX designer should consider while creating the design strategy.</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L12.414 16H20a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM7.5 11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
                                </svg>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="ml-6 lg:ml-12 p-4 lg:p-6 mb-6 text-base bg-white border border-gray-100 dark:border-gray-700 rounded-lg dark:bg-gray-800">
                <div class="flex">
                    <div class="mr-4">
                        <div class="rounded-lg bg-gray-100 w-9 flex flex-col items-center justify-center font-medium bg-gray-100 dark:bg-gray-700">
                            <button type="button" class="text-gray-500 dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-t-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">+</button>
                            <span class="text-gray-900 font-medium py-1 px-2 lg:px-0 text-xs lg:text-sm dark:text-white">3</span>
                            <button type="button" class="text-gray-500  dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-b-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">-</button>
                        </div>
                    </div>
                    <div class="w-full">
                        <footer class="flex justify-between items-center mb-2 w-full">
                            <a href="#" class="flex items-center">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                     alt="Jese Leos">
                                <p class="inline-flex flex-col md:flex-row items-start mr-3 text-sm text-gray-900 dark:text-white">
                                    <span class="font-semibold">Jese Leos</span>
                                    <time class="text-sm text-gray-600 dark:text-gray-400 md:ml-2" pubdate datetime="2022-02-12"
                                          title="February 12th, 2022">Feb. 12, 2022</time>
                                </p>
                            </a>
                            <button id="dropdownComment2Button" data-dropdown-toggle="dropdownComment2"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownComment2"
                                 class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">Much appreciated! Glad you liked it ☺️</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L12.414 16H20a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM7.5 11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
                                </svg>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="p-4 lg:p-6 mb-6 text-base bg-white border border-gray-100 dark:border-gray-700 rounded-lg dark:bg-gray-800">
                <div class="flex">
                    <div class="mr-4">
                        <div class="rounded-lg bg-gray-100 w-9 flex flex-col items-center justify-center font-medium dark:bg-gray-700">
                            <button type="button" class="text-gray-500 dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-t-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">+</button>
                            <span class="text-gray-900 font-medium py-1 px-2 lg:px-0 text-xs lg:text-sm dark:text-white">12</span>
                            <button type="button" class="text-gray-500  dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-b-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">-</button>
                        </div>
                    </div>
                    <div class="w-full">
                        <footer class="flex justify-between items-center mb-2 w-full">
                            <a href="#" class="flex items-center">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                                     alt="Danny Hart">
                                <p class="inline-flex flex-col md:flex-row items-start mr-3 text-sm text-gray-900 dark:text-white">
                                    <span class="font-semibold">Danny Hart</span>
                                    <time class="text-sm text-gray-600 dark:text-gray-400 md:ml-2" pubdate datetime="2022-02-08"
                                          title="February 8th, 2022">Feb. 8, 2022</time>
                                </p>
                            </a>
                            <button id="dropdownComment3Button" data-dropdown-toggle="dropdownComment3"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownComment3"
                                 class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">Very straight-to-point article. Really worth time reading. Thank you! But tools are just the
                            instruments for the UX designers. The knowledge of the design tools are as important as the
                            creation of the design strategy.</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L12.414 16H20a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM7.5 11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
                                </svg>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="p-4 lg:p-6 mb-6 text-base bg-white border border-gray-100 dark:border-gray-700 rounded-lg dark:bg-gray-800">
                <div class="flex">
                    <div class="mr-4">
                        <div class="rounded-lg bg-gray-100 w-9 flex flex-col items-center justify-center font-medium dark:bg-gray-700">
                            <button type="button" class="text-gray-500 dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-t-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">+</button>
                            <span class="text-gray-900 font-medium py-1 px-2 lg:px-0 text-xs lg:text-sm dark:text-white">8</span>
                            <button type="button" class="text-gray-500  dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-b-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">-</button>
                        </div>
                    </div>
                    <div class="w-full">
                        <footer class="flex justify-between items-center mb-2 w-full">
                            <a href="#" class="flex items-center">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="https://flowbite.com/docs/images/people/profile-picture-3.jpg"
                                     alt="Bonnie Green">
                                <p class="inline-flex flex-col md:flex-row items-start mr-3 text-sm text-gray-900 dark:text-white">
                                    <span class="font-semibold">Bonnie Green</span>
                                    <time class="text-sm text-gray-600 dark:text-gray-400 md:ml-2" pubdate datetime="2022-03-15"
                                          title="March 15th, 2022">Mar. 15, 2022</time>
                                </p>
                            </a>
                            <button id="dropdownComment4Button" data-dropdown-toggle="dropdownComment4"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownComment4"
                                 class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">The article covers the essentials, challenges, myths and stages the UX designer should consider while creating the design strategy.</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L12.414 16H20a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM7.5 11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
                                </svg>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </article>
            <article class="p-4 lg:p-6 mb-6 text-base bg-white border border-gray-100 dark:border-gray-700 rounded-lg dark:bg-gray-800">
                <div class="flex">
                    <div class="mr-4">
                        <div class="rounded-lg bg-gray-100 w-9 flex flex-col items-center justify-center font-medium dark:bg-gray-700">
                            <button type="button" class="text-gray-500 dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-t-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">+</button>
                            <span class="text-gray-900 font-medium py-1 px-2 lg:px-0 text-xs lg:text-sm dark:text-white">32</span>
                            <button type="button" class="text-gray-500  dark:text-gray-400 py-1 dark:hover:bg-gray-600 rounded-b-lg hover:bg-gray-200 w-full focus:ring-2 focus:outline-none focus:ring-gray-50 dark:bg-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-600">-</button>
                        </div>
                    </div>
                    <div class="w-full">
                        <footer class="flex justify-between items-center mb-2 w-full">
                            <a href="#" class="flex items-center">
                                <img class="mr-2 w-6 h-6 rounded-full"
                                     src="https://flowbite.com/docs/images/people/profile-picture-4.jpg"
                                     alt="Helene Engels">
                                <p class="inline-flex flex-col md:flex-row items-start mr-3 text-sm text-gray-900 dark:text-white">
                                    <span class="font-semibold">Helene Engels</span>
                                    <time class="text-sm text-gray-600 dark:text-gray-400 md:ml-2" pubdate datetime="2022-06-23"
                                          title="June 23rd, 2022">Jun. 23, 2022</time>
                                </p>
                            </a>
                            <button id="dropdownComment5Button" data-dropdown-toggle="dropdownComment5"
                                    class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 dark:text-gray-400 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                    type="button">
                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                    <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                </svg>
                                <span class="sr-only">Comment settings</span>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownComment5"
                                 class="hidden z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                    </li>
                                </ul>
                            </div>
                        </footer>
                        <p class="text-gray-500 dark:text-gray-400">Thanks for sharing this. I do came from the Backend development and explored some of the tools to design my Side Projects.</p>
                        <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                    class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="w-3.5 h-3.5 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L12.414 16H20a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2ZM7.5 11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm4.5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Z"/>
                                </svg>
                                Reply
                            </button>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
