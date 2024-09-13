<template>
	
	<div class="card bg-white dark:bg-slate-700 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

	    <div class="flex justify-end">

			<dropdown-button-component 
				:items="[
					{
						type: 'router',
						to: {
							name: 'AdminShowOption',
							params: {
								id: option.id
							}
						},
						label: 'Mostrar',
					},
					{
						type: 'router',
						to: {
							name: 'AdminEditOption',
							params: {
								id: option.id
							}
						},
						label: 'Editar',
					},
					{
						type: 'event',
						action: deleteOption,
						label: 'Eliminar',
					},
				]"/>

	    </div>

	    <div class="flex flex-col items-center pb-10">
	        
	        <img 
				v-if="false"
	        	class="w-24 h-24 mb-3 rounded-full shadow-sm" 
	        	src="https://picsum.photos/536/354" />

	        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
	        	
	        	{{ option.name }}

	        </h5>

			<div 
				v-if="false" 
				class="flex mt-4 space-x-3 md:mt-6">

				<a 
	            	class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white hover:text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">

	            	Botón A

	            </a>

	            <a 
	            	class="uk-link-reset inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 mdark:bg-gray-800 mdark:text-white mdark:border-gray-600 mdark:hover:bg-gray-700 mdark:hover:border-gray-700 mdark:focus:ring-gray-700">

	            	Botón B

	            </a>
        	
        	</div>

	    </div>

	</div>

</template>

<script>
	
	export default {

		props: {

			option: {
				type: Object,
				required: false,
			},

			optionId: {
				type: [Number, String],
				required: false
			}

		},

		created() {
	
	        if (!this.option && !this.optionId) {
	
	            console.error("Se debe proporcionar 'option' o 'optionId'.");
	
	        }
	
	    },

	    methods: {

	    	deleteOption() {

	    		deleteModel(this.option).then( res => {

	    			this.$router.push({ name: 'AdminOptions' });

	    		})

	    	}

	    }

	}

</script>