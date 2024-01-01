<template>

    <div v-flowbite v-if="user">

        <!-- User -->
        <button type="button" class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
            
            <span class="sr-only">Open user menu</span>

            <img 
                class="w-8 h-8 rounded-full" 
                :src="user.avatar_url" 
                alt="user photo" />

        </button>

        <!-- Dropdown menu -->
        <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl" id="dropdown">
            
            <div class="py-3 px-4">

                <span class="block text-sm font-semibold text-gray-900 dark:text-white">

                    {{ user.name  }}

                </span>
            
                <span class="block text-sm text-gray-900 truncate dark:text-white">

                    {{ user.email  }}

                </span>
            
            </div>
            
            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">

                <li>
                    
                    <router-link 
                        :to="{ name: 'Profile' }" 
                        class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white hover:no-underline">
                        
                        Mi perfil
                    
                    </router-link>

                </li>
                
                <li>
                    
                    <router-link 
                        :to="{ name: 'ProfileEdit'}"
                        class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white hover:no-underline">
                        
                        Editar perfil
                    
                    </router-link>

                </li>

            </ul>

            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">

                <li>
                
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        href="#" 
                        class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:no-underline">
                        
                        <i class="fa-solid fa-gauge pr-2"></i>
                        
                        Escritorio
                    
                    </router-link>
                    
                </li>

                <li>
                
                    <router-link
                        :to="{ name: 'Calendar' }"
                        href="#" 
                        class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:no-underline">
                        
                        <i class="fa-solid fa-calendar-days pr-2"></i>
                        
                        Calendario
                    
                    </router-link>
                    
                </li>

                <li>
                
                    <router-link
                        :to="{ name: 'Chat' }"
                        href="#" 
                        class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:no-underline">
                        
                        <i class="fa-solid fa-comments pr-2"></i>
                        
                        Chat
                    
                    </router-link>
                    
                </li>                
                
            </ul>
            
            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
            
                <li>
            
                    <a 
                        href="#" 
                        class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:no-underline"
                        @click="$store.dispatch('authPages/logout')">
                        Cerrar sesión
                    </a>
            
                </li>
            
            </ul>

        </div>

    </div>

</template>

<script>

    import { mapState } from "vuex";

    export default {

        name: 'UserDropdownComponent',

        data() {
            return {
                //
            }
        },

        computed: {
            ...mapState('authPages', ['user'])
        },

    }

</script>