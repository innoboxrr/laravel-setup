<template>
    
    <aside 
        class="fixed top-0 left-0 z-40 w-64 sm:pt-0 pt-16 h-screen transition-transform -translate-x-full bg-white border-r bg-tec-blue border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" 
        aria-label="Sidenav" 
        id="drawer-navigation">
        
        <div class="overflow-y-auto pb-5 px-3 h-full bg-blue-800 dark:bg-gray-800">

            <a class="flex items-center justify-center" href="/">
                
                <div class="flex mx-3">
                
                    <img 
                        src="#" 
                        class="w-40 py-4"
                        alt="Orlab 2.0">
                
                </div>

            </a>

            <ul class="space-y-2">
                
                <li>
                
                    <router-link 
                        :to="{
                            name: 'Dashboard'
                        }"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg dark:text-white hover:no-underline hover:bg-blue-700 hover:text-white dark:hover:bg-gray-700 group">
                
                        <svg aria-hidden="true" class="w-6 h-6 text-gray-300 transition duration-75 dark:text-gray-400 group-hover:text-gray-100 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                
                        <span class="ml-3">Inicio</span>
                
                    </router-link>
                
                </li>

                <li v-if="true">
                    <button
                        type="button" 
                        class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-blue-700 dark:text-white dark:hover:bg-gray-700" 
                        aria-controls="teacher-dropdown-pages" 
                        data-collapse-toggle="teacher-dropdown-pages">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 group-hover:text-gray-100 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Profesor</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="teacher-dropdown-pages" class="hidden py-2 space-y-2">
                        <li>
                            <router-link 
                                :to="{
                                    name: 'TeacherDashboard'
                                }" 
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                Panel de control
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{
                                    name: 'TeacherStudents'
                                }"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                Mis Alumnos
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{
                                    name: 'TeacherCourses'
                                }"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                Mis Cursos
                            </router-link>
                        </li>
                    </ul>
                </li>

                <li v-if="true">
                    <button 
                        type="button" 
                        class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:bg-blue-700 dark:text-white dark:hover:bg-gray-700" 
                        aria-controls="student-dropdown-pages" 
                        data-collapse-toggle="student-dropdown-pages">
                        
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 group-hover:text-gray-100 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                        </svg>
                        
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Estudiante</span>
                        
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>

                    </button>

                    <ul id="student-dropdown-pages" class="hidden py-2 space-y-2">
                        <li>
                            <router-link 
                                :to="{
                                    name: 'StudentDashboard'
                                }" 
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                Panel de control
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                :to="{
                                    name: 'StudentCourses'
                                }"
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                Mis Cursos
                            </router-link>
                        </li>
                    </ul>
                </li>

                <!-- Pending. Implementar un módulo de Chat y hacer que sea acceda desde aquí -->
                <li v-if="true">
                    <a href="#" class="flex items-center p-2 text-base font-medium text-white rounded-lg dark:text-white hover:no-underline hover:bg-blue-700 hover:text-white dark:hover:bg-gray-700 group ">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 dark:text-gray-400 group-hover:text-gray-100 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Mensajes</span>
                        <span class="inline-flex justify-center items-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100 dark:bg-primary-200 dark:text-primary-800"> 12 </span>
                    </a>
                </li>

                <li v-if="$store.getters['authPages/isAdmin']">
                    <button type="button" class="flex items-center p-2 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-authentication" data-collapse-toggle="dropdown-authentication">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 group-hover:text-gray-100 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Administración</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-authentication" class="hidden py-2 space-y-2">
                        
                        <li v-for="adminRoute in adminRoutes" :key="adminRoute.name">
                        
                            <router-link
                                :to="{
                                    name: adminRoute.name
                                }" 
                                class="flex items-center p-2 pl-11 w-full text-base font-medium text-white rounded-lg transition duration-75 group hover:no-underline hover:bg-blue-700 hover:text-white dark:text-white dark:hover:bg-gray-700">
                                
                                {{ adminRoute.title  }}
                            
                            </router-link>

                        </li>

                    </ul>
                </li>
            </ul>

            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">

                <li>

                    <a href="#" class="flex items-center p-2 text-base font-medium text-white rounded-lg transition duration-75 hover:no-underline hover:bg-blue-700 hover:text-white dark:hover:bg-gray-700 dark:text-white group">
                        
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 dark:text-gray-400 group-hover:text-gray-100 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>

                        <span class="ml-3">Documentación</span>

                    </a>

                </li>
                
                <li>
                
                    <a href="#" class="flex items-center p-2 text-base font-medium text-white rounded-lg transition duration-75 hover:no-underline hover:bg-blue-700 hover:text-white dark:hover:bg-gray-700 dark:text-white group">
                
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 dark:text-gray-400 group-hover:text-gray-100 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"></path>
                        </svg>
                
                        <span class="ml-3">Ayuda</span>
                
                    </a>
                
                </li>

                <li>
                
                    <a 
                        v-if="$store.getters['authPages/userId'] === 1"
                        class="flex items-center p-2 text-base font-medium text-white rounded-lg transition duration-75 hover:no-underline hover:bg-blue-700 hover:text-white dark:hover:bg-gray-700 dark:text-white group"
                        @click="$httpRequest('POST', '/app-update')">

                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-gray-300 transition duration-75 dark:text-gray-400 group-hover:text-gray-100 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                        </svg>
                
                        <span class="ml-3">Actualizar sistema</span>
                
                    </a>
                
                </li>

                <li v-if="true" class="text-xs">
                    V1.0.0
                </li>

            </ul>

        </div>

    </aside>

</template>

<script>

    import data from '@json/adminRoutes.json';

    export default {

        data() {

            return {

                adminRoutes: data.adminRoutes,

            }

        }

    }

</script>