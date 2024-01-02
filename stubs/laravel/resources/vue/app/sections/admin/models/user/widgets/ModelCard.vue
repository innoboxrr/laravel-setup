<template>
	
	<div
		v-if="dataLoaded" 
		class="card bg-white dark:bg-slate-700 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

	    <div class="flex justify-end">

	        <button 
	        	class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" 
	        	type="button">
	            
	            <span class="sr-only">Open dropdown</span>

	            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">

	                <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>

	            </svg>

	        </button>

	        <!-- Dropdown menu -->
	        <div 
	        	uk-dropdown="mode: click;"
	        	class="uk-padding-remove z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">

	            <ul class="py-2" aria-labelledby="dropdownButton">

		            <li class="text-sm text-gray-700 dark:text-gray-200">

		                <router-link
		                	:to="{
		                		name: 'AdminShowUser',
		                		params: {
		                			id: user.id
		                		}
		                	}" 
		                	class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white hover:no-underline">

		                	<i class="fa-solid fa-eye pr-2"></i> Mostrar

		                </router-link>

		            </li>

		            <li class="text-sm text-gray-700 dark:text-gray-200">

		                <router-link
		                	:to="{
		                		name: 'AdminEditUser',
		                		params: {
		                			id: user.id
		                		}
		                	}" 
		                	class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white hover:no-underline">

		                	<i class="fa-solid fa-pen-to-square pr-2"></i> Editar

		                </router-link>

		            </li>

		            <li class="text-sm text-gray-700 dark:text-gray-200">

		                <a 
		                	@click="deleteUser" 
		                	class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white hover:no-underline">

		                	<i class="fa-solid fa-trash-can pr-2"></i> Eliminar

		                </a>

		            </li>

	            </ul>

	        </div>

	    </div>

	    <div class="flex flex-col items-center pb-10">
	        
	        <img 
	        	class="w-24 h-24 mb-3 rounded-full shadow-sm" 
	        	:src="user.avatar_url" />

	        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
	        	
	        	{{ user.name }}

	        </h5>

			<div v-if="false" class="flex mt-4 space-x-3 md:mt-6">

				<a 
	            	class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white hover:text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">

	            	Botón A

	            </a>

	            <a 
	            	class="uk-link-reset inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">

	            	Botón B

	            </a>
        	
        	</div>

	    </div>

	</div>

</template>

<script>

	import { showModel, deleteModel } from '@models/user';
	
	export default {

		props: {

			user: {
				type: Object,
				required: false,
			},

			userId: {
				type: [Number, String],
				required: false
			}

		},

		data() {

			return {

				dataLoaded: true

			}
		
		},

		created() {
	
	        // Asegurarse de que al menos uno de los dos props esté definido.
	        if (!this.user && !this.userId) {
	
	            console.error("Se debe proporcionar 'user' o 'userId'.");
	
	        }
	
	    },

		mounted() {

			if (!this.user && this.userId) {

				this.fetchUser();

			} else {

				this.dataLoaded = true;

			}

		},	

	    methods: {

			fetchUser() {

				showModel(this.userId).then( res => {

					this.user = res.data;

					this.dataLoaded = true;

				})

			},	

	    	deleteUser() {

	    		deleteModel(this.user).then( res => {

	    			this.$router.push({ name: 'AdminUsers' });

	    		})

	    	}

	    }

	}

</script>