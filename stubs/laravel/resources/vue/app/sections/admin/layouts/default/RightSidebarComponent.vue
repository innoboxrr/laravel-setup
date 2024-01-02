<template>

    <aside class="hidden lg:block fixed right-0 top-0 bottom-0 z-30 w-16 h-full bg-white border-l border-gray-200 dark:bg-gray-800 dark:border-gray-700 pt-14">
    
        <div class="divide-y divide-gray-100 dark:divide-gray-700">

            <ul class="space-y-2 py-5 px-3">

                <!-- Chat: Chat with other students-->
                <li>
                    
                    <a 
                        href="/chat"
                        data-tooltip-target="tooltip-chat" 
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                        <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 18" fill="currentColor">
                            <path d="M18 4H16V9C16 10.0609 15.5786 11.0783 14.8284 11.8284C14.0783 12.5786 13.0609 13 12 13H9L6.846 14.615C7.17993 14.8628 7.58418 14.9977 8 15H11.667L15.4 17.8C15.5731 17.9298 15.7836 18 16 18C16.2652 18 16.5196 17.8946 16.7071 17.7071C16.8946 17.5196 17 17.2652 17 17V15H18C18.5304 15 19.0391 14.7893 19.4142 14.4142C19.7893 14.0391 20 13.5304 20 13V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4Z" fill="currentColor"/>
                            <path d="M12 0H2C1.46957 0 0.960859 0.210714 0.585786 0.585786C0.210714 0.960859 0 1.46957 0 2V9C0 9.53043 0.210714 10.0391 0.585786 10.4142C0.960859 10.7893 1.46957 11 2 11H3V13C3 13.1857 3.05171 13.3678 3.14935 13.5257C3.24698 13.6837 3.38668 13.8114 3.55279 13.8944C3.71889 13.9775 3.90484 14.0126 4.08981 13.996C4.27477 13.9793 4.45143 13.9114 4.6 13.8L8.333 11H12C12.5304 11 13.0391 10.7893 13.4142 10.4142C13.7893 10.0391 14 9.53043 14 9V2C14 1.46957 13.7893 0.960859 13.4142 0.585786C13.0391 0.210714 12.5304 0 12 0Z" fill="currentColor"/>
                        </svg>

                        <span class="sr-only"></span>

                    </a>

                    <div 
                        id="tooltip-chat" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Chat <div class="tooltip-arrow" data-popper-arrow></div>

                    </div>

                </li>
                
                <!-- Calendar: Assignments, Quiz and Course Calendar-->
                <li>

                    <a
                        href="/calendar" 
                        data-tooltip-target="tooltip-calendar"
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"></path>
                        </svg>

                        <span class="sr-only"></span>

                    </a>

                    <div 
                        id="tooltip-calendar" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Calendario <div class="tooltip-arrow" data-popper-arrow></div>

                    </div>

                </li>

                <!-- Groups -->
                <li>
                    
                    <a 
                        href="/groups"
                        data-tooltip-target="tooltip-groups" 
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        
                        <span class="sr-only"></span>

                    </a>
                    
                    <div 
                        id="tooltip-groups" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Grupos <div class="tooltip-arrow" data-popper-arrow></div>

                    </div>

                </li>

                <!-- Cursos -->
                <li>
                    
                    <a 
                        href="/courses"
                        data-tooltip-target="tooltip-courses" 
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 hover:no-underline">

                        <i class="fa-solid fa-chalkboard-user py-1"></i>
                        
                        <span class="sr-only"></span>

                    </a>
                    
                    <div 
                        id="tooltip-courses" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Cursos <div class="tooltip-arrow" data-popper-arrow></div>
                        
                    </div>

                </li>

            </ul>

            <ul class="space-y-2 py-5 px-3">

                <!-- Estadísticas -->
                <li>
                    
                    <a 
                        pth="/reports"
                        data-tooltip-target="tooltip-reports" 
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z"></path>
                        </svg>
                        
                        <span class="sr-only"></span>

                    </a>
                    
                    <div 
                        id="tooltip-reports" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Reportes <div class="tooltip-arrow" data-popper-arrow></div>
                        
                    </div>

                </li>

                <!-- Construir curso -->
                <li>
                    
                    <a 
                        href="/create"
                        data-tooltip-target="tooltip-add-course" 
                        data-tooltip-placement="left" 
                        class="flex items-center p-2 text-gray-500 rounded-lg transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">

                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.546.5a9.5 9.5 0 1 0 9.5 9.5 9.51 9.51 0 0 0-9.5-9.5ZM13.788 11h-3.242v3.242a1 1 0 1 1-2 0V11H5.304a1 1 0 0 1 0-2h3.242V5.758a1 1 0 0 1 2 0V9h3.242a1 1 0 1 1 0 2Z"/>
                        </svg>
                        
                        <span class="sr-only"></span>

                    </a>
                    
                    <div 
                        id="tooltip-add-course" 
                        role="tooltip" 
                        class="inline-block absolute invisible z-10 py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip"> 
                        
                        Añadir <div class="tooltip-arrow" data-popper-arrow></div>
                        
                    </div>

                </li>

            </ul>

        </div>

    </aside>

</template>