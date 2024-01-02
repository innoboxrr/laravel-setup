<template>
	
	<div
		v-if="dataLoaded" 
		class="card bg-white dark:bg-slate-700 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">
		
		<dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
		
			<div class="sm:col-span-1">
				<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
				<dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ user.name }}</dd>
			</div>
		
			<div class="sm:col-span-1">
				<dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
				<dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ user.email }}</dd>
			</div>
			<!-- Repite para otros campos como status, country_id, etc. -->
		
		</dl>

	</div>

</template>

<script>

	import { showModel } from '@models/user';
	
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

					this.user = res;

					this.dataLoaded = true;

				})

			},	

	    }

	}

</script>